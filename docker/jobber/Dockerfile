FROM docker:stable

RUN set -eux; \
    apk add --no-cache --update \
        supervisor

RUN mkdir /etc/supervisor; \
    mkdir /etc/supervisor/conf.d; \
    mkdir /var/log/supervisor

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
