<?php

/*namespaces are logical directories for classes, help prevent class name collisions*/
namespace App\weather;

class RandomWeatherFetcher implements WeatherFetcherInterface{
    public function fetch(string $city): WeatherInfo{
        $temperatureC= rand(0,50);
        $localTime= "Local time";
        $humidity= 0;
        $uvIndex= 0.0;
        if($temperatureC<=10)
            $weatherType= "snowy";
        elseif($temperatureC<=20)
            $weatherType= "stormy";
        elseif($temperatureC<=30)
            $weatherType= "cloudy";
        else
            $weatherType= "sunny";
        return new WeatherInfo($city, $temperatureC, $weatherType, ucfirst($weatherType), $humidity, $uvIndex, $localTime);
    }
} 