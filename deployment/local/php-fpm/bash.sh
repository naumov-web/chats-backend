#!/bin/bash

echo -e "\e[32mConnecting to php-fpm container!"
echo -e "\e[97m"

docker exec -it chats_backend_php_fpm bash
