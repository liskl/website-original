#!/bin/bash
# Lets be pessimists, shall we?
# If a command pipe fails, the original command is considered to have failed
set -o pipefail
# Uninitialized variables are bad, mmmmkay?
set -u

# Colorize variables
red=$(tput setaf 1)
green=$(tput setaf 2)
yellow=$(tput setaf 3)
reset=$(tput sgr0)

# Variables
# Initial values
WARN=0
FAIL=0
PASS=0
# Software versions
PUPPET_VERSION="3.4.3"
HIERA_VERSION="1.3.2"
FACTER_VERSION="1.7.5"
# STuff we should be able to ICMP ECHO verify
INTERNET_IP="8.8.8.8"
PUPPET_FQDN="puppet-1-001.plat.adm.sjc2.mz-inc.com"
FQDN=$(hostname -f)
# The list of colos isn't case-senstive, but it is pipe-separated.
COLOS="SJC2|DAL2|MLP1"
# Misc vars.
# There has been some discussion about what to do if $VERIFIED_LOG already exists.
# The resulting consensus between Ryan, Loren, and Pavel is: Overwrite.
VERIFIED_LOG="/root/verified.txt"
VERIFY_TYPE=""
PEAKBUILD="/etc/peak-release"
# This is used to identify (maybe later) things like MapR and DB -003 
# hosts which should have more than 2 NICs.
TOTALNICS=0

function echo1 () {
  # The whole "echo ..." | tee -a $VERIFIED_LOG everywhere is boethersome. That
  # BEGS a function. So, here it is
  # Do note that this function uses echo -n, which means newlines need to be passed
  # to it.
  echo -en "${1}" | tee -a $VERIFIED_LOG
}

# Function. You keep using that word. I do not think it means what you think it means.
function ping_test() {
  description="$1"
  ip=$2
	ping_result=$(ping -qc4 $ip >/dev/null;echo1 $?)

  ## logic returning PASS or FAIL colorized
	if [ $ping_result -eq 0 ]; then
    echo1 "$description Ping: ${green}PASS${reset} | "
    PASS=$(expr $PASS + 1);
	else
    echo1 "$description Ping: ${red}FAIL${reset} | "
		FAIL=$(expr $FAIL + 1);
	fi #if [ $ping_result -eq 0 ]
}


function version_check () {
  proc="$1"
  needed_ver="$2"
  current_version=$($proc --version)
  if [ ${current_version} != ${needed_ver} ]; then
    echo1  "${red}FAIL:${reset} $proc ($current_version != $needed_ver) | "
    FAIL=$(expr $FAIL + 1)
  else
    echo1  "${green}PASS:${reset} $proc ($current_version == $needed_ver) | "
    PASS=$(expr $PASS + 1)
  fi # if [ ${current_version} != ${needed_vers} ]
}

# Let's check if we're running as root.
if [ $UID -ne 0 ]; then
  echo1 "Please run this as root!"
  exit 1
fi # if [ $UID -ne 0 ]

# Lets figure out if we're on a /dev/ttyS0 or not
# If we are, export TERM=ansi, for colour
temp=$(tty) ; curr_tty=${temp:5}
if [[ $curr_tty =~ .*ttyS*. ]]; then
  # Assuming the current login terminal is serial
  export TERM=ansi
fi # if [[ $curr_tty =~ .*ttyS*. ]]

# The use of -f (rather than -e) here is deliberate.
# -f ensures that $VERIFIED_LOG points to an actual file
# -e would merely ensure that $VERIFIED_LOG exists. It could be a symlink for
#    alle -e cares.
if [ -f ${VERIFIED_LOG} ]; then
  echo1 "${yellow}Found an existing ${VERIFIED_LOG}${reset}. Ovewriting...\n"
  echo $(date) > ${VERIFIED_LOG}
else
  echo $(date) > ${VERIFIED_LOG}
fi # if [ -f ${VERIFIED_LOG} ]

