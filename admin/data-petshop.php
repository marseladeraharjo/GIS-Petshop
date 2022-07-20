<?php 
include "validasi_session.php";
include "koneksi.php";

// KECAMATAN UNTUK SELECT OPTION
$sqlKecamatan = "SELECT * FROM kecamatan ORDER BY nama_kecamatan ASC";
$listKecamatan = mysqli_query($conn, $sqlKecamatan);


// KELURAHAN DARI JAVASCRIPT AJAX
if (isset($_GET['id_kecamatan'])) {
  if ($_GET['id_kecamatan'] != 0) {
    $result =[];

    $sqlKelurahan = "SELECT * FROM kelurahan WHERE id_kecamatan=".$_GET['id_kecamatan']." ORDER BY nama_kelurahan ASC";
    $listKelurahan = mysqli_query($conn, $sqlKelurahan);
    $rowKelurahan = [];
    while ($row = mysqli_fetch_assoc($listKelurahan)) {
      $temp = [];
      $temp['id_kelurahan'] = $row['id_kelurahan'];
      $temp['id_kecamatan'] = $row['id_kecamatan'];
      $temp['nama_kelurahan'] = $row['nama_kelurahan'];
      $rowKelurahan = $temp;
    }
    echo json_encode($rowKelurahan);
    exit;
  }
}

if(isset($_POST['filter'])){
  $result = [];
  $id_kecamatan = $_POST['id_kecamatan'];
  $id_kelurahan = $_POST['id_kelurahan'];

  if($id_kecamatan == 0){
      $sqlPoligon = "SELECT * FROM poligon";
  }else{
      $sqlPoligon = "SELECT * FROM poligon WHERE id_kecamatan=".$id_kecamatan;
  }

  $listPoligon = mysqli_query($conn, $sqlPoligon);
  $rowPoligon = [];
  while ($row = mysqli_fetch_assoc($listPoligon)) {
      $rowPoligon[] = [$row['lat'], $row['lng']];
  }
  $result['poligon'] = $rowPoligon;
  echo json_encode($result);exit;
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />

    <!-- dataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.4.0/css/select.dataTables.min.css" />

    <!-- Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css" />

    <!-- Mapbox -->
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.css" rel="stylesheet" />

    <!-- My Style -->
    <link rel="stylesheet" href="style.css" />

    <!-- logo -->
    <link rel="shortcut icon" href="../logo.png">

    <title>Data Petshop | SIG Petshop</title>
  </head>
  <body>
    <section id="navbar">
      <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #fffaf4">
        <div class="container">
          <a class="navbar-brand" href="dashboard.php">
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
                  <li><a class="dropdown-item" href="dashboard.php">Dashboard</a></li>
                  <li><a class="dropdown-item" href="session_logout.php">Logout</a></li>
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
                <a href="tambah-data.php" class="btn btn-block text-light" style="background-color: #05595b;"><i class="bi bi-plus-lg"></i> Tambah Data</a>
              </div>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered display nowrap" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Tempat</th>
                      <th>Jenis Layanan</th>
                      <th>Kecamatan</th>
                      <th>Alamat</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php 
                      $data = "SELECT l.id_lokasi, l.nama, l.alamat, l.layanan, k.nama_kecamatan
                        FROM lokasi l, kecamatan k WHERE l.id_kecamatan = k.id_kecamatan";
                      $query = mysqli_query($conn, $data);
                      while ($row = mysqli_fetch_assoc($query)) {
                        $id = $row['id_lokasi'];
                        $nama = $row['nama'];
                        $layanan = $row['layanan'];
                        $kecamatan = $row['nama_kecamatan'];
                        $alamat = $row['alamat'];

                        echo "
                        <tr>
                        <td>$id</td>
                        <td>$nama</td>
                        <td>$layanan</td>
                        <td>$kecamatan</td>
                        <td>$alamat</td>
                        <td><a class='btn btn-warning' href='edit-data.php?id=$id'>Ubah</a> <a class='btn btn-danger' href='proses.php?p=hapus_lokasi&&id=$id'>Hapus</a></td>
                        </tr>";
                      }
                      
                      ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Nama Tempat</th>
                      <th>Jenis Layanan</th>
                      <th>Kecamatan</th>
                      <th>Alamat</th>
                      <th>Aksi</th>
                    </tr>
                  </tfoot>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.4.0/js/dataTables.select.min.js"></script>
    <script>
      $(document).ready(function () {
        $("#dataTable").DataTable({
          select: true,
          order: [[0, 'asc']],
          "columnDefs": [
            { "targets": 0, "visible": false}
          ],
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
