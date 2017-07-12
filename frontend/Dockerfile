FROM alpine:latest
MAINTAINER Loren Lisk <loren.lisk@liskl.com>

ENV TIMEZONE America/New_York

RUN apk upgrade --update && \
		apk add --update openssl nginx tzdata && \
		cp /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && \
		echo "${TIMEZONE}" > /etc/timezone && \
		mkdir /etc/nginx/certificates && \
		openssl req \
			-x509 \
			-newkey rsa:2048 \
			-keyout /etc/nginx/certificates/key.pem \
			-out /etc/nginx/certificates/cert.pem \
			-days 365 \
			-nodes \
			-subj /CN=localhost && \
		mkdir -p /www /var/run/nginx/ && \
		apk del tzdata && \
		rm -rf /var/cache/apk/* ;

COPY ./website_root /www
COPY ./etc/nginx.conf /etc/nginx/nginx.conf

WORKDIR /www

#RUN chown -R www-data:www-data /www ;
#RUN chmod 777 /www ;

EXPOSE 80

ENTRYPOINT ["/usr/sbin/nginx", "-g", "daemon off;"]
