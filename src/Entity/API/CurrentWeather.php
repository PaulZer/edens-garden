<?php


namespace App\Entity\API;

class CurrentWeather
{
    private $longitude;
    private $latitude;
    private $appToken = '41483201f4e8d0ac0d8fd986ac4adb01';
    private $unit;
    private $url;

    public function __construct(string $latitude, string $longitude, string $appToken, string $unit = 'metric')
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->appToken = $appToken;
        $this->unit = $unit;
        $this->url = "api.openweathermap.org/data/2.5/weather?lat=" . $latitude . "&lon=" . $longitude . "&units=" . $unit . "&mode=json&APPID=" . $this->appToken;
    }

    function getCurrentWeatherData()
    {
        $url = $this->getUrl();
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
        foreach ($weatherArray['weather'] as $weatherId => $weatherData) {
            $formattedWeatherArray['weather'] = $weatherData['main'];
            $formattedWeatherArray['weather_description'] = $weatherData['description'];
        }
        if (isset($weatherArray['rain'])) {
            if (isset($weatherArray['rain']['3h'])) {
                $formattedWeatherArray['rain_3h'] = $weatherArray['rain']['3h'];
            } else {
                $formattedWeatherArray['rain_3h'] = 0;
            }

            if (isset($weatherArray['rain']['1h'])) {
                $formattedWeatherArray['rain_1h'] = $weatherArray['rain']['1h'];
            } else {
                $formattedWeatherArray['rain_1h'] = 0;
            }
        } else {
            $formattedWeatherArray['rain_1h'] = 0;
            $formattedWeatherArray['rain_3h'] = 0;
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

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }


}


?>