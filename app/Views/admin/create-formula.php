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
            <h1 class="h3 mb-0 text-gray-800">Menambahkan Formula</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Menambahkan Formula</li>
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

              <?php
              if (isset($success_insert) && $success_insert == "1") { ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <h6><i class="fas fa-check"></i><b> Berhasil!</b></h6>
                  Berhasil Menambahkan data
                </div>
              <?php }
              ?>

              <div class="card mb-4">

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Menambahkan Formula</h6>
                </div>
                <div class="card-body">
                  <form method="POST" action="/admin/post-create-formula">
                    <div class="form-group row">
                      <label for="inputSoal" class="col-sm-3 col-form-label">Judul</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="judul" id="inputSoal" placeholder="Contoh dehidrasi berat....">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-3">
                        <label for="tingkat">Tingkat</label>
                      </div>
                      <div class="col-sm-9">
                        <textarea class="form-control" id="tingkat" name="tingkat"></textarea>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-3">
                        <label for="dampak">Dampak</label>
                      </div>
                      <div class="col-sm-9">
                        <textarea class="form-control" id="dampak" name="dampak"></textarea>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-3">
                        <label for="pelaksanaan">Pelaksanaan</label>
                      </div>
                      <div class="col-sm-9">
                        <textarea class="form-control" id="pelaksanaan" name="pelaksanaan"></textarea>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-3">
                        <label for="pencegahan">Pencegahan</label>
                      </div>
                      <div class="col-sm-9">
                        <textarea class="form-control" id="pencegahan" name="pencegahan"></textarea>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputRangeMin" class="col-sm-3 col-form-label">Range Min</label>
                      <div class="col-sm-9">
                        <input type="number" class="form-control" name="range_min" id="inputRangeMin">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputRangeMax" class="col-sm-3 col-form-label">Range Max</label>
                      <div class="col-sm-9">
                        <input type="number" class="form-control" name="range_max" id="inputRangeMax">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-12">
                        <input type="submit" class="btn btn-primary btn-block" value="Buat Formula"></input>
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
