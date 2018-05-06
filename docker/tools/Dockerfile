FROM php:7.2.3-cli

ARG SYMFONY_ENV=dev

# Base packages
RUN apt-get update && apt-get install -y \
    libmagickwand-dev ghostscript \
    python \
    apt-transport-https \
    libicu-dev \
    git \
    zlib1g-dev \
    libxml2-dev \
    libnss3-dev
# PHP extensions
RUN docker-php-ext-install intl mbstring zip mysqli pdo pdo_mysql soap bcmath gd pcntl

# Xdebug
#RUN pecl install -o -f xdebug-2.4.0 \
#    && rm -rf /tmp/pear
RUN pecl install xdebug mongodb
RUN docker-php-ext-enable xdebug mongodb

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin

# Nodejs
#RUN curl -sS https://deb.nodesource.com/gpgkey/nodesource.gpg.key | apt-key add -
#RUN echo 'deb https://deb.nodesource.com/node_6.x jessie main' > /etc/apt/sources.list.d/nodesource.list
#RUN apt-get update && apt-get install -y nodejs
#RUN npm uninstall npm -g

# Yarn
#RUN curl -sS http://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
#RUN echo "deb http://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
#RUN apt-get update && apt-get install -y yarn

# Imagick
RUN yes '' | pecl install -f imagick && docker-php-ext-enable imagick

# Assign a shell to user www-data
RUN chsh -s /bin/bash www-data

# Access rights
RUN mkdir -p /var/www/html && chown -R www-data:www-data /var/www/html

# Copy configuration files
ADD config/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY config/php.ini /usr/local/etc/php/php.ini
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
COPY .bashrc /var/www/.bashrc

RUN sh -c 'echo "deb [arch=amd64] https://dl.google.com/linux/chrome/deb/ stable main" > /etc/apt/sources.list.d/google-chrome.list'
RUN apt-get update && apt-get install -y wget gnupg2
RUN wget -q -O - https://dl-ssl.google.com/linux/linux_signing_key.pub | apt-key add -
RUN apt-get update && apt-get install -y google-chrome-stable
RUN apt-get install -y mongodb

RUN echo `pwd`

WORKDIR /var/www/html
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
