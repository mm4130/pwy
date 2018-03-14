<?php

define("hostname","ec2-54-247-81-88.eu-west-1.compute.amazonaws.com");//serveurmysql
define("database","d9bkmcbl5j24vq");
define("username","");
define("password","");

define("database_url", getenv('heroku config:get DATABASE_URL -a play-with-yourself'));

define('BASE_URL', explode('index.php', $_SERVER['SCRIPT_NAME'])[0]);
//define("BASE_URL","http://localhost/pwy/");

define("default_controller","index");

//mysql -u root -p