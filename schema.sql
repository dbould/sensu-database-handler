CREATE TABLE sensor_log
(
    id          INT AUTO_INCREMENT
        PRIMARY KEY ,
    sensor_name VARCHAR(500) NOT NULL,
    timestamp   TIMESTAMP    NOT NULL,
    status      TINYINT      NOT NULL,
    duration    FLOAT        NULL,
    output      BLOB         NULL,
    client      VARCHAR(500) NULL
);
