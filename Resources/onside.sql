
CREATE USER 'onside'@'localhost' IDENTIFIED BY  '***';
GRANT USAGE ON * . * TO  'onside'@'localhost' IDENTIFIED BY  '***' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;
CREATE DATABASE IF NOT EXISTS  `onside` ;
GRANT ALL PRIVILEGES ON  `onside` . * TO  'onside'@'localhost';
FLUSH PRIVILEGES;

use `onside`;
