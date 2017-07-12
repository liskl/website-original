# Buildwatch - Simple script to spawn a number of tmux consoles with session labels from a list of hosts
# rking@peakhosting.com
# Based on original code by Pavel May and Loren Lisk (https://confluence.peakhosting.com/display/~pmay/TMUX+of+doom+and+despair)

# To do:
# - Check for previous sessions, option to close
# - Error handling for console sessions
# - Improve logging for data parsing later
# - Built-in functions, like ip checks, software installs, verifications, infodumps

# Changes:
# - Removed initial console to restrict panes to active console sessions - thx @ llisk
# - Fixed console logging. Note that certain console outpu
# - Improved $session_name, now uses mmddyy-second, creating unigue IDs to help manage sessions

# Usage: ./buildwatch.sh [file with one host per line]
# List file can be named anything, and must contain one peakname, host or IP per line

## Create log directory if one doesn't exist
if [ ! -d "~/console_logs" ]; then
    mkdir -p ~/console_logs
fi

## Create new session
session_name=$(date +%m%d%y-%S)
tmux new-session -d -s $session_name

# Can we read the source of hosts?
if [ $# -ne 1 ]; then
  echo "Usage: $0 filename"
  echo "Where \"filename\" is a newline-separated list of PEAK names to which to console"
fi
if [ ! -r $1 ]; then
  echo "ERROR: Cannot load $1 as a source of hosts"
  exit 1
fi
HOSTCOUNT=$(wc -l $1|awk '{print $1}')
## Split the current window into panes, tmux will default its focus into the newly-created pane
for host in $(cat $1); do
    # In each pane, print host and connect to console
    tmux split-window -v "echo $host; console $host"
    # While still focused on this pane, create log for each session
    tmux pipe-pane -o "cat >> ~/console_logs/$host.log"
done

## Remove initial console pane.
tmux select-pane -t 0
tmux kill-pane

<<<<<<< HEAD
# Sleep here is on purpose
# When the split-window above starts a console session, and that console session fails (typically,
# due to the conserver not having the host, or, perhaps, wrong colo), it takes a bit of time
# for the fail to get registerd, and for the pane to get closed.
# The 2-second sleep, then, is what allows for this fail to happen.
# Once the fail happens, the later check to compare the number of hosts we expected to have 
# consoles, vs what got actually opened has a chance to catch the discrepancy.
echo "Tried to open $HOSTCOUNT console panes."
echo "Pausing for 2 seconds to allow for console failures to close out"
sleep 2
PANES=$(tmux list-panes -t $session_name| wc -l)
if [ $? -ne 0 ]; then
  echo "ERROR:"
  echo "Session failed to start. This typically means that *none* of the consoles opened."
  echo "Please check to see if you're in the right colo"
  echo "Additionally, perhaps the conserver entries need to be added?"
elif [ $PANES -ne $HOSTCOUNT ]; then
  echo "WARNING: Tried to open $HOSTCOUNT number of panes, but only $PANES actually opened"
  echo "This means that some consoles have failed to open"
  echo "Please check to see if you're in the right colo"
  echo "Additionally, perhaps the conserver entries need to be added?"
=======
# Should this command fail - perhaps if not a single PANE was opened, the PANES variable will be blank.
PANES=$(tmux display-message -p '#{window_panes}' -t $session_name)

if [ -q $PANES ]; then
  echo "TMUX session $session_name has no panes available to be - something is off."
  echo "Cowardly refusing to proceed"
  exit 1
elif [ $PANES -ne $HOSTCOUNT ]; then
  echo "WARNING: Tried to open $HOSTCOUNT number of panes, but only $PANES actually opened"
  read -n1 -r -p "Press Enter to continue" key
>>>>>>> 9bb2e27704007fc752282973a512f98700efb13a
fi

## Shift panes to evenly distrubute them in the window
tmux select-layout tiled
## Synch input across all panes
tmux set-window-option -t $session_name synchronize-panes on

## Connect to session
tmux a -t $session_name
