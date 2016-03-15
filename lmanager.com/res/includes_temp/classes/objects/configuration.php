<?php

global $configuration;

$configuration['db']	= 'library'; 		//	database name
$configuration['host']	= 'localhost';	//	database host
$configuration['user']	= 'root';		//	database user
$configuration['pass']	= 'root';		//	database password
$configuration['port'] 	= '3306';		//	database port


//proxy settings - if you are behnd a proxy, change the settings below
$configuration['proxy_host'] = false;
$configuration['proxy_port'] = false;
$configuration['proxy_username'] = false;
$configuration['proxy_password'] = false;


//plugin settings
$configuration['plugins_path'] = '/var/www/library/includes/classes/plugins';  //absolute path to plugins folder, e.g c:/mycode/test/plugins or /home/phpobj/public_html/plugins

?>