#!/bin/sh
set -e

run_as() {
    su -p www-data -s /bin/sh -c "$1"
}

# change uid/gid of www-data
CURRENT_UID=$(id -u www-data)
CURRENT_GID=$(id -g www-data)
if [ ! -z "$UID" ] && [ "$UID" -ne $CURRENT_UID ]; then
    usermod -u $UID www-data
    find / -xdev -user $CURRENT_UID -exec chown -h www-data {} \;
fi
if [ ! -z "$GID" ] && [ "$GID" -ne $CURRENT_GID ]; then
    groupmod -g $GID www-data
    find / -xdev -group $CURRENT_GID -exec chgrp -h www-data {} \;
fi

# prepare appserver
if [ "$1" = "apache2-foreground" ]; then
    run_as 'php bin/console cache:clear'
    run_as 'php bin/console doctrine:migrations:migrate --no-interaction'
fi

# upstream entrypoint (php:*-apache)
exec docker-php-entrypoint $@
