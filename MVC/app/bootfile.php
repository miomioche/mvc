<?php 
// Fichiers qui chargent toutes les fontions et classes qui sont utilisées de manière globale

// Charger les helpers
require_once 'helpers/dump_helper.php';
require_once 'helpers/flash_helper.php';
require_once 'helpers/url_helper.php';

// Charger la config 
require_once 'config/config.php';

// Charger libraries
require_once 'libraries/Router.php';
require_once 'libraries/Controller.php';
require_once 'libraries/Database.php';