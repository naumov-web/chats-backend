# Chat API

## Local environment

If you need to run project, you must have Docker on your PC.

Following command starts project:
```shell
    ./deployment/local/start.sh
```

Following command connects to container with PHP-FPM:
```shell
    ./deployment/local/php-fpm/bash.sh
```
Following command starts replication from Leader DB to Follower DB:
```shell
    ./deploymeny/local/start_db.sh
```

## Links

API: http://127.0.0.1:31080/api <br/>
Documentation: http://127.0.0.1:31080/docs <br/>
PhpMyAdmin Leader DB: http://127.0.0.1:9001
PhpMyAdmin Follower DB: http://127.0.0.1:9001
