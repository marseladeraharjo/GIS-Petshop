<?php 
  include "validasi_session.php";
  include "koneksi.php";

  // JUMLAH KECAMATAN, KELURAHAN
  $sql_count_kecamatan = "SELECT COUNT(id_kecamatan) AS jumlah_kecamatan FROM kecamatan";
  $countKecamatan = mysqli_query($conn, $sql_count_kecamatan);
  while ($row = mysqli_fetch_assoc($countKecamatan)) {
    $jumlahKecamatan = $row['jumlah_kecamatan'];
  }

  $sql_count_kelurahan = "SELECT COUNT(id_kelurahan) AS jumlah_kelurahan FROM kelurahan";
  $countKelurahan = mysqli_query($conn, $sql_count_kelurahan);
  while ($row = mysqli_fetch_assoc($countKelurahan)) {
      $jumlahKelurahan = $row['jumlah_kelurahan'];
  }

  $sql_count_utara = "SELECT COUNT(id_lokasi) AS jumlah_utara FROM lokasi WHERE id_kecamatan = 1";
  $countUtara = mysqli_query($conn, $sql_count_utara);
  while ($row = mysqli_fetch_assoc($countUtara)) {
    $jumlahUtara = $row['jumlah_utara'];
  }

  $sql_count_timur = "SELECT COUNT(id_lokasi) AS jumlah_timur FROM lokasi WHERE id_kecamatan = 2";
  $countTimur = mysqli_query($conn, $sql_count_timur);
  while ($row = mysqli_fetch_assoc($countTimur)) {
    $jumlahTimur = $row['jumlah_timur'];
  }

  $sql_count_barat = "SELECT COUNT(id_lokasi) AS jumlah_barat FROM lokasi WHERE id_kecamatan = 3";
  $countBarat = mysqli_query($conn, $sql_count_barat);
  while ($row = mysqli_fetch_assoc($countBarat)) {
    $jumlahBarat = $row['jumlah_barat'];
  }

  $sql_count_selatan = "SELECT COUNT(id_lokasi) AS jumlah_selatan FROM lokasi WHERE id_kecamatan = 4";
  $countSelatan = mysqli_query($conn, $sql_count_selatan);
  while ($row = mysqli_fetch_assoc($countSelatan)) {
    $jumlahSelatan = $row['jumlah_selatan'];
  }
  
  // KECAMATAN UNTUK SELECT OPTION
  $sqlKecamatan = "SELECT * FROM kecamatan ORDER BY nama_kecamatan ASC";
  $listKecamatan = mysqli_query($conn, $sqlKecamatan);

  // KELURAHAN DARI JAVASCRIPT AJAX
  if (isset($_GET['id_kecamatan'])) {
    if ($_GET['id_kecamatan'] != 0) {
      $result = [];
      $sqlKelurahan = "SELECT * FROM kelurahan WHERE id_kecamatan=".$_GET['id_kecamatan']." ORDER BY nama_kelurahan ASC";
      $listKelurahan = mysqli_query($conn, $sqlKelurahan);
      $rowKelurahan = [];
      while ($row = mysqli_fetch_assoc($listKelurahan)) {
        $temp = [];
        $temp['id_kelurahan'] = $row['id_kelurahan'];
        $temp['id_kecamatan'] = $row['id_kecamatan'];
        $temp['nama_kelurahan'] = $row['nama_kelurahan'];
        $rowKelurahan[] = $temp;
      }
      echo json_encode($rowKelurahan);
      exit;
    }
  }

  // DATA LOKASI DAN POLIGON
  if (isset($_POST['filter'])) {
    $result = [];
    $id_kecamatan = $_POST['id_kecamatan'];
    $id_kelurahan = $_POST['id_kelurahan'];
    $keyword = $_POST['keyword'];

    $sql_lokasi = "SELECT lokasi.*, kecamatan.nama_kecamatan, kelurahan.nama_kelurahan FROM lokasi 
            INNER JOIN kecamatan ON lokasi.id_kecamatan = kecamatan.id_kecamatan
            INNER JOIN kelurahan ON lokasi.id_kelurahan = kelurahan.id_kelurahan";

    if ($id_kecamatan != 0 || $id_kelurahan != 0 || $keyword != "") {
        $and_kecamatan = false;
        $and_lokasi = false;

        $sql_lokasi .= " WHERE ";
        if ($id_kecamatan != 0) {
            $sql_lokasi .= " kecamatan.id_kecamatan = ".$id_kecamatan;
            $and_kecamatan = true;
        }
        if ($id_kelurahan != 0) {
            $sql_lokasi .= $and_kecamatan === true ? " AND " : "";
            $sql_lokasi .= " kelurahan.id_kelurahan = ".$id_kelurahan;
            $and_lokasi = true;
        }
        if ($keyword != "") {
            $sql_lokasi .= $and_kecamatan === true || $and_lokasi === true ? " AND " : "";
            $sql_lokasi .= " lokasi.nama LIKE '%$keyword%'";
        }
    }

    $listLokasi = mysqli_query($conn, $sql_lokasi);
    $rowLokasi = [];
    $id_lokasi = [];
    while ($row = mysqli_fetch_assoc($listLokasi)) {
        $rowLokasi[] = $row;
        $id_lokasi[] = $row['id_lokasi'];
    }

    $sql_foto = "SELECT * FROM foto WHERE id_lokasi IN (".implode(",", $id_lokasi).")";
    $listFoto = mysqli_query($conn, $sql_foto);
    $rowFoto = [];

    while ($row = mysqli_fetch_assoc($listFoto)) {
        $temp = [];
        $temp['id_lokasi'] = $row['id_lokasi'];
        $temp['nama'] = $row['nama'];
        $rowFoto[] = $temp;
    }
    foreach ($rowLokasi as $indexLokasi => $lokasi) {
        foreach ($rowFoto as $foto) {
            if ($lokasi['id_lokasi'] == $foto['id_lokasi']) {
                $rowLokasi[$indexLokasi]['foto'][] = $foto['nama'];
            }
        }
    }

    $sql_poligon = "SELECT * FROM poligon ";
    $sql_poligon .= $id_kecamatan != 0 ? "WHERE id_kecamatan=".$id_kecamatan : "WHERE id_kecamatan = 5";


    $listPoligon = mysqli_query($conn, $sql_poligon);
    $rowPoligon = [];
    
    while ($row = mysqli_fetch_assoc($listPoligon)) {
        $rowPoligon[] = [$row['lat'], $row['lng']];
    }

    $result['poligon'] = $rowPoligon;
    $result['lokasi'] = $rowLokasi;
    $data = $result;
    echo json_encode($data);
    exit;
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
    <link href="https://api.tiles.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.css" rel="stylesheet" />

    <!-- My Style -->
    <link rel="stylesheet" href="style.css" />

    <!-- logo -->
    <link rel="shortcut icon" href="../logo.png">

    <title>Dashboard Admin | SIG Petshop</title>
  </head>
  <body>
    <section id="navbar">
      <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #fffaf4">
        <div class="container">
          <a class="navbar-brand" href="dashboard.php">
            <strong>SIG <span style="color: #05595b">PETSHOP</span> | Dashboard</strong>
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-gear-fill"></i>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navbarTogglerDemo02">
            <ul class="navbar-nav mb-2 mb-lg-0">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <strong>More</strong> </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
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

    <section id="filter-and-map">
      <div class="filter-and-map">
        <div class="container">
          <div class="row">
            <span class="col">
              <div class="card text-white mb-2" style="background-color: #557c55">
                <div class="card-body">
                  <h5 class="card-title text-center">Purwokerto Utara</h5>
                  <h4 class="card-text text-center"><?php echo $jumlahUtara ?></h4>
                </div>
              </div>
            </span>
            <span class="col">
              <div class="card text-white mb-2" style="background-color: #8b9a46">
                <div class="card-body">
                  <h5 class="card-title text-center">Purwokerto Timur</h5>
                  <h4 class="card-text text-center"><?php echo $jumlahTimur ?></h4>
                </div>
              </div>
            </span>
            <span class="col">
              <div class="card text-white mb-2" style="background-color: #557c55">
                <div class="card-body">
                  <h5 class="card-title text-center">Purwokerto Barat</h5>
                  <h4 class="card-text text-center"><?php echo $jumlahBarat ?></h4>
                </div>
              </div>
            </span>
            <span class="col">
              <div class="card text-white mb-2" style="background-color: #8b9a46">
                <div class="card-body">
                  <h5 class="card-title text-center">Purwokerto Selatan</h5>
                  <h4 class="card-text text-center"><?php echo $jumlahSelatan ?></h4>
                </div>
              </div>
            </span>
            <div class="col-sm-12">
              <div class="row">
                <div class="col-sm-3 mb-1">
                  <div class="form-group">
                    <select class="form-select" aria-label="Default select example" id="kecamatan" name="kecamatan">
                      <option value="0">Semua Kecamatan</option>
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
                </div>
                <div class="col-sm-3 mb-1">
                  <div class="form-group">
                    <select class="form-select" id="kelurahan" name="kelurahan">
                      <option value="0">Semua Kelurahan</option>
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
      $(function() {
        $('#kecamatan').trigger('change');
        $('#filter').trigger('click');
      });

      // Kelurahan berdasarkan Kecamatan
      $('#kecamatan').on('change', function () {
          if($(this).val() == 0){
              $('#kelurahan').empty();
              var kelurahan = '';
              kelurahan += "<option value='0'>Semua Kelurahan</option>";
              $('#kelurahan').append(kelurahan);
          } else {
              $.ajax({
                  type: 'GET',
                  data: {
                      id_kecamatan: $(this).val(),
                  },
                  dataType: 'json',
                  success: function (data) {
                      $('#kelurahan').empty();
                      var kelurahan = '';
                      kelurahan += "<option value='0'>Semua Kelurahan</option>";
                      for (var i = 0; i < data.length; i++) {
                          kelurahan += "<option value='" + data[i].id_kelurahan +
                              "' nama_kelurahan='" + data[i].nama_kelurahan +
                              "'>" + data[i].nama_kelurahan +
                              "</option>";
                      }
                      $('#kelurahan').append(kelurahan);
                  }
              });
          }
      });

      //Filter On Click
      $('#filter').on('click', function() {
            var id_kecamatan = $('#kecamatan option:selected').val();
            var id_kelurahan = $('#kelurahan option:selected').val();
            var keyword = $('#keyword').val();
            $.ajax({
                type: 'POST',
                data: {
                    filter: true,
                    id_kecamatan: id_kecamatan,
                    id_kelurahan: id_kelurahan,
                    keyword: keyword,
                },
                dataType: 'json',
                success: function (data) {
                    showPolygon(data.poligon, data.lokasi);
                }
            });
      });

      //Mapbox
      mapboxgl.accessToken ='pk.eyJ1IjoibWFyc2VsYWRlcmFoYXJqbyIsImEiOiJjbDV4cHBzZzEwdzA4M2ttcHc2bnhpMnM2In0.rqkuPeTWmIIRjq9ADpJoCw';

      function showPolygon(coordinates, lokasi){
            var map = new mapboxgl.Map({
                        container: 'map',
                        style: 'mapbox://styles/mapbox/outdoors-v11',
                        center: [109.2418414114881, -7.428974653891736],
                        zoom: 12,
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
            });

            lokasi.forEach(data => {

                var el = document.createElement('div');
                
                var html = '';
                html += "<b>" + data['nama'] + "</b>";
                html += "<p>("+data['layanan']+")</p>";
                html += "<p>Alamat: "+data['alamat']+"</p>";

                new mapboxgl
                    .Marker()
                    .setLngLat([data['lng'], data['lat']])
                    .setPopup(new mapboxgl.Popup({
                        offset: 50
                    }).setHTML(html))
                    .addTo(map);
            });
      }
    </script>
  </body>
</html>