function header(){
# ${#Variable} form in bash gives the length of the variable.
# Basically, the number of chars
LENGTH=$(expr ${#1} + 3)
# There's some cleverness to be done here - for the header (and this is cosmetic)
# to cover the whole string being printed, it is simply built up one character
# at a time. Arguably, a max length check should be done, but eh.
STRING=""
CURPOS=0
  while [ $CURPOS -le $LENGTH ]; do
    STRING+="-"
    CURPOS=$(expr $CURPOS + 1)
  done
  # The header goes only to the verified.txt file, not to STDOUT, in an effort to
  # make it possible for multiple TMUXes to be used simultaneously to keep an
  # eye on things.
  echo -e "\n$STRING" >>  $VERIFIED_LOG; echo -e  "| $1 |" >>  $VERIFIED_LOG; echo -e  "$STRING\n" >> $VERIFIED_LOG
}


# This (as of 14 May 2015) is a new thing. We have /etc/peak-release being
# populated at build type by KickStart and PreSeeds (CentOS and Ubuntu,
# respectively).
# The file contains, at minimum, two things:
# "spec" and "kickstart".
# This works because there is a kickstart/pressed per build type, which makes
# setting these values deterministic.
# The idea is that when someone builds a host using a specific type, and at
# the time of verification, the person doing a cross-check will get the type
# from the build request and so can cause this code to verify what was
# requested vs what was built.
# example:
# spec=mapr-2015-003
# kickstart=mz-dellr730-xlatedb-centos.ks
#
# So, to be clear - this setup is new, and isn't in all preseeds/kickstart yet.
# The goal is to allow for catching a circumstance when what was built is not,
# in fact, what was requested by the customer.
#
# ToDo: The current iteration doesn't know about all the valid build types,
# nor knows how to verify things specific to each build type (4x1 NICs for
# MapR, et cetera). A template way is being considered, but isn't, yet
# formalized.
#
# OK, GetOpts time
while getopts "t:" opt; do
  case $opt in
    t)
      # Assuming bash 4.0 or later.
      # The ${VARIABLE,,}} syntax is a bash 4.0+ cleverness which does a quick
      # downcase converstion. Otherweise, I'd be resorting to using tr or sed,
      # and the like.
      VERIFY_TYPE=$(echo1 ${OPTARG,,})
      # Does the $PEAKBUILD file exist and is readable?
      if [ ! -r $PEAKBUILD ]; then
        echo1 "FATAL: Build type verification requested, but the type encode file isn't found ($PEAKBUILD). End. Of. Line\n"
        exit 1
      else
        # Lets source the file. That way, we can reference the $spec and
        # $kickstart variables from $PEAKBUILD.
        . $PEAKBUILD
      fi # if [ ! -r $PEAKBUILD ]
      header "Verify Build Type:"
      # The [[, =~, and .*STRING*. bits are all for having bash do regex
      # internally, without calling out to grep or perl.
      # Basically, if the contents of $spec variable contain within in the 
      # contents of the $VERIFY_TYPE variable
      if [[ $spec =~ .*$VERIFY_TYPE*. ]]; then
        echo1 "${green}PASS${reset}: Verify type ($VERIFY_TYPE) matches on-disk build type ($spec in $PEAKBUILD).\n"
      else
        echo1 "FATAL: Verify type ($VERIFY_TYPE) does NOT match build type ($spec in $PEAKBUILD).\n"
        echo1 "Cowardly refusing to proceed\n"
        exit 1
      fi # if [[ $spec =~ .*$VERIFY_TYPE*. ]]
      ;;
    \?)
      echo1 "Command line parameter parsing failed.\n"
      exit 1
      ;;
  esac # case $opt in
done # while getopts "t:" opt

# The secion below only get activated (prints its message) if -t was used
# and no type string was passed.

#if [ -z $VERIFY_TYPE ]; then
#  header "WARNING!"
#  echo1 "WARN: Build type verification not being performed."
#  echo1 "WARN: Please consider using -t (mapr|saas|redis|xlatedb|userdb|web|puppet|custom) "
#  echo1 "parameter to this script"
#  WARN=$(expr $WARN + 1)
#fi # if [ -z $VERIFY_TYPE ]



header "System information info:"
# Basic system information - like PEAK name, serial number,  and the FQDN.
# Sometimes, PEAKNAME (aka Asset Tag) is not set. This shows up differently,
# depending on HW. On Dell, it'll be "Not Specificed". On HP, just a blank.
# Both conditions are caught and accounted for.

