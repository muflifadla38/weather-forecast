<header class="bg-white">
   <!-- Navbar -->
    {{-- @dd(Request::is('forecast*')) --}}
   <nav class="container navbar navbar-expand-lg navbar-light sticky-top">
     <div class="container-fluid m-auto">
       <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarExample01" aria-controls="navbarExample01" aria-expanded="false" aria-label="Toggle navigation">
         <i data-feather="menu"></i>
       </button>
       <div class="navbar-brand">
         <a class="nav-link" href="/"><img src="/img/logo.png" class="img-fluid w-75" alt="logo"></a>
       </div>
       <div class="collapse navbar-collapse" id="navbarExample01">
         <ul class="navbar-nav mb-2 mb-lg-0 py-2">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle {{ Request::is('/', 'forecast*') ? 'active' : '' }}" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Prakiraan Cuaca
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item {{ Request::is('/') ? 'active' : '' }}" href="/">Indonesia</a></li>
                <li><a class="dropdown-item {{ Request::is('forecast/province*') ? 'active' : '' }}" href="/forecast/province">Semua Kota</a></li>
              </ul>
            </li>
           <li class="nav-item">
             <a class="nav-link {{ Request::is('earthquake*') ? 'active' : '' }}" href="#">Gempa Bumi</a>
            </li>
         </ul>
       </div>
     </div>
   </nav>
   <!-- Navbar -->
 </header>