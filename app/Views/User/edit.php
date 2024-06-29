<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include(__DIR__ . '/../layouts/header.php');
  ?>
</head>

<body id="page-top">
  <div id="wrapper">
    <?php
    include(__DIR__ . '/../layouts/sidebar.php');
    ?>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <?php
        include(__DIR__ . '/../layouts/navbar.php');
        ?>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Account</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item"><a href="/account/list">List Account</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit Account</li>
            </ol>
          </div>
          <div class="row">

            <div class="col-lg-6 mx-auto">
              <?php
              if (isset($error_input) && !empty($error_input)) { ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <h6><i class="fas fa-ban"></i><b> Error!</b></h6>
                  <?= $error_input ?>
                </div>
              <?php }
              ?>

              <div class="card mb-4">

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Info Account</h6>
                </div>
                <div class="card-body">
                  <form method="POST" action="/account/postedit">
                    <div class="form-group row">
                      <label for="username" class="col-sm-3 col-form-label">Username</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="username" placeholder="Username" disabled value="<?= $data['username'] ?>">
                        <input type="hidden" name="username" value="<?= $data['username'] ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-3 col-form-label" disabled>Email</label>
                      <div class="col-sm-9">
                        <input type="email" class="form-control" name="email" placeholder="Email" value="<?= $data['email'] ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-3 col-form-label" disabled>Nama</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="name" placeholder="Name" value="<?= $data['name'] ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-3"> <label for="exampleFormControlSelect1">Admin</label></div>
                      <div class="col-9">
                        <select class="form-control" id="exampleFormControlSelect1" name="is_admin">
                          <option value="1" <?php echo ($data['is_admin'] == 1 ? 'selected' : ''); ?>>Iya</option>
                          <option value="0" <?php echo ($data['is_admin'] == 0 ? 'selected' : ''); ?>>Tidak</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-3"> <label for="exampleFormControlSelect1">Account Active</label></div>
                      <div class="col-9">
                        <select class="form-control" id="exampleFormControlSelect1" name="is_active">
                          <option value="1" <?php echo ($data['is_active'] == 1 ? 'selected' : '') ?>>Iya</option>
                          <option value="0" <?php echo ($data['is_active'] == 0 ? 'selected' : '') ?>>Tidak</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-12">
                        <input type="submit" class="btn btn-primary btn-block" value="Update"></input>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!---Container Fluid-->
          </div>
        </div>
      </div>
    </div>

    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../assets/js/ruang-admin.min.js"></script>
    <!-- Page level plugins -->
    <script src="../assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script>
      $(document).ready(function() {
        $('#dataTable').DataTable(); // ID From dataTable 
        $('#dataTableHover').DataTable(); // ID From dataTable with Hover
      });
    </script>

</body>

</html>
