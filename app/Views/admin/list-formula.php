<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $_email = null;
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
            <h1 class="h3 mb-0 text-gray-800">List Formula</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">List Formula</li>
            </ol>
          </div>

          <div class="row mb-3">

            <div class="mb-4 mx-auto">
              <?php if (isset($success_edit) && !empty($success_edit)) { ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <h6><i class="fas fa-check"></i><b> Berhasil!</b></h6>
                  Berhasil mengedit data
                </div>
              <?php } ?>
              <?php
              if (isset($success_remove) && $success_remove == "1") { ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <h6><i class="fas fa-check"></i><b> Berhasil!</b></h6>
                  Berhasil Menghapus Soal
                </div>
              <?php }
              ?>

              <?php
              if (isset($error_validate) && !empty($error_validate)) { ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <h6><i class="fas fa-ban"></i><b> Error!</b></h6>
                  <?= $error_validate ?>
                </div>
              <?php }
              ?>
              <div class="card">
                <!-- Table With Hover -->
                <div class="col-lg-12">
                  <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">List Formula</h6>
                    </div>
                    <div class="table-responsive p-3">
                      <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                          <tr>
                            <th>Judul</th>
                            <th>Rata-Rata terendah</th>
                            <th>Rata-Rata tertinggi</th>
                            <th>Tingkat</th>
                            <th>Dampak</th>
                            <th>Pelaksanaan</th>
                            <th>Pencegahan</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if (isset($questions)) {
                            foreach ($questions as $quest) { ?>
                              <tr>
                                <td><?= $quest['name'] ?></td>
                                <td><?= $quest['range_min'] ?></td>
                                <td><?= $quest['range_max'] ?></td>
                                <td><?= $quest['tingkat'] ?></td>
                                <td><?= $quest['dampak'] ?></td>
                                <td><?= $quest['pelaksanaan'] ?></td>
                                <td><?= $quest['pencegahan'] ?></td>
                                <td>
                                  <div class="d-flex">
                                    <a href="/admin/edit-formula?id=<?= $quest['id'] ?>" class="btn btn-secondary">Edit</a>
                                    <div class="p-2"></div>
                                    <form action="/admin/delete-formula" method="POST">
                                      <input type="hidden" id="id" name="id" value="<?= $quest['id'] ?>">
                                      <input type="submit" value="Delete" class="btn btn-danger mb-1" data-target="#exampleModalCenter" id="#modalCenter">
                                    </form>
                                  </div>
                                </td>
                              </tr>
                          <?php  }
                          } ?>

                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End table -->
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
      let _email = null;
      $(document).ready(function() {
        $('#dataTable').DataTable({
          "pageLength": 5
        }); // ID From dataTable 
        $('#dataTableHover').DataTable({
          "pageLength": 5
        }); // ID From dataTable with Hover
      });

      function setData(email) {
        _email = email;
        document.getElementById("view_data").innerText = email;
        document.getElementById("value_email").setAttribute("value", email);
      }
    </script>

</body>

</html>
