<?php

/*syntactic sugar for autoloader imported classes*/
use App\weather\RandomWeatherFetcher;
use App\weather\RemoteWeatherFetcher;

require __DIR__ . "/inc/all.inc.php";  /*'require' makes a file essential for furthur code execution*/


//API key from weatherapi.com
$apiKey = "f707e852cb884c829e072524253107";

$fetcher = new RemoteWeatherFetcher($apiKey);
$info = $fetcher->fetch("Kolkata");

if ($info === null) {
    $fallback = new RandomWeatherFetcher();
    $info = $fallback->fetch("Kolkata");
}


require __DIR__ . "/views/index.view.php";