# Since sometimes dmidecode gets clever, and outputs lines like the three below:
# SMBIOS implementations newer than version 2.7 are not
# fully supported by this version of dmidecode.
#PEAK1923
# Hence the extra grep in the pipeline.
asset_tag=$(dmidecode -s chassis-asset-tag | grep -Ev "^#")
if [[ $asset_tag != *"PEAK"* ]]; then
  echo1 "${yellow}WARN${reset}: Asset Tag seems wrong. ($asset_tag)\n"
  WARN=$(expr $WARN + 1)
else
  echo1 "${green}PASS${reset}: Asset Tag: $asset_tag\n"
  PASS=$(expr $PASS + 1)
fi # if [[ $asset_tag != *"PEAK"* ]]

chassis_sn=$(dmidecode -s chassis-serial-number | grep -Ev "^#")
chassis_manufacturer=$(dmidecode -s chassis-manufacturer | grep -Ev "^#")
chassis_model=$(dmidecode --string system-product-name | grep -Ev "^#")
echo1 "Serial Number: $chassis_sn | Manufacturer: $chassis_manufacturer | HW: $chassis_model\n"
# We only have to worry about Ubuntu and CentOS, so the logic below is pretty easy. Thankfully.
if [ -r /etc/redhat-release ]; then
  echo1 "OS: $(cat /etc/redhat-release)"
else
  echo1 "OS: $(lsb_release -ds)"
fi
# MZ uses a pretty defined FQDN structure. Normally, we expect to see 6 elements.
# This will also catch a typo in the AdminTool UIS interface (if there are too many
# periods). Maybe I'll implement a grep-based check for illegal characters in FQDN
# since UIS cannot be bothered to check the string it is passed.
hn_elements=$(echo $FQDN | awk -F '.' '{print NF}')
if [ $hn_elements -eq 6 ]; then
  echo1 "${green}PASS${reset}: FQDN $(hostname -f) ($hn_elements)\n"
  PASS=$(expr $PASS + 1)
else
  echo1 "${yellow}WARN${reset}: FQDN $(hostname -f) ($hn_elements)\n"
  WARN=$(expr $WARN + 1)
fi # if [ $hn_elements -eq 6 ]

# We seem to have a bug in UIS which drops the colo. So, let's check for it
if echo $FQDN | grep -Eqi "$COLOS"; then
  echo1 "${green}PASS${reset}: FQDN $FQDN contains a valid colo (one of $COLOS)\n"
  PASS=$(expr $PASS + 1)
else
  echo1 "${red}FAIL${reset}: FQDN $FQDN does not contain a valid colo (one of $COLOS expected)\n"
  FAIL=$(expr $FAIL + 1)
fi


header "Networking Info"
echo1 "IP Addresses: $(hostname -I)\n"

header "LLDP tools"
# What kind of checks do we want in here.
# The thorough completioust in me wants to have:
# 1. existence of /etc/lldpd.conf
# 2. veirfy that both the Asset Tag *AND* the SN are in there
# Dunno if #2 is ready yet, so leaving it alone for now (pmay, 24 Jun 2015)
# 3. lldpd is up and running.
if [ -r /etc/lldpd.conf ]; then
  echo1 "${green}PASS${reset}: LLDPD config file (/etc/lldpd.conf) exists\n"
  PASS=$(expr $PASS + 1)
else
  echo1 "${red}FAIL${reset}: LLDPD config file not found (/etc/lldpd.conf)\n"
  FAIL=$(expr $FAIL + 1)
fi

if lldpctl >/dev/null; then
  echo1 "${green}PASS${reset}: lldpctl ran happily\n"
  PASS=$(expr $PASS + 1)
  header "LLDP-derived data:"
  for nic in $(lldpctl|grep Interface | awk '{print $2}'|sed 's/,//'); do
    echo1 "\t LLDP: NIC: $nic, "
    echo1 "Switch: $(lldpctl $nic | grep "SysName:" | awk '{print $2}'),"
    echo1 "port: $(lldpctl $nic | grep "PortDescr:" | awk '{print $2}')"
    # VLAN may or may not be reported, so that's not a given
    LLDP_VLAN=$(lldpctl $nic | grep VLAN | awk '{print $2}' | sed 's/,//')
    # If the LLDP_VLAN variable has anything in it, the 'if' condition will be
    # True. Just a bit of bash cleverness that's non-obvious
    if [ $LLDP_VLAN ]; then
      echo1 ", VLAN: $LLDP_VLAN\n"
    else
      echo1 "\n"
    fi #if [ $LLDP_VLAN ]
  done
