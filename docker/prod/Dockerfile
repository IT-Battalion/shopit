FROM ubuntu:21.04

LABEL maintainer="ShopIT"

ARG WWWGROUP
ARG NODE_VERSION=16

WORKDIR /srv/shopit

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=CET

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update \
    && apt-get install -y gnupg curl ca-certificates zip unzip git supervisor libcap2-bin libpng-dev python2 \
    && mkdir -p ~/.gnupg \
    && chmod 600 ~/.gnupg \
    && echo "disable-ipv6" >> ~/.gnupg/dirmngr.conf \
    && apt-key adv --homedir ~/.gnupg --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys E5267A6C \
    && apt-key adv --homedir ~/.gnupg --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys C300EE8C \
    && echo "deb http://ppa.launchpad.net/ondrej/php/ubuntu hirsute main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && apt-get update \
    && apt-get install -y php8.1-cli php8.1-dev \
       php8.1-gd php8.1-ctype \
       php8.1-curl php8.1-dom php8.1-pdo \
       php8.1-imap php8.1-mysql php8.1-mbstring \
       php8.1-xml php8.1-zip php8.1-bcmath php8.1-soap \
       php8.1-intl php8.1-readline \
       php8.1-ldap php8.1-tokenizer \
       php8.1-igbinary php8.1-redis php8.1-swoole \
       php8.1-memcached php8.1-pcov \
    && php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && curl -sL https://deb.nodesource.com/setup_$NODE_VERSION.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm \
    && apt-get install -y nginx \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN setcap "cap_net_bind_service=+ep" /usr/bin/php8.1

#RUN groupadd --force -g $WWWGROUP shopit
#RUN useradd -ms /bin/bash --no-user-group -g $WWWGROUP -u 1337 shopit

COPY docker/prod/shopit.conf /etc/nginx/sites-available/shopit.conf
COPY docker/prod/start-container /usr/local/bin/start-container
COPY docker/prod/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/prod/php.ini /etc/php/8.1/cli/conf.d/99-shopit.ini
RUN chmod +x /usr/local/bin/start-container

RUN rm /etc/nginx/sites-enabled/default
RUN ln -s /etc/nginx/sites-available/shopit.conf /etc/nginx/sites-enabled

ADD . /srv/shopit

RUN composer install
RUN npm install
RUN npm run prod

EXPOSE 8000

ENTRYPOINT ["start-container"]
