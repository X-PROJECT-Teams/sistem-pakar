<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="../assets/img/logo/logo.png" rel="icon">
  <title>System Dehidrasi - Login</title>
  <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../assets/css/ruang-admin.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-login">
  <!-- Login Content -->
  <?php
  if (isset($error)) { ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <h6><i class="fas fa-ban"></i><b> Error!</b></h6>
      Gagal Login harap input ulang username dan password anda
    </div>
  <?php }
  ?>
  <?php
  if (isset($session_error) && $session_error == true) { ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <h6><i class="fas fa-ban"></i><b> Error!</b></h6>
      Session Anda Error Harap Login Ulang!
    </div>
  <?php }
  ?>
  <?php
  if (isset($logout) && $logout == true) { ?>
    <div class="alert alert-info alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <h6><i class="fas fa-info"></i><b> Information</b></h6>
      Anda Berhasil Logout silakan Login kembali!
    </div>
  <?php }
  ?>
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-4 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5 h-100">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Login</h1>
                  </div>
                  <form method="POST" action="/auth/postlogin">
                    <div class="form-group">
                      <input type="text" class="form-control" id="accountInput" aria-describedby="emailHelp" placeholder="Enter Email/Username" name="account">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" id="passwordInput" placeholder="Password" name="password">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck2" onclick="showPassword()">
                        <label class="custom-control-label" for="customCheck2">Show Password</label>
                      </div>
                    </div>
                    <div class="form-group">
                      <button class="btn btn-success btn-block bg-success" onclick="loginValidate()">Login</button>
                    </div>
                  </form>
                  <div class="text-center">
                    <a class="font-weight-bold" href="/auth/register">Create an Account!</a>
                  </div>
                  <div class="text-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Login Content -->
  <script src="../assets/vendor/jquery/jquery.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../assets/js/ruang-admin.min.js"></script>
  <script>
    function showPassword() {
      var x = document.getElementById("passwordInput");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
  </script>
</body>

</html>
