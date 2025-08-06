<?php 

namespace App\weather;

/*constructor fn() is automatically called when an object of the class is created.
  It's used to initialize the properties of the object */

class WeatherInfo{
    public function __construct(public string $city, 
                               public int $temperatureC, 
                               public string $weatherType, 
                               public string $originalCondition,
                               public int $humidity,
                               public float $uvIndex,
                               public string $localTime)
    { 
        
    }
}