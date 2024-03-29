<?php 
  require "./koneksi.php";

  // Cek login
  if(isset($_POST['submit_login'])){

    // cek database
    session_start();
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM admin where username='".$username."' and password='".md5($password)."'";
    $data = mysqli_query($conn, $sql);

    $cek = mysqli_num_rows($data);
    $row = mysqli_fetch_assoc($data);

    if(!is_null($row)){
      
    }
    if($cek > 0) {
      if(!is_null($row)){
        $_SESSION['admin'] = $row;
        header("Location: dashboard.php");
      }
    } else {
      header("Location: login.php?pesan=gagal");
    }
    // $result = $conn->query($sql);
    // $row = mysqli_fetch_assoc($result);
        
    // if(!is_null($row)){
    //     session_start();
    //     $_SESSION["admin"] = $row;
    //     $_SESSION["status"] = "login";
    //     header("Location: dashboard.php");
    // } else {
    //   header("Location:login.php?pesan=gagal");
    // }
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

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

    <!-- My Style -->
    <link rel="stylesheet" href="style.css" />

    <!-- logo -->
    <link rel="shortcut icon" href="../logo.png">

    <title>Login | SIG Petshop</title>
  </head>
  <body>
    <div class="container">
      <div class="row justify-content-center my-5">
        <div class="col-xl-4 col-lg-5 col-md-6 col-sm-7">
          <div class="card shadow">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="p-5">
                    <div class="text-center">
                      <a href="../beranda.php" style="text-decoration: none; color: black;">
                        <h3>
                          <strong>SIG <span style="color: #05595b">PETSHOP</span></strong>
                        </h3>
                        <p><strong>Kota Purwokerto</strong></p>
                      </a>
                      <!-- pesan notifikasi -->
                      <?php 
                      if (isset($_GET['pesan'])) {
                        if($_GET['pesan'] == "gagal"){
                          echo "username atau password salah!";
                        } else if($_GET['pesan'] == "logout"){
                          echo "Anda berhasil logout";
                        } 
                      }
                      ?>
                    </div>
                    <form class="mt-5" method="POST">
                      <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="&#xf007;  username" style="font-family: Arial, FontAwesome" />
                      </div>
                      <div class="form-group">
                        <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="&#xf023;  password" style="font-family: Arial, FontAwesome" />
                      </div>
                      <div class="d-grid gap-2">
                        <button class="btn text-light btn-user" style="background-color: #05595b; border-radius: 10rem" type="submit" name="submit_login"><strong>Masuk</strong></button>
                      </div>
                      <div class="text-center mt-1">
                        <a href="../beranda.php" style="color: #05595b;"><small>Kembali</small></a>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>