else
  echo1 "${red}FAIL${reset}: lldpctl failed somehow. Please investigate\n"
  FAIL=$(expr $FAIL + 1)
fi

header "Bonding and NIC links:"
# This code and the one right below it do double-tap the missing NIC links as failures. I'm OK with that.
# The bonding driver is what maintains the /proc/net/bonding/bondX file, and it'll *know* if a given link
# is down. The simplest way to deal with getting this information out, since it is always in the same
# sequence in the /proc/net/bonding/bondX file, is to
if [ -d /proc/net/bonding ]; then
  cd /proc/net/bonding
  for bond in *; do
    echo1 "Looking at: $bond\n"
    bond_status=$(sed -n '5p' $bond|awk '{print $NF}')
    # There are actually different bonding modes which can be configured.
    # Peak uses 802.3ad (aka 'mode 4'), so we display it.
    bond_mode=$(grep "Bonding Mode:" bond0|sed 's/Bonding Mode: //g')
    echo1 "\tStatus: $bond_status ($bond_mode)\n"
    echo1 "\tSlaves:"
    # Because we output data to a file via tee, it is not possible to simply
    # build up a line using echo1  statements. So, instead, all the slaves'
    # statuses will be built up into a string, and *that* string will be
    # tee'd out.
    slave_nics_string=""
    for slave_nic in $(grep "Slave Interface" $bond|awk '{print $NF}'); do
      slave_nics_string="$slave_nics_string $slave_nic:"
      # grep -A1 form is for getting the string containing the matching item
      # *and* the one right AFTER.
      # -B for "Before"
      # -A for "After"
      slave_status=$(grep -A1 $slave_nic $bond|grep "MII" | awk '{print $NF}')
      if [ $slave_status != "up" ]; then
        echo1 "${green}PASS${reset}"
        slave_nics_string="$slave_nics_string ${red}(FAIL:)${reset} down; "
        FAIL=$(expr $FAIL + 1)
      else
        slave_nics_string="$slave_nics_string ${green}(PASS:)${reset} up; "
        PASS=$(expr $PASS + 1)
      fi # if [ $slave_status != "up" ]
      TOTALNICS=$(expr $TOTALNICS + 1)
    done # for slave_nic in $(grep "Slave Interface" $bond|awk '{print $NF}')
    echo1 "$slave_nics_string\n"
  done # for bond in *
  echo1 "\n"
else
  echo1 "${yellow}WARN${reset}: LACP bonding does not seem to be active on this system!\n"
  WARN=$(expr $WARN + 1)
fi # if [ -d /proc/net/bonding ]

# It turned out it is possible to have a NIC up, not have a link, and the
# ip -o link output doesn't report a lack of link.
# So, we look, instead, for NICs which either have a 'NO-CARRIER' flag set,
# Or ar 'UP', but do not have a 'LOWER_UP' flag set - same as 'NO-CARRIER',
# effectively.
nic_link_issues=$(ip -o link|grep -E "NO-CARRIER|UP"| grep -v "LOWER_UP"|wc -l)
if [ $nic_link_issues -gt 0 ]; then
  echo1 "${red}FAIL${reset}: Found $nic_link_issues NICs with an apparent link down!\n"
  echo1 "${red}FAIL${reset}: See output of 'ip -o link | grep -E \"NO-CARRIER|UP\" | grep -v \"LOWER_UP\"' for details\n"
  FAIL=$(expr $FAIL + 1)
fi # if [ $nic_link_issues -gt 0 ]

