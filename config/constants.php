<?php
// Definir constantes para la conexión a la base de datos
define('DB_HOST', 'localhost'); 
define('DB_USER', 'root'); 
define('DB_PASSWORD', ''); 
define('DB_NAME', 'biblioteca'); 

// Definir constantes para rutas y directorios
define('ROOT_DIR', dirname(__DIR__));
define('PUBLIC_DIR', ROOT_DIR . '/public');
define('VIEWS_DIR', ROOT_DIR . '/views');
define('MODELS_DIR', ROOT_DIR . '/models');
define('CONTROLLERS_DIR', ROOT_DIR . '/controllers');
define('UTILS_DIR', ROOT_DIR . '/utils'); 


define('DEFAULT_LOAN_DAYS', 20);
define('SITE_NAME', 'Biblioteca');
define('SITE_URL', 'https://example.com'); 


?>