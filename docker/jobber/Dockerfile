FROM docker:stable

RUN set -eux; \
    apk add --no-cache --update \
        supervisor

RUN mkdir /etc/supervisor; \
    mkdir /etc/supervisor/conf.d; \
    mkdir /var/log/supervisor

COPY docker/jobber/supervisord.conf /etc/supervisor/supervisord.conf
COPY docker/jobber/conf.d/ /etc/supervisor/conf.d/

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