# Not fully ready, but a start
# Lets check if this is a database host, and if it is, is it member #3?
# Those get SAN (NFS) mounts.
# Excludes vertdb hosts now from the NFS needed Check.
host_type=$(hostname | awk -F "-" '{print $1}')
host_member=$(hostname | awk -F "-" '{print $NF}')
# I could do this in one AND statment, but I find it easier to reason about things
# with cascading IF statements. Not as purdy, but eh.
if [[ $host_type =~ .*db.* ]]; then
  # vertdb is an exception
  if [ $host_type != "vertdb" ]; then
    if [ $host_member == "003" ]; then
      # This is a cludge. There HAS to be a better way of doing this. 
      if [ $TOTALNICS -ne 4 ]; then
        echo1 "${yellow}WARN${reset}: Expected 4 NICs, saw only $TOTALNICS\n"
        WARN=$(expr $WARN + 1)
      fi
      header "NFS/NAS/SAN check"
      # Is the rpcbind daemon running? No NFS without it.
      # Here are the two cases we have:
      # 1:
      #   Host is consuming an EMC NAS NFS mount, so it should
      #   have something in /etc/fstab, and /proc/mounts with type NFS
      # Or
      # 2: Host will be using MZ's Data Domain for NFS, but MZ configures
      #   that part without us. We should STILL give make sure that NFS
      #   daemons are installed and active, though.
      if pgrep -f rpcbind > /dev/null; then
        echo1 "${green}PASS${reset}: rpcbind is active on this (-003) host.\n"
        PASS=$(expr $PASS + 1)
      else
        echo1 "${yellow}WARN${reset}: NFS daemon (rpcbind) does not appear active, and this is a -003 host\n"
        echo1 "\t Perhaps it necessary to install and activate NFS tools?\n"
      fi # if pgrep -f rpcbind > /dev/null
      # Lets look for that SAN mount
      grep -qi nfs /etc/fstab
      nfs_in_fstab=$?
      grep -qi nfs /proc/mounts
      nfs_mounted=$?
      # This IF syntax uses a "-a", for a logical AND.
      # Both the left-hand and the right-hand of -a must evalueate to
      # TRUE before the overall expression is considered TRUE.
      if [ $nfs_mounted -eq 0 -a $nfs_in_fstab -eq 0 ]; then
        echo1 "${green}PASS${reset}: NFS mentioned in /etc/fstab: $nfs_in_fstab\n"
        echo1 "${green}PASS${reset}: NFS filesystem mounted: $nfs_mounted\n"
        PASS=$(expr $PASS + 1)
      else
        echo1 "${yellow}WARN${reset}: Please check /etc/fstab and /proc/mounts to make sure the NFS mount is setup and is in use\n"
        echo1 "\tIt is also possible that this host is slated for DataDomain use, so there may not be any current NFS mounts on it\n"
        WARN=$(expr $WARN + 1)
      fi #if [ $nfs_mounted -eq 0 ]; then
    fi # if [ $host_member == "003" ]
  fi # if [ $host_type != "vertdb" ]
fi # if [[ $host_type =~ .*db.* ]]
header "PING tests"
gateway_address=$(/sbin/ip route | awk '/default/ { print $3 }');								# the gateway address
# Sadly, MZ puts things like 'dev-deployment.addsrv.com' into the configs, and that's not what we want.
# So, for now, we use hardcoded values. A pity.
#puppet_address=$(grep "^    server" /etc/puppet/puppet.conf | awk '{ print $3 }');				# puppet master for this host
ping_test "Gateway" $gateway_address
ping_test "Internet" $INTERNET_IP
ping_test "Puppet Master" $PUPPET_FQDN
echo1 "\n"

header "Software versions:"
version_check "puppet" $PUPPET_VERSION
version_check "hiera" $HIERA_VERSION
version_check "facter" $FACTER_VERSION
echo1 '\n'

header "Disk/Mem info/Kernel version:"
lsblk | tee -a $VERIFIED_LOG
echo1 '\n'
# Looking at things like /proc/meminfo or output of "free" gives non-rounded numbers.
# They are accurate, but they're not the usual 64Gb/128Gb/et cetera. 128Gb becomes 125.9Gb.
MemSize=0
for i in $(dmidecode -t memory | grep Size | awk '{ print $2 }' |grep -v No); do
  MemSize=$(expr $MemSize + $i);
