<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
ini_set('display_errors', 1);
session_start();

$config = include 'config.php';

/**
 * Подключение к базе данных
 */
include 'lib/DataBase.php';

$db = DataBase::connect(
	$config['mysql']['host'],
	$config['mysql']['dbname'],
	$config['mysql']['user'],
	$config['mysql']['pass']
);

include 'lib/router.php';

