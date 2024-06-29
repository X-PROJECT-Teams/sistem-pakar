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
            <h1 class="h3 mb-0 text-gray-800">Edit Formula</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit Formula</li>
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
                  <h6 class="m-0 font-weight-bold text-primary">Edit Formula</h6>
                </div>
                <div class="card-body">
                  <form method="POST" action="/admin/post-edit-formula">
                    <input type="hidden" name="id" value="<?= $data['id'] ?>">
                    <div class="form-group row">
                      <label for="inputSoal" class="col-sm-3 col-form-label">Judul</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="judul" id="inputSoal" placeholder="Contoh dehidrasi berat...." value="<?= $data['name'] ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-3">
                        <label for="tingkat">Tingkat</label>
                      </div>
                      <div class="col-sm-9">
                        <textarea class="form-control" id="tingkat" name="tingkat"><?= $data['tingkat'] ?>
                        </textarea>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-3">
                        <label for="dampak">Dampak</label>
                      </div>
                      <div class="col-sm-9">
                        <textarea class="form-control" id="dampak" name="dampak"><?= $data['dampak'] ?>
                        </textarea>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-3">
                        <label for="pelaksanaan">Pelaksanaan</label>
                      </div>
                      <div class="col-sm-9">
                        <textarea class="form-control" id="pelaksanaan" name="pelaksanaan"><?= $data['pelaksanaan'] ?>
                        </textarea>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-3">
                        <label for="pencegahan">Pencegahan</label>
                      </div>
                      <div class="col-sm-9">
                        <textarea class="form-control" id="dpencegahan" name="pencegahan"><?= $data['pencegahan'] ?>
                        </textarea>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputRangeMin" class="col-sm-3 col-form-label">Range Min</label>
                      <div class="col-sm-9">
                        <input type="number" class="form-control" name="range_min" id="inputRangeMin" value="<?= $data['range_min'] ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputRangeMax" class="col-sm-3 col-form-label">Range Max</label>
                      <div class="col-sm-9">
                        <input type="number" class="form-control" name="range_max" id="inputRangeMax" value="<?= $data['range_max'] ?>">
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
