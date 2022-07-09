<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />

    <!-- Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css" />

    <!-- Mapbox -->
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.css" rel="stylesheet" />

    <!-- My Style -->
    <link rel="stylesheet" href="style.css" />

    <title>Home | SIG Petshop</title>
  </head>
  <body>
    <section id="navbar">
      <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #fffaf4">
        <div class="container">
          <a class="navbar-brand" href="#">
            <strong>SIG <span style="color: #05595b">PETSHOP</span></strong>
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-gear-fill"></i>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navbarTogglerDemo02">
            <ul class="navbar-nav mb-2 mb-lg-0">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <strong>More</strong> </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="#">Request</a></li>
                  <li><a class="dropdown-item" href="#">Login Admin</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <hr style="margin: 0px 0px; height: 1px; opacity: 0.5" />
    </section>

    <section id="filter-and-map">
      <div class="filter-and-map">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <div class="row">
                <div class="col-sm-12">
                  <div class="row">
                    <div class="col-sm-3 mb-1">
                      <div class="form-group">
                        <select class="form-select" aria-label="Default select example" id="kecamatan" name="kecamatan">
                          <option selected>Semua Kecamatan</option>
                          <option value="">Purwokerto Utara</option>
                          <option value="">Purwokerto Timur</option>
                          <option value="">Purwokerto Barat</option>
                          <option value="">Purwokerto Selatan</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-3 mb-1">
                      <div class="form-group">
                        <select class="form-select" id="layanan" name="layanan">
                          <option value="">Semua Layanan</option>
                          <option value="">Pet Shop</option>
                          <option value="">Pet Clinic</option>
                          <option value="">Pet Grooming</option>
                          <option value="">Pet Hotel</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-5 mb-1">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="Cari" id="keyword" />
                      </div>
                    </div>
                    <div class="col-sm-1">
                      <button class="btn btn-block text-light" id="filter" style="width: 100%; background-color: #05595b">
                        <i class="bi bi-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div id="map" class="map mt-2 shadow" style="width: 100%; height: 600px"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="footer">
      <div class="py-3">
        <div class="container">
          <div class="row">
            <div class="col">
              <p class="text-secondary mb-0 text-center"><small>2022 - Created by Marsel</small></p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
      mapboxgl.accessToken = "pk.eyJ1IjoibWFyc2VsYWRlcmFoYXJqbyIsImEiOiJja3Z6eTl2bXQ0MHdkMm9tb3BwNmZkazUwIn0.Ir9YmaXKN3HfyzzS0zxi2A";
      var map = new mapboxgl.Map({
        container: "map", // container ID
        style: "mapbox://styles/mapbox/streets-v11", // style URL
        center: [109.23819945612114, -7.419380317240572], // starting position [lng, lat]
        zoom: 10, // starting zoom
      });
    </script>
  </body>
</html>
