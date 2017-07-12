#!/bin/bash -eu

set -o pipefail ;

WORKDIR="/home/liskl/docker-images/website_com-liskl" ;

LOGFILE="${WORKDIR}/$( date +'build-%Y%m%d.log' )";

echo "Changing directory to \"${WORKDIR}\"" | tee -a "${LOGFILE}";
cd "${WORKDIR}";

rm -rf "${WORKDIR}/frontend/website_root/";
rm -rf "${WORKDIR}/backend/website_root/";

echo "Copying common webfiles from \"${WORKDIR}/common\" to \"${WORKDIR}/(frontend|backend)/\"." | tee -a "${LOGFILE}";
cp -rvp "${WORKDIR}/common/website_root" "${WORKDIR}/backend/"  >> "${LOGFILE}";
cp -rvp "${WORKDIR}/common/website_root" "${WORKDIR}/frontend/" >> "${LOGFILE}";

echo "building containers for: com-liskl-frontend, com-liskl-backend " | tee -a "${LOGFILE}";
/usr/local/bin/docker-compose build >> "${LOGFILE}";
/usr/local/bin/docker-compose up -d;

#${DOCKER_BIN} build ${BUILD_OPTS} -t "${REPO}/${NAME}:${VERSION}" . ;
#${DOCKER_BIN} tag "${REPO}/${NAME}:${VERSION}" "${REPO}/${NAME}:latest" ;
#${DOCKER_BIN} push "${REPO}/${NAME}:${VERSION}" ;
#${DOCKER_BIN} push "${REPO}/${NAME}:latest" ;
