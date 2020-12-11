<?php

const DEFAULT_APP = 'Frontend';
// For older PHP verions: define('DEFAULT_APP', 'Frontend');

// Check if app exist. if not get the default app & generate a 404 error
if (!isset($_GET['app']) || !file_exists(__DIR__. '/../App/' .$_GET['app'])) {
    $_GET['app'] = DEFAULT_APP;
}
// Include Class autoloader then load each vendors
require __DIR__. '/../Library/OCFramework/SplClassLoader.php';
$OCFramLoader = new SplClassLoader('OCFramework', __DIR__.'/../Library'); 
$OCFramLoader->register();
$frontendLoader = new SplClassLoader('App\Frontend', __DIR__.'/..');
$frontendLoader->register();
$backendLoader = new SplClassLoader('App\Backend', __DIR__.'/..');
$backendLoader->register();
$modelLoader = new SplClassLoader('Model', __DIR__.'/../Library/Vendors');
$modelLoader->register();
$entityLoader = new SplClassLoader('Entity', __DIR__.'/../Library/Vendors');
$entityLoader->register();

// Get the app name & instance it
$appname = '\\App\\' .$_GET['app']. '\\' .$_GET['app']. 'Application';
$appname = new $appname();
$appname->run();

/* Tips:
    $app = new FrontendApplication; // This will work

    $app = 'FrontendApplication'
    $app = new $app // This won't work because of the namespace
*/