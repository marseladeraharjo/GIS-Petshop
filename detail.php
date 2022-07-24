<?php 
include "admin/koneksi.php";
$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM lokasi WHERE id_lokasi = $id");
$row = mysqli_fetch_assoc($result);
$nama = $row['nama'];
$info = $row['info'];
$alamat = $row['alamat'];
$jadwal = $row['jadwal'];
$telp = $row['telp'];
$layanan = explode(', ', $row['layanan']);
$kecamatan = $row['id_kecamatan'];
$kelurahan = $row['id_kelurahan'];
$lat = $row['lat'];
$lng = $row['lng'];
?>

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

    <!-- style.css -->
    <link rel="stylesheet" href="style.css" />

    <!-- logo -->
    <link rel="shortcut icon" href="logo.png">

    <title>Detail | SIG Petshop</title>
  </head>
  <body>
    <section id="navbar">
      <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #fffaf4">
        <div class="container">
          <a class="navbar-brand" href="beranda.php">
            <strong>SIG <span style="color: #05595b">PETSHOP</span></strong>
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-gear-fill"></i>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navbarTogglerDemo02">
          <a class="btn btn-block text-light" style="background-color: #05595b" href="admin/dashboard.php">Login</a>
          </div>
        </div>
      </nav>
      <hr style="margin: 0px 0px; height: 1px; opacity: 0.5" />
    </section>

    <section id="detail">
      <div class="detail">
        <div class="container">
          <div class="row text-center" id="detail-name">
            <h4><?= $nama; ?></h4>
            <p>Telp: <?= $telp; ?></p>
            <p> Alamat: <?= $alamat; ?></p>
          </div>
          <div class="row" id="detail-carousel-map">
            <div class="col-md-6 mt-2">
              <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner image">
                <?php 
                  $no = 1;
                  $sqlfoto = mysqli_query($conn, "SELECT * FROM foto WHERE id_lokasi = $id");
                  while ($rowfoto = mysqli_fetch_assoc($sqlfoto)) {
                    $foto = $rowfoto['nama'];
                    if ($no==1){
                ?>

                      <div class="carousel-item active">
                        <img class="d-block w-100 tales" src="admin/images/<?php echo $foto; ?>" />
                      </div>
                    <?php 
                    }
                    if ($no>1){
                    ?>
                      <div class="carousel-item">
                        <img class="d-block w-100 tales" src="admin/images/<?php echo $foto; ?>" />
                      </div>
                    <?php 
                    }
                    $no++;
                  }
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
            </div>
            <div class="col-md-6 mt-2">
              <div id="map" class="map shadow" style="height: 400px"></div>
            </div>
          </div>
          <div class="container mt-4" style="background-color: white; border-radius: 1em">
            <div class="row">
              <div class="col m-3">
                <h5>Info Detail:</h5>
                <p><?php echo $info; ?></p>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.js'></script>
    
    <script>
      mapboxgl.accessToken = "pk.eyJ1IjoibWFyc2VsYWRlcmFoYXJqbyIsImEiOiJjbDV4cHBzZzEwdzA4M2ttcHc2bnhpMnM2In0.rqkuPeTWmIIRjq9ADpJoCw";
      var map = new mapboxgl.Map({
        container: "map", // container ID
        style: "mapbox://styles/mapbox/streets-v11", // style URL
        center: [109.23819945612114, -7.419380317240572], // starting position [lng, lat]
        zoom: 10, // starting zoom
      });
      var marker = new mapboxgl.Marker()
      <?php 
      echo "marker.setLngLat([$lng, $lat]).addTo(map);
            map.flyTo({
              center: [$lng, $lat],
              zoom: 15
            });";
      ?>
    </script>
  </body>
</html>
