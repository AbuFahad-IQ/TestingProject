<?php

include __DIR__ . '/../vendor/autoload.php';
include basePath() . 'Routes/web.php';
app()->run();




// ("SELECT * FROM users WHERE username = '' OR '1'='1'")
//("SELECT * FROM users WHERE username = ''; DROP TABLE users; --");
//("SELECT * FROM users UNION SELECT null, table_name, null FROM information_schema.tables --");