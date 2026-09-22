#!/bin/bash
apt-get update -qq && apt-get install -y -qq php-cli php-mbstring php-xml php-curl php-zip unzip && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && composer install --no-dev --prefer-dist --optimize-autoloader
