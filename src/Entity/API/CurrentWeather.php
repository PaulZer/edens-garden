<?php


namespace App\Entity\API;

class CurrentWeather
{
    private $longitude;
    private $latitude;
    private $appToken;
    private $unit;
    private $url;

    public function __contruct(string $latitude, string $longitude, string $unit = 'metric')
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        
        $this->appToken = '41483201f4e8d0ac0d8fd986ac4adb01';
        $this->unit = $unit;
        $this->url = "api.openweathermap.org/data/2.5/weather?lat=".$latitude."&lon=".$longitude."&units=".$unit."&mode=json&APPID=".$this->appToken;
    }

    function getCurrentWeatherData($url)
    {
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url,
        CURLOPT_USERAGENT => 'Codular Sample cURL Request'
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);
        return json_decode($resp, true);
    }

    function formatCurrentWeatherArray($weatherArray)
    {
        foreach($weatherArray['weather'] as $weatherId => $weatherData)
        {
            $formattedWeatherArray['weather'] = $weatherData['main'];
            $formattedWeatherArray['weather_description'] = $weatherData['description'];
        }
        
        $formattedWeatherArray['current_temperature'] = $weatherArray['main']['temp'];
        $formattedWeatherArray['pressure'] = $weatherArray['main']['pressure'];
        $formattedWeatherArray['humidity'] = $weatherArray['main']['humidity'];
        $formattedWeatherArray['minimum_temperature'] = $weatherArray['main']['temp_min'];
        $formattedWeatherArray['maximum_temperature'] = $weatherArray['main']['temp_max'];
        $formattedWeatherArray['clouds'] = $weatherArray['clouds']['all'];
        $formattedWeatherArray['location_country'] = $weatherArray['sys']['country'];
        $formattedWeatherArray['sunrise'] = $weatherArray['sys']['sunrise'];
        $formattedWeatherArray['sunset'] = $weatherArray['sys']['sunset'];
        $formattedWeatherArray['last_weather_update'] = $weatherArray['dt'];

        return $formattedWeatherArray;
    }

}


?>