FROM php:8-fpm

RUN apt-get update && apt-get install -y software-properties-common supervisor \
# may be should be moved to -dev part  \
            wget curl libpng* \
            unzip  zip \
            git \
            nginx sudo \
            net-tools vim && \
    # enable mysql
    docker-php-ext-install mysqli pdo pdo_mysql gd &&  \
    docker-php-ext-enable pdo_mysql && \
    # node & yarn
    curl -sL https://deb.nodesource.com/setup_14.x | bash - && \
    curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && \
    echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list && \
    apt-get update && apt-get install -y nodejs yarn && \
    curl -sS https://getcomposer.org/installer -o composer-setup.php && php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    apt-get clean && rm -rf /var/lib/apt/lists/*
#RUN docker-php-ext-configure mysql -with-mysql=/usr/local/mysql