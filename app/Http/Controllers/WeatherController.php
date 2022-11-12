<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Weather;

class WeatherController extends Controller
{
    public function index($province = 'Indonesia'){
        $province = str_replace('-', '', ($province));
        if ($province == 'kepriau') {
            $province = 'kepulauanriau';
        }
        if ($province == 'kepbangkabelitung') {
            $province = 'bangkabelitung';
        }        

        $weather = new Weather();
        $forecasts = $weather->getForecastData($province);

        return view('home', [
            'date' => date('d M Y', strtotime($forecasts['date']['timestamp'])),
            'hours' => date('H'),
            'forecasts' => $forecasts['data'],
            'weatherModel' => $weather
        ]);
    }   

    public function forecastProvince($province, $city) {
        $xml = str_replace('-', '', ($province));
        if ($xml == 'kepriau') {
            $xml = 'kepulauanriau';
        }
        if ($xml == 'kepbangkabelitung') {
            $xml = 'bangkabelitung';
        }

        $weather = new Weather();
        $forecasts = $weather->getForecastData($xml);

        $province = ucwords(str_replace('-', ' ', ($province)));
        $city = ucwords(str_replace('-', ' ', ($city)));
        $forecast = $forecasts['data']->where('@description', $city)->first();

        return view('show', [
            'date' => date('d M Y', strtotime($forecasts['date']['timestamp'])),
            'hours' => date('H'),
            'city' => $city,
            'province' => $province,
            'forecast' => $forecast,
            'weatherModel' => $weather,
            'weather' => collect($forecast['parameter'][6]['timerange'])->take(5),
            'temp' => collect($forecast['parameter'][5]['timerange'])->take(5)
        ]);
    }
}
