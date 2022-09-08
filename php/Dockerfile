FROM golang:1.15 AS builder
RUN go get -d -v github.com/mailhog/mhsendmail \
  && cd /go/src/github.com/mailhog/mhsendmail/ \
  && GOOS=linux GOARCH=arm64 go build -o mhsendmail .

FROM php:7.4.7-fpm
WORKDIR /var/www/html
COPY --from=builder /go/src/github.com/mailhog/mhsendmail/mhsendmail /usr/local/bin/
RUN chmod +x /usr/local/bin/mhsendmail \
&& apt-get update \
  && docker-php-ext-install pdo_mysql
RUN pecl install xdebug && \
    docker-php-ext-enable xdebug
COPY ./php.ini /usr/local/etc/php/
COPY --from=composer /usr/bin/composer /usr/bin/composer
