@extends('layouts.main')

@section('container')
      <div class="my-5">

        <div class="text-center mb-5">
          <h1 class="mb-1">Prakiraan Cuaca </h1>
          <h4>{{ "$date " . date('H:i') }} WIB</h4>
        </div>        
        
        @if (Request::url() === strtr(strtolower(route('forecast.province', $forecasts[0]['@domain'])), ['kep.' => 'kep', '%20' => '-']))                        
          <div class="w-100 p-4 mb-5 d-flex justify-content-center" data-live-search="true"> 
            <div class="col-md-5 text-center me-3">
              <input class="form-control" list="forecast-options" id="province" name="province" placeholder="Pilih Daerah">
              <datalist id="forecast-options">
              @foreach ($forecasts as $forecast)
                <option value="{{ $forecast['@description'] }}">
              @endforeach
              </datalist>         
            </div>
            <div>
              <a href="#" class="btn btn-primary text-white d-flex justify-content-lg-center">
                <i data-feather="search"></i>
              </a>
            </div>
          </div>
        @else
          <div class="w-100 p-4 mb-5 d-flex justify-content-center" data-live-search="true"> 
            <div class="col-md-5 text-center me-3">
              <input class="form-control" list="forecast-options" id="province" name="province" placeholder="Pilih Provinsi">
              <datalist id="forecast-options">
                @foreach ($forecasts as $forecast)
                  <option value="{{ $forecast['@domain'] }}">
                @endforeach
                <option value="Sulawesi Tengah">
              </datalist>         
            </div>
            <div>
              <a href="#" class="search-forecast btn btn-primary text-white d-flex justify-content-lg-center">
                <i data-feather="search"></i>
              </a>
            </div>
          </div>
        @endif

        <div class="forecast-content row d-flex justify-content-center align-items-center h-100 mb-5">
          @foreach ($forecasts as $forecast)          
            @if(isset($forecast['parameter']))
              <div class="forecast-card col-md-8 col-lg-6 col-xl-4 mb-3">             
                @if (Request::url() === strtr(strtolower(route('forecast.province', $forecast['@domain'])), ['kep.' => 'kep', '%20' => '-']))                
                  <a href="{{ strtr(strtolower(route('forecast.city', [$forecast['@domain'], $forecast['@description']])), ['kep.' => 'kep', '%20' => '-']) }}" class="text-decoration-none">
                @else
                  <a href="{{ strtr(strtolower(route('forecast.province', $forecast['@domain'])), ['kep.' => 'kep', '%20' => '-']) }}" class="text-decoration-none">
                @endif      
                  <div class="card shadow" style="color: #4B515D; border-radius: 35px;">
                    <div class="card-body p-4">
                      <div class="d-flex">
                        <h6 class="flex-grow-1">{{ $forecast['@description'] }}</h6>
                      </div>
                      <div class="d-flex flex-column text-center mt-5 mb-4">
                        <h6 class="display-4 mb-0" style="color: #1C2331; font-weight:700"> {{ $weatherModel->getForecastParam('temp', $hours, $forecast) }}°C </h6>
                        <span class="small" style="color: #868B94">{{ $weatherModel->getForecastParam('weather', $hours, $forecast) }}</span>
                      </div>
                      <div class="d-flex align-items-center">
                        <div class="flex-grow-1" style="font-size: 1rem;">
                          <div><i  style="color: #868B94; width: 16px" data-feather="wind"></i> <span class="ms-1">{{ $weatherModel->getForecastParam('wind', $hours, $forecast) }} km/jam </span></div>
                          <div><i  style="color: #868B94; width: 16px" data-feather="droplet"></i> <span class="ms-1"> {{ $weatherModel->getForecastParam('humid', $hours, $forecast) }}% </span></div>
                        </div>
                        <div>
                          <img src="/img/icons/{{ $weatherModel->getForecastParam('weather', $hours, $forecast) }}.png" width="100px">
                        </div>
                      </div>      
                    </div>
                  </div>      
                </a>
              </div>  
            @endif               
          @endforeach
        </div>
    
        <div class="text-center pb-5">
          <btn type="button" class="load-more btn btn-outline-primary">Load More</btn>
        </div>
      </div>
@endsection