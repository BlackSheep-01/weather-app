<?php

/*autoloader figures out which file a class is in and automatically loads it if its not loaded yet.
  spl_autoload_register(): a special fn used for autoloading*/ 


spl_autoload_register(function ($class) {   //$class: App\weather\RemoteWeatherFetcher
    $prefix = 'App\\';   //"App": root namespace for project as convention
    $base_dir = __DIR__ . '/../src/';   
    $len = strlen($prefix);  //4
    if (strncmp($prefix, $class, $len) !== 0) {  //if class doesn't start with "App\"
        return;
    }
    
    $relative_class = substr($class, $len);   //remove "App\" from class name
    
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';  //convert class name into a file path

    if (file_exists($file)) {
        require $file;        //require '/weather project/src/weather/RemoteWeatherFetcher.php'
    }
});


/*
PHP doesn’t know what RemoteWeatherFetcher is — so it:
    1. Calls your autoload function
    2. (use) Class = App\weather\RemoteWeatherFetcher
    3. Removes App\ → weather\RandomWeatherFetcher
    4. Builds path: /weather project/src/weather/RandomWeatherFetcher.php
    5. If file exists → includes it 
*/