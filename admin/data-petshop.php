<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.4.0/css/select.dataTables.min.css" />

    <!-- Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css" />

    <!-- Mapbox -->
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.css" rel="stylesheet" />

    <!-- My Style -->
    <link rel="stylesheet" href="style.css" />

    <title>Data Petshop | SIG Petshop</title>
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
                  <li><a class="dropdown-item" href="#">Dashboard</a></li>
                  <li><a class="dropdown-item" href="#">Data Request</a></li>
                  <li><a class="dropdown-item" href="#">Logout</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <hr style="margin: 0px 0px; height: 1px; opacity: 0.5" />
    </section>

    <section id="table-data">
      <div class="table-data">
        <div class="container">
          <div class="card shadow">
            <div class="card-header py-3">
              <h4 class="text-center">Data Petshop</h4>
              <div class="d-flex justify-content-end">
                <button class="btn btn-block text-light" id="filter" style="background-color: #05595b"><i class="bi bi-plus-lg"></i> Tambah Data</button>
              </div>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nama Tempat</th>
                      <th>Jenis Layanan</th>
                      <th>Kecamatan</th>
                      <th>Alamat</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Nama Tempat</th>
                      <th>Jenis Layanan</th>
                      <th>Kecamatan</th>
                      <th>Alamat</th>
                      <th>Aksi</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <tr>
                      <td>Cimo Petshop</td>
                      <td>Pet shop, Pet clinic</td>
                      <td>Purwokerto Selatan</td>
                      <td>Jl. Rasamala No. 60, Karang Malang, Teluk, Kec. Purwokerto Sel.</td>
                      <td><a class="btn btn-warning" href="#">Ubah</a> <a class="btn btn-danger" href="#">Hapus</a></td>
                    </tr>
                    <tr>
                      <td>Amo Petshop</td>
                      <td>Pet shop, Pet clinic</td>
                      <td>Purwokerto Selatan</td>
                      <td>Jl. Rasamala No. 60, Karang Malang, Teluk, Kec. Purwokerto Sel.</td>
                      <td><a class="btn btn-warning" href="#">Ubah</a> <a class="btn btn-danger" href="#">Hapus</a></td>
                    </tr>
                    <tr>
                      <td>Deca Petshop</td>
                      <td>Pet shop, Pet clinic</td>
                      <td>Purwokerto Selatan</td>
                      <td>Jl. Rasamala No. 60, Karang Malang, Teluk, Kec. Purwokerto Sel.</td>
                      <td><a class="btn btn-warning" href="#">Ubah</a> <a class="btn btn-danger" href="#">Hapus</a></td>
                    </tr>
                    <tr>
                      <td>Kasa Petshop</td>
                      <td>Pet shop, Pet clinic</td>
                      <td>Purwokerto Selatan</td>
                      <td>Jl. Rasamala No. 60, Karang Malang, Teluk, Kec. Purwokerto Sel.</td>
                      <td><a class="btn btn-warning" href="#">Ubah</a> <a class="btn btn-danger" href="#">Hapus</a></td>
                    </tr>
                    <tr>
                      <td>Hana Petshop</td>
                      <td>Pet shop, Pet clinic</td>
                      <td>Purwokerto Selatan</td>
                      <td>Jl. Rasamala No. 60, Karang Malang, Teluk, Kec. Purwokerto Sel.</td>
                      <td><a class="btn btn-warning" href="#">Ubah</a> <a class="btn btn-danger" href="#">Hapus</a></td>
                    </tr>
                  </tbody>
                </table>
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
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.4.0/js/dataTables.select.min.js"></script>
    <script>
      $(document).ready(function () {
        $("#dataTable").DataTable({
          select: true,
        });
      });
    </script>

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
