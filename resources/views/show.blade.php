@extends('layouts.main')

@section('container')
  <div class="my-5">
      <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100" style="color: #282828;">
          <div class="text-center mb-4">
            <h2>Prakiraan Cuaca </h2>
            <h4>{{ "$date " . date('H:i') }} WIB</h4>
          </div>
          <div class="col-md-9 col-lg-7 col-xl-5">
       
            <div class="card mb-4 shadow" style="border-radius: 25px; background: url('/img/backgrounds/{{ $weatherModel->getForecastParam('weather', $hours, $forecast) }}.jpg') no-repeat center center;background-size: cover;">
              <div class="mask glass"></div>
              <div class="card-body p-4">
       
                <div id="weather" class="carousel slide" data-bs-ride="carousel">
                  <!-- Indicators -->
                  <ul class="carousel-indicators mb-0">
                    <li data-bs-target="#weather" data-bs-slide-to="0" class="active"></li>
                    <li data-bs-target="#weather" data-bs-slide-to="1"></li>
                  </ul>
                  <!-- Carousel inner -->
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                      <div class="d-flex justify-content-between my-4 pb-2">
                        <div>
                          <h4 class="mb-0">{{ $city }}, {{ $province }}</h4>
                          <p class="display-2 my-2"><strong>{{ $weatherModel->getForecastParam('temp', $hours, $forecast) }}°C</strong></p>
                          <h5>{{ $weatherModel->getForecastParam('weather', $hours, $forecast) }}</h5>
                        </div>
                        <div>
                          <img src="/img/icons/{{ $weatherModel->getForecastParam('weather', $hours, $forecast) }}.png"
                            width="150px">
                        </div>
                      </div>
                    </div>
                    <div class="carousel-item mt-4">
                      <div class="d-flex justify-content-around text-center my-4 pb-3 pt-2">
                          @foreach ($temp as $t)
                          <div class="flex-column">
                            <p class="small"><strong>{{ $t['value'][0]['$'] }}°C</strong></p>
                          
                            {{-- <i class="fas fa-sun fa-2x mb-3" style="color: #ddd;"></i> --}}       
                            <img src="/img/icons/{{ $weatherModel->getForecastParam('weather', $hours, $weather->where('@h', $t['@h'])->first()['value']['$']) }}.png" class="mb-2" width="35em">                                                   
                            <p class="mb-0"><strong>{{ $t['@h'] }}:00</strong></p>
                          </div>
                          @endforeach
                      </div>
                    </div>
                  </div>
                </div
                
              </div>
            </div>
       
          </div>
        </div>
    
      </div>
  </div>
@endsection