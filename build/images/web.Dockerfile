FROM buckii/web-laravel

ADD app.tar /app

COPY 10-general.conf /opt/docker/etc/nginx/vhost.common.d/10-general.conf

ENV PHP_UPLOAD_MAX_FILESIZE='1G'
ENV PHP_POST_MAX_SIZE='1G'
ARG PRIMARY_COLOR

# Default Application Envs
ENV APP_DEBUG='false'
ENV APP_ENV='production'
ENV APP_KEY='base64:sK6yeEl2XZPPVsXbfFEcID7rxc2wNSBCUONwGwSmMuY='
ENV APP_LOG_LEVEL='warning'
ENV CACHE_DRIVER='file'
ENV DB_DRIVER='pgsql'
ENV SESSION_DRIVER='file'

# Use Composer v1 instead of default v2
RUN composer self-update 1.10.19

RUN webpack-app-build.sh && laravel-app-build.sh && php artisan storage:link