done;
echo1 "Memory Size: $(expr $MemSize / 1024)G"
# TODO: MemSize is calculated based on the DIMMs, but if a DIMM is disabled by ECC, this will not show up.
#       So, compare the output of "Free -ok" with MemSize, and if they're off by a value of a DIMM's capacity,
#       FAIL things!
echo1 '\n'
echo1 "Kernel: $(facter kernelrelease)\n"
echo1 '\n'
cat /etc/resolv.conf | grep nameserver | tee -a $VERIFIED_LOG
echo1 '\n'

header "RAID/HDD states:"
# Based on what hardware this is, different RAID hardware command line tools
# are used to query the state of things.
# Right now, we only check for broad things - no build-type-specific stuff here yet.
# LSI (Dell): https://confluence.peakhosting.com/x/x4O4
# HP's own: https://confluence.peakhosting.com/x/s47d
if [ "$(facter bios_vendor)" = "HP" ]
then
  if [ -f /usr/sbin/hpacucli ]
  then
    echo1 "System: HP, hpacucli is installed\n"
    echo1  "Storage SubSystem findings: "
    # These are crude. Making assumptions about where the HP controller is, that there's only one, et cetera
    hpacucli_vdd_all=$(hpacucli ctrl slot=1 show config|grep logicaldrive | wc -l)
    hpacucli_vdd_optimal=$(hpacucli ctrl slot=1 show config|grep logicaldrive | grep "OK" | wc -l)
    hpacucli_vdd_degraded=$(hpacucli ctrl slot=1 show config|grep logicaldrive | grep -v "OK" | wc -l)
    # Only use the RED FAIL if there are failed items found, otherwise, go green.
    if [ $hpacucli_vdd_degraded -ne 0 ]; then
      echo1 "Virtual: $hpacucli_vdd_all (${green}PASS${reset}: $hpacucli_vdd_optimal, ${red}FAIL${reset}: $hpacucli_vdd_degraded); "
      FAIL=$(expr $FAIL + 1)
    else
      echo1 "Virtual: $hpacucli_vdd_all (${green}PASS${reset}: $hpacucli_vdd_optimal, ${green}FAIL${reset}: $hpacucli_vdd_degraded); "
    fi # if [ $hpacucli_vdd_degraded -ne 0 ]
    hpacucli_pdd_all=$(hpacucli ctrl slot=1 show config | grep physicaldrive | wc -l)
    hpacucli_pdd_ready=$(hpacucli ctrl slot=1 show config | grep physicaldrive | grep "OK" | wc -l)
    hpacucli_pdd_problem=$(hpacucli ctrl slot=1 show config | grep physicaldrive | grep -v "OK" | wc -l)
    # Only use the RED FAIL if there are failed items found, otherwise, go green.
    if [ $hpacucli_pdd_problem -ne 0 ]; then
      echo1  "Physical: $hpacucli_pdd_all (${green}PASS${reset}: $hpacucli_pdd_ready, ${red}FAIL${reset}: $hpacucli_pdd_problem)\n"
      FAIL=$(expr $FAIL + 1)
    else
      echo1  "Physical: $hpacucli_pdd_all (${green}PASS${reset}: $hpacucli_pdd_ready, ${green}FAIL${reset}: $hpacucli_pdd_problem)\n"
    fi # if [ $hpacucli_pdd_problem -ne 0 ]
  else
    echo1 "System: HP ${red}FAIL${reset}: hpacucli is NOT installed!\n"
  fi # if [ -f /usr/sbin/hpacucli ]
