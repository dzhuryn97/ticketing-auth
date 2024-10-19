ARG PHP_CONTAINER
FROM nginx:1.19-alpine AS build

COPY docker/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf
COPY docker/nginx/snippets/fastcgi-php.conf /etc/nginx/snippets/fastcgi-php.conf

WORKDIR /app

FROM ${PHP_CONTAINER} AS bundles

FROM build AS deployment
COPY ./public ./public
COPY --from=bundles /app/public/bundles /app/public/bundles