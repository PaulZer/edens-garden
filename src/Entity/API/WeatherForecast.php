<?php


namespace App\Entity\API;

use Symfony\Component\Translation\Exception\NotFoundResourceException;
use \Datetime;

class WeatherForecast
{
    private $longitude;
    private $latitude;
    private $appToken;
    private $unit;
    private $url;

    public function __construct(string $latitude, string $longitude, string $appToken, string $unit = 'metric')
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->appToken = $appToken;
        $this->unit = $unit;
        $this->url = "api.openweathermap.org/data/2.5/forecast?lat=".$latitude."&lon=".$longitude."&units=".$unit."&mode=json&APPID=".$appToken;
    }

    function getWeatherForecastData()
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

    function getDateDifference($date)
    {
        date_default_timezone_set('Europe/Paris');

        $today = new DateTime(); // This object represents current date/time
        $today->setTime( 0, 0, 0 ); // reset time part, to prevent partial comparison

        $match_date = new DateTime();
        date_timestamp_set($match_date, $date);

        $diff = $today->diff( $match_date );
        $diffDays = (integer)$diff->format( "%R%a" ); // Extract days count in interval

        switch( $diffDays ) {
            case 0:
                $date = "Aujourd'hui";
                break;
            case -1:
                $date = "Hier";
                break;
            case +1:
                $date = "Demain";
                break;
            default:
                $date = date('D', $date);
                switch($date)
                {
                    case 'Mon':
                        $date = 'Lundi';
                    break;
                    case 'Tue':
                        $date = 'Mardi';
                        break;
                    case 'Wed':
                        $date = 'Mercredi';
                        break;
                    case 'Thu':
                        $date = 'Jeudi';
                        break;
                    case 'Fri':
                        $date = 'Vendredi';
                        break;
                    case 'Sat':
                        $date = 'Samedi';
                        break;
                    case 'Sun':
                        $date = 'Dimanche';
                        break;
                }
            break;
        }
        return $date;
    }

    function formatWeatherForecastArray($weatherForecastArray)
    {
        foreach($weatherForecastArray['list'] as $forecastId => $forecastData)
        {
            $formattedDate = $this->getDateDifference($forecastData['dt']);
            $formattedWeatherForecastArray[$formattedDate][date('H', $forecastData['dt']).'h']= $forecastData;
            if(isset($forecastData['weather'][0]['main']))
            {
                switch($forecastData['weather'][0]['main'])
                {
                    case 'Clear':
                        unset($formattedWeatherForecastArray[$formattedDate][date('H', $forecastData['dt']).'h']['weather'][0]);
                        $formattedWeatherForecastArray[$formattedDate][date('H', $forecastData['dt']).'h']['weather']['conditions'] = "Ensoleillé";
                        $formattedWeatherForecastArray[$formattedDate][date('H', $forecastData['dt']).'h']['weather']['fontawsome'] = "<i class=\"fas fa-sun\"></i>";
                        break;
                    case 'Rain';
                        unset($formattedWeatherForecastArray[$formattedDate][date('H', $forecastData['dt']).'h']['weather'][0]);
                        $formattedWeatherForecastArray[$formattedDate][date('H', $forecastData['dt']).'h']['weather']['conditions'] = "Pluie";
                        $formattedWeatherForecastArray[$formattedDate][date('H', $forecastData['dt']).'h']['weather']['fontawsome'] = "<i class=\"fas fa-cloud-showers-heavy\"></i>";
                        break;
                    case 'Clouds';
                        unset($formattedWeatherForecastArray[$formattedDate][date('H', $forecastData['dt']).'h']['weather'][0]);
                        $formattedWeatherForecastArray[$formattedDate][date('H', $forecastData['dt']).'h']['weather']['conditions'] = "Nuageux";
                        $formattedWeatherForecastArray[$formattedDate][date('H', $forecastData['dt']).'h']['weather']['fontawsome'] = "<i class=\"fas fa-cloud\"></i>";
                        break;
                    case 'Snow';
                        unset($formattedWeatherForecastArray[$formattedDate][date('H', $forecastData['dt']).'h']['weather'][0]);
                        $formattedWeatherForecastArray[$formattedDate][date('H', $forecastData['dt']).'h']['weather']['conditions'] = "Neige";
                        $formattedWeatherForecastArray[$formattedDate][date('H', $forecastData['dt']).'h']['weather']['fontawsome'] = "<i class=\"far fa-snowflake\"></i>";
                        break;
                    default:
                        unset($formattedWeatherForecastArray[$formattedDate][date('H', $forecastData['dt']).'h']['weather'][0]);
                        $formattedWeatherForecastArray[$formattedDate][date('H', $forecastData['dt']).'h']['weather']['conditions'] = "Ensoleillé";
                        $formattedWeatherForecastArray[$formattedDate][date('H', $forecastData['dt']).'h']['weather']['fontawsome'] = "<i class=\"fas fa-sun\"></i>";
                        break;

                }
            }
            else
            {
                $formattedWeatherForecastArray[$formattedDate][date('H', $forecastData['dt']).'h']['weather'] = null;
            }



        }
        if(isset($formattedWeatherForecastArray))
        {
            dump($formattedWeatherForecastArray);
            return $formattedWeatherForecastArray;
        }
        else
        {
            return null;
        }

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