else
  if [ -f /usr/local/sbin/megacli ]; then
    echo1 "System: Dell, MegaCLI is installed.\n"
    echo1  "Storage SubSystem findings: \n"
    # These are crude. Making assumptions about where the PERC controller is, et cetera
    megacli_vdd_all=$(megacli -LDInfo -Lall -aALL|grep "Name" | wc -l)
    megacli_vdd_degraded=$(megacli -LDInfo -Lall -aALL|grep "State" | grep "Degraded" | wc -l)
    megacli_vdd_optimal=$(megacli -LDInfo -Lall -aALL|grep "State" | grep "Optimal" | wc -l)
    if [ $megacli_vdd_degraded -ne 0 ]; then
      echo1 "Virtual: $megacli_vdd_all (${green}PASS${reset}: $megacli_vdd_optimal, ${red}FAIL${reset}: $megacli_vdd_degraded); "
      FAIL=$(expr $FAIL + 1)
    else
      echo1 "Virtual: $megacli_vdd_all (${green}PASS${reset}: $megacli_vdd_optimal, ${green}FAIL${reset}: $megacli_vdd_degraded); "
    fi # if [ $megacli_vdd_degraded -ne 0]
    megacli_pdd_all=$(megacli -PDList -aALL | grep "Slot" | wc -l)
    megacli_pdd_ready=$(megacli -PDList -aALL | grep "Firmware state:"|grep "Online" | wc -l)
    megacli_pdd_unconfigured=$(megacli -PDList -aALL | grep "Firmware state:"|grep "Unconfigured(good)" | wc -l)
    megacli_pdd_problem=$(megacli -PDList -aALL | grep "Firmware state:"|grep -vE "Online|Unconfigured\(good\)" | wc -l)
    if [ $megacli_pdd_problem -ne 0 ]; then
      echo1  "Physical: $megacli_pdd_all (${green}PASS${reset}: $megacli_pdd_ready, ${red}FAIL${reset}: $megacli_pdd_problem, Unconfigured: $megacli_pdd_unconfigured)\n"
      FAIL=$(expr $FAIL + 1)
    else
      echo1  "Physical: $megacli_pdd_all (${green}PASS${reset}: $megacli_pdd_ready, ${green}FAIL${reset}: $megacli_pdd_problem, Unconfigured: $megacli_pdd_unconfigured)\n"
    fi # if [ $megacli_pdd_problem -ne 0 ]
    if [ $megacli_pdd_unconfigured -ne 0 ]; then
      echo1 "${yellow}WARN${reset}: There are HDDs/SSDs in Unconfigured(good) state. Please double-check\n"
      WARN=$(expr $WARN + 1)
    fi # if [ $megacli_pdd_problem -ne 0 -o $megacli_vdd_degraded -ne 0 ]
  else
    echo1 "System: Dell, ${red}FAIL${reset}: Cannot find megacli!\n"
    FAIL=$(expr $FAIL + 1)
  fi # if [ -f /usr/local/sbin/megacli ]
fi # if [ "$(facter bios_vendor)" = "HP" ]

header "IPMI state"
if [ ! -c /dev/ipmi0 ]; then
  echo1 "${red}FAIL${reset}: IPMI kernel driver does not appear to be loaded\n"
  FAIL=$(expr $FAIL + 1)
else
  ipmitool_test=$(ipmitool sel list >/dev/null 2>&1;echo1 $?)
  if [ $ipmitool_test -ne 0 ]; then
    echo1 "${yellow}WARN${reset}: Failed to run ipmitool sel list. Please investigate\n"
    WARN=$(expr $WARN + 1)
  elif [ $(ipmitool sel list | wc -l ) -gt 1 ]; then
    echo1 "${yellow}WARN${reset}: Suspicious number of events in 'ipmitool sel list' output. Please investigate/clear?\n"
    WARN=$(expr $WARN + 1)
  else
    echo1 "${green}PASS${reset}: IPMI kernel driver loaded and ipmitool test successful\n"
    PASS=$(expr $PASS + 1)
  fi # if [ $ipmitool_test -ne 0 ]
fi # if [ ! -c /dev/ipmi0 ]

header "Summary:"
echo1  "Summary ${green}PASS: $PASS, ${reset}"
if [ $FAIL -ne 0 -o $WARN -ne 0 ]; then
  echo1  "${yellow}WARN: $WARN ${reset}, ${red}FAIL: $FAIL ${reset}\n"
  echo1  "\t${red}There were WARNs and/or FAILs in the output above.${reset}\n"
  # Like all well-behaved UNIX programs and scripts, we should
  # set an exit code.
  # This is useful.
  exit 1
else
  echo1 "${green}WARN: $WARN, FAIL: $FAIL${reset}\n"
  exit 0
fi # if [ $FAIL -ne 0 -o $WARN -ne 0 ]

echo1 "Output is also stored in $VERIFIED_LOG\n"

# Strip the colour codes.

sed -i -r 's/\x1B\[([0-9]{1,2}(;[0-9]{1,2})?)?[m|K]//g' $VERIFIED_LOG
