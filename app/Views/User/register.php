<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="../assets/img/logo/logo.png" rel="icon">
  <title>RuangAdmin - Register</title>
  <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../assets/css/ruang-admin.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body class="bg-gradient-login">
  <!-- Register Content -->
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-4 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form mb-4 min-vh-100">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Register</h1>
                  </div>
                  <form id="registerForm" method="POST" action="/auth/register">
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Enter Email Address">
                    </div>
                    <div class="form-group">
                      <label>Username</label>
                      <input type="text" class="form-control" name="username" placeholder="Enter Username">
                    </div>
                    <div class="form-group">
                      <label>Nama</label>
                      <input type="text" class="form-control" name="name" placeholder="Enter Name">
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <label>Repeat Password</label>
                      <input type="password" class="form-control" id="confirmPassword" name="password_repeat" placeholder="Repeat Password">
                    </div>

                    <div class="is-invalid-icon d-none">

                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-success btn-block">Register</button>
                    </div>
                  </form>

                  <div class="text-center">
                    <a class="font-weight-bold small" href="/auth/login">Already have an account?</a>
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
  <!-- Register Content -->
  <script src="../assets/vendor/jquery/jquery.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../assets/js/ruang-admin.min.js"></script>
  <script>
    document.getElementById('registerForm').addEventListener('submit', function(event) {
      event.preventDefault(); // Mencegah form submit default

      var password = document.getElementById('password').value;
      var confirmPassword = document.getElementById('confirmPassword');

      if (password !== confirmPassword.value) {
        confirmPassword.classList.add('is-invalid');
        confirmPassword.focus();
        document.querySelector('.is-invalid-icon').classList.remove('d-none');
      } else {
        confirmPassword.classList.remove('is-invalid');
        document.querySelector('.is-invalid-icon').classList.add('d-none');
        this.submit();
      }
    });

    // Tambahkan event listener untuk menghapus kelas is-invalid saat pengguna mulai mengetik
    document.getElementById('confirmPassword').addEventListener('input', function() {
      this.classList.remove('is-invalid');
      document.querySelector('.is-invalid-icon').classList.add('d-none');
    });
  </script>
</body>

</html>
