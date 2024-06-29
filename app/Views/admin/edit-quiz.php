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
            <h1 class="h3 mb-0 text-gray-800">Edit Quiz</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit Kuisioner</li>
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
                  <h6 class="m-0 font-weight-bold text-primary">Edit Quiz</h6>
                </div>
                <div class="card-body">
                  <form method="POST" action="/question/post-edit">
                    <?php
                    if (isset($data)) {
                      echo "<input type='hidden' name='question_id' value='" . $data[0]['id'] . "'/>";
                    }
                    ?>
                    <div class="form-group row">
                      <label for="inputSoal" class="col-sm-3 col-form-label">Soal</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="soal" id="inputSoal" placeholder="Masukkan soal" value="<?= isset($data) ? $data[0]['name'] : '' ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-3">
                        <label for="textPilihan1">Pilihan 1</label>
                      </div>
                      <div class="col-sm-9">
                        <textarea class="form-control" id="textPilihan1" name="pilihan_1" rows="3"><?= isset($data) ? $data[0]['description'] : '' ?></textarea>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-3">
                        <label for="textPilihan2">Pilihan 2</label>
                      </div>
                      <div class="col-sm-9">
                        <textarea class="form-control" id="textPilihan2" name="pilihan_2" rows="3"><?= isset($data) ? $data[1]['description'] : '' ?></textarea>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-3">
                        <label for="textPilihan3">Pilihan 3</label>
                      </div>
                      <div class="col-sm-9">
                        <textarea class="form-control" id="textPilihan3" name="pilihan_3" rows="3"><?= isset($data) ? $data[2]['description'] : '' ?></textarea>
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
