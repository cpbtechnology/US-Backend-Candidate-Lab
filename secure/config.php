<?php

//////////////////////////////////
/* Database  Cleerly App Database */
//////////////////////////////////
define("DATABASE_SERVER",	isset($_ENV["DB1_HOST"]) ? $_ENV["DB1_HOST"]	: 'localhost');
define("DATABASE_PORT",		isset($_ENV["DB1_PORT"]) ? $_ENV["DB1_PORT"]	: 3306);
define("DATABASE_USER",		isset($_ENV["DB1_USER"]) ?	$_ENV["DB1_USER"]   : 'root');
define("DATABASE_PASS",		isset($_ENV["DB1_PASS"]) ?	$_ENV["DB1_PASS"]	: 'root');
define("DATABASE_NAME",		isset($_ENV["DB3_NAME"]) ? $_ENV["DB1_NAME"]	: 'cpNotes');
define("CRYPT_SALT", 'X6jmeZffSv473eu8GhdV');