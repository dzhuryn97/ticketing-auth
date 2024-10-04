ARG PHP_CONTAINER
FROM ${PHP_CONTAINER} as build

FROM nginx:1.19-alpine

COPY docker/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf
COPY docker/nginx/snippets/fastcgi-php.conf /etc/nginx/snippets/fastcgi-php.conf

WORKDIR /app
COPY ./public ./public

COPY --from=build /app/public/bundles /app/public/bundles