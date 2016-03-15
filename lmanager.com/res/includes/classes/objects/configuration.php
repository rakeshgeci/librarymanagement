<?php

global $configuration;

$configuration['db']	= 'db_m140143cs'; 		//	database name
$configuration['host']	= 'localhost';	//	database host
$configuration['user']	= 'm140143cs';		//	database user
$configuration['pass']	= 'm140143cs';		//	database password
$configuration['port'] 	= '3306';		//	database port


//proxy settings - if you are behnd a proxy, change the settings below
$configuration['proxy_host'] = false;
$configuration['proxy_port'] = false;
$configuration['proxy_username'] = false;
$configuration['proxy_password'] = false;


//plugin settings
$configuration['plugins_path'] = '/var/www/library/includes/classes/plugins';  //absolute path to plugins folder, e.g c:/mycode/test/plugins or /home/phpobj/public_html/plugins

?>
