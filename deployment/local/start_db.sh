#!/bin/bash
sql_follower_user='CREATE USER IF NOT EXISTS "chats_user_follower"@"%" IDENTIFIED WITH mysql_native_password BY "follower_pwd"; GRANT REPLICATION SLAVE ON *.* TO "chats_user_follower"@"%"; FLUSH PRIVILEGES;'
docker exec database_leader sh -c "mysql -u root -pS3cret -e '$sql_follower_user'"
MS_STATUS=`docker exec database_leader sh -c 'mysql -u root -pS3cret -e "SHOW MASTER STATUS"'`
CURRENT_LOG=`echo $MS_STATUS | awk '{print $6}'`
CURRENT_POS=`echo $MS_STATUS | awk '{print $7}'`
sql_set_leader="CHANGE MASTER TO MASTER_HOST='database_leader',MASTER_USER='chats_user_follower',MASTER_PASSWORD='follower_pwd',MASTER_LOG_FILE='$CURRENT_LOG',MASTER_LOG_POS=$CURRENT_POS; START SLAVE;"
start_follower_cmd='mysql -u root -pS3cret -e "'
start_follower_cmd+="$sql_set_leader"
start_follower_cmd+='"'
docker exec database_follower sh -c "$start_follower_cmd"
docker exec database_follower sh -c "mysql -u root -pS3cret -e 'SHOW SLAVE STATUS \G'"
