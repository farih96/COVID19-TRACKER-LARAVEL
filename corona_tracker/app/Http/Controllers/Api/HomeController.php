<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataResource;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public $AllCountriesData;

    public function __construct(){


        $filename='https://raw.githubusercontent.com/CSSEGISandData/COVID-19/web-data/data/cases_country.csv';

        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE)
        {
            while (($row = fgetcsv($handle, 1000, ',')) !== FALSE)
            {
                if(!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);

            }
            fclose($handle);
        }

        $this->AllCountriesData=$data;

    }
    public function index(){
        return $this->AllCountriesData ;
    }


    public function world(){
        $TotalConfirmed=null;
        $TotalDeaths=0;
        $TotalRecovered=0;
        function converttoint($string){
            return (int)(str_replace(",", ".", $string));
        }
        foreach($this->AllCountriesData as $countrydata) {
            $TotalConfirmed +=  converttoint($countrydata['Confirmed']) ;
            $TotalDeaths +=  converttoint($countrydata['Deaths']) ;
            $TotalRecovered +=  converttoint($countrydata['Recovered']) ;

        }/*
        echo  'Confirmed : '.$TotalConfirmed.'<br>';
        echo  'Deaths : '.$TotalDeaths.'<br>';
        echo  'Recovered : '.$TotalRecovered.'<br>';*/
        return ['Confirmed'=>$TotalConfirmed,'Deaths'=>$TotalDeaths,'Recovered'=>$TotalRecovered];

    }

    public function country($country){
        // find the country index and return the value
        $key = array_search($country, array_column($this->AllCountriesData, 'Country_Region'));
       return $this->AllCountriesData[$key];

    }
}
