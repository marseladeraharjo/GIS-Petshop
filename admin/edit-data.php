<?php 
include "validasi_session.php";
include "koneksi.php";

// KECAMATAN UNTUK SELECT OPTION
$id = $_GET['id'];
$sqlKecamatan = "SELECT * FROM kecamatan ORDER BY nama_kecamatan ASC";
$listKecamatan = mysqli_query($conn, $sqlKecamatan);

$sqlKelurahan = "SELECT * FROM kelurahan";
$listKelurahan = mysqli_query($conn, $sqlKelurahan);

$sqlFoto = "SELECT * FROM foto WHERE id_lokasi = '$id'";
$listFoto = mysqli_query($conn, $sqlFoto);

// KELURAHAN DARI JAVASCRIPT AJAX
if (isset($_GET['id_kecamatan'])) {
   if ($_GET['id_kecamatan'] != 0) {
    $getKec = $_GET['id_kecamatan'];
    $result = [];

    $sqlPoligon = "SELECT * FROM poligon WHERE id_kecamatan =".$getKec;
    $listPoligon = mysqli_query($conn, $sqlPoligon);
    $rowPoligon = [];
    while ($row = mysqli_fetch_assoc($listPoligon)) {
      $rowPoligon[] = [$row['lat'], $row['lng']];
    }
    $result['poligon'] = $rowPoligon;

    echo json_encode($result);
    exit;
   }
}

