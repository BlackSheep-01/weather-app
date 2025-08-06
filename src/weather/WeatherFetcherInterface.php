<?php 


namespace App\weather;  

/*interface defines a contract for all the classes which will implement it.
  interface contains abstract methods(no method body).
  all classes which implements the interface must define its abstract methods*/ 


interface WeatherFetcherInterface{
    public function fetch(string $city): ?WeatherInfo;  //WeatherInfo class
}