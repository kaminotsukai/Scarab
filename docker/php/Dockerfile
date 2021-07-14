FROM php:8.0-apache

# PHPのGD拡張をインストール (画像のリサイズ処理で必要です)
RUN apt-get update
RUN apt-get install -y wget libjpeg-dev libfreetype6-dev
RUN apt-get install -y libmagick++-dev \
libmagickwand-dev \
libpq-dev \
libfreetype6-dev \
libjpeg62-turbo-dev \
libpng-dev \
libwebp-dev \
libxpm-dev
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd

# PHPのMySQL拡張をインストール (データベース処理で必要です)
RUN docker-php-ext-install pdo_mysql

# PHPのZIP拡張をインストール (composerにとって必要です)
RUN apt-get install -y unzip zlib1g-dev libzip-dev
RUN docker-php-ext-install zip

# Apacheのrewriteモジュールをインストール (ルーティング処理で必要です)
RUN cp /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled
RUN /bin/sh -c a2enmod rewrite

# vimをインストール
RUN apt-get -y install vim

# composerをインストール。
# うまく行かないときは https://getcomposer.org/download/ の項「Command-line installation」もご参照ください。
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