$query = mysqli_query($conn, "SELECT * FROM lokasi WHERE id_lokasi = '$id'");
while ($value = mysqli_fetch_assoc($query)) {
  $nama = $value['nama'];
  $telp = $value['telp'];
  $kecamatan = $value['id_kecamatan'];
  $kelurahan = $value['id_kelurahan'];
  $jadwal = $value['jadwal'];
  $alamat = $value['alamat'];
  $info = $value['info'];
  $lat = $value['lat'];
  $lng = $value['lng'];
  $layanan = explode(', ', $value['layanan']);

  $items = array("nama" => "$nama", "info" => "$info", "alamat" => "$alamat", "jadwal" => "$jadwal", "telp" => "$telp", "kecamatan" => "$kecamatan", "kelurahan" => "$kelurahan", "lat" => "$lat", "lng" => "$lng");
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

    <!-- Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css" />

    <!-- Mapbox -->
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.css" rel="stylesheet" />

    <!-- My Style -->
    <link rel="stylesheet" href="style.css" />

    <!-- logo -->
    <link rel="shortcut icon" href="../logo.png">

    <title>Edit Data | SIG Petshop</title>
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
                  <li><a class="dropdown-item" href="data-petshop.php">Data Petshop</a></li>
                  <li><a class="dropdown-item" href="session_logout.php">Logout</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <hr style="margin: 0px 0px; height: 1px; opacity: 0.5" />
    </section>

    <section id="tambah-data-form">
      <div class="tambah-data-form">
        <div class="container">
          <div class="row text-center">
            <h4>Ubah Data</h4>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div id="map" class="map shadow mt-4" style="width: 100%; height: 500px"></div>
            </div>
            <div class="col-sm-12 mt-4">
              <form action="proses.php?p=ubah_lokasi" method="POST" enctype="multipart/form-data">
              <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text font-weight-bold text-light" style="background-color: #05595b" id="label-latitude">Latitude</span>
                          </div>
                          <input type="text" class="form-control" id="lat" name="lat" aria-describedby="label-latitude" value="<?php echo $items['lat']; ?>" readonly />
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text font-weight-bold text-light" style="background-color: #05595b" id="label-longitude">Longitude</span>
                          </div>
                          <input type="text" class="form-control" id="lng" name="lng" aria-describedby="label-longitude" value="<?php echo $items['lng']; ?>" readonly/>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="">Nama Petshop</label>
                      <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $items['nama']; ?>" placeholder="Masukan nama petshop"/>
                    </div>
                    <div class="form-group">
                      <label for="phone">No. Telp</label>
                      <input type="tel" id="phone" name="phone" class="form-control" value="<?php echo $items['telp']; ?>" placeholder="Masukan no. telp" />
                    </div>
                    <div class="form-group">
                      <label for="">Kecamatan</label>
                      <select class="form-select" id="kecamatan" name="kecamatan">
                        <?php 
                          while ($row = mysqli_fetch_assoc($listKecamatan)) {
                            ?>
                          <option value="<?php echo $row['id_kecamatan']; ?>">
                            <?php echo $row['nama_kecamatan']; ?></option>
                          <?php 
                        }
                           ?>
                        
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="">Kelurahan</label>
                      <select class="form-select" id="kelurahan" name="kelurahan">
                        <?php 
                          while ($row = mysqli_fetch_assoc($listKelurahan)) {
                            ?>
                            <option class="<?php echo $row['id_kecamatan']; ?>" value="<?php echo $row['id_kelurahan']; ?>" >
                            <?php echo $row['nama_kelurahan']; ?></option>
                            <?php 
                          }
                            ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="">Jenis Layanan</label><br>
                      <label>
                        <input type="checkbox" name="layanan[]" value="Shop" <?php if(in_array("Shop", $layanan)) {echo "checked";} ?>>Shop
                      </label> <br>
                      <label>
                        <input type="checkbox" name="layanan[]" value="Clinic" <?php if(in_array("Clinic", $layanan)) {echo "checked";} ?>>Clinic
                      </label> <br>
                      <label>
                        <input type="checkbox" name="layanan[]" value="Hotel" <?php if(in_array("Hotel", $layanan)) {echo "checked";} ?>>Hotel
                      </label> <br>
                      <label>
                        <input type="checkbox" name="layanan[]" value="Grooming" <?php if(in_array("Grooming", $layanan)) {echo "checked";} ?>>Grooming
                      </label> <br> 
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="">Jadwal Operasional</label>
                      <input type="text" class="form-control" id="jadwal" name="jadwal" value="<?php echo $items['jadwal']; ?>" placeholder="Masukkan jadwal operasional" />
                    </div>
                    <div class="form-group">
                      <label for="">Alamat</label>
                      <textarea class="form-control" id="alamat" name="alamat" rows="4"><?php echo $items['alamat']; ?></textarea>
                    </div>
                    <div class="form-group">
                      <label for="formFileMultiple" class="form-label mb-auto">Foto</label>
                      <input class="form-control" type="file" id="formFileMultiple" name="foto[]" accept="image/*" multiple />
                      <!-- <label for="">Foto</label>
                      <input type="file" class="form-control" name="foto[]" accept="image/*" multiple /> -->
                    </div>
                    <div class="row mt-2">
                      <?php 
                      while ($row = mysqli_fetch_assoc($listFoto)) {
                      ?>
                        <div class="col-sm-3" style="float: left;">
                          <div class="thumbnail shadow" style="border-radius: 1em; background-color: white; ">
                            <img src="images/<?php echo $row['nama'] ?>" alt="Lights" class="d-block w-100 shadow" style="border-radius: 1em;">
                            <div class="caption">
                              <a class="btn btn-danger mt-2" href="#" onclick="confirm_modal('proses.php?p=hapus_foto&&id=<?php echo $row['id_foto'] ?>&&id_lokasi=<?php echo $row['id_lokasi'] ?>')">Hapus</a>
                            </div>
                          </div>
                        </div>
                        <?php 
                      }
                        ?>
                    </div>
                  </div>
                </div>
                <div class="row mt-2">
                  <div class="col-sm-12">
                    <label for="">Info Detail</label>
                    <textarea class="ckeditor" id="ckedtor" name="info"><?php echo $items['info']; ?></textarea>
                  </div>
                </div>
                <div class="row mt-2">
                  <div class="col-sm-12 d-flex justify-content-center">
                    <button type="submit" class="btn btn-block text-light" style="background-color: #05595b">Simpan</button>
                    <a href="data-petshop.php" class="btn btn-block btn-danger text-light ms-1">Batal</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal Popup untuk delete -->
      <div class="modal fade" id="modal_delete">
        <div class="modal-dialog">
          <div class="modal-content" style="margin-top:30vh;">
            <div class="modal-header">
                <h6 class="modal-title" style="text-align: center;">Anda yakin akan menghapus foto ini...?</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer" style="margin: 0px; border-top: 0px; text-align: center;">
                <a href="#" class="btn btn-danger btn-sm" id="delete_link">Hapus</a>
                <button type="button" class="btn btn-success btn-sm" data-bs-dismiss="modal">Batal</button>
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
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.js"></script>
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
    <script src="jquery.chained.js"></script>

    <!-- js untuk popup modal delete -->
    <script type="text/javascript">
      function confirm_modal(delete_url){
        $('#modal_delete').modal('show', {backdrop: 'static'});
        document.getElementById('delete_link').setAttribute('href', delete_url);
      }
    </script>

    <script>
      $(function() {
        mapboxgl.accessToken = 'pk.eyJ1IjoibWFyc2VsYWRlcmFoYXJqbyIsImEiOiJjbDV4cHBzZzEwdzA4M2ttcHc2bnhpMnM2In0.rqkuPeTWmIIRjq9ADpJoCw';

        var map = new mapboxgl.Map({
          container: 'map',
          style: 'mapbox://styles/mapbox/streets-v11',
          center: [109.2418414114881, -7.428974653891736],
          zoom: 11,
        });

        marker = new mapboxgl.Marker();
      });

      // Kelurahan berdasarkan Kecamatan
      $('#kecamatan').on('change', function () {
        $.ajax({
          type: 'GET',
          data: {
            id_kecamatan: $(this).val(),
          },
          dataType: 'json',
          success: function (data) {
            console.log(data);
            showPolygon(data.poligon);
            getKecamatan();
          }
        });
      });


      // Mapbox
      function showPolygon(coordinates) {
        var map = new mapboxgl.Map({
          container: "map",
          style: "mapbox://styles/mapbox/streets-v11",
          center: [109.2418414114881, -7.428974653891736],
          zoom: 11.5,
        });

        map.on('load', function () {
          map.addLayer({
            'id': 'maine',
            'type': 'fill',
            'source': {
              'type': 'geojson',
              'data': {
                'type': 'Feature',
                'geometry': {
                  'type': 'Polygon',
                  'coordinates': [coordinates]
                }
              }
            },
            'layout': {},
            'paint': {
              'fill-color': '#088',
              'fill-opacity': 0.5
            }
          });

          // Hanya bisa tambah marker di dalam poligon
          map.on('click', 'maine', function (e) {
            var lat = e.lngLat.lat;
            var lng = e.lngLat.lng;
            marker.setLngLat([lng, lat]).addTo(map);
            $('#lat').val(lat);
            $('#lng').val(lng);
          });
        });
      }

      // Set option di form select menjadi selected
      $("#kecamatan").val("<?php echo $items['kecamatan']; ?>").attr('selected','selected');
      $("#kelurahan").val("<?php echo $items['kelurahan']; ?>").attr('selected','selected');


      // Set chained combobox Kelurahan ke Kecamatan
      $("#kelurahan").chainedTo("#kecamatan");
      $("#kecamatan").on("change", function () {
        $('#kecamatan option').prop('selected', function() {
          return this.defaultSelected;
        });
        $('#kelurahan option').prop('selected', function() {
          return this.defaultSelected;
        });
      });
    </script>
  </body>
</html>
