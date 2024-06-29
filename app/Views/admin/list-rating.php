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
            <h1 class="h3 mb-0 text-gray-800">List Rating</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">List Rating</li>
            </ol>
          </div>

          <div class="row mb-3">

            <div class="mb-4 mx-auto">

              <!-- Table With Hover -->
              <div class="col-lg-12">
                <div class="card mb-4">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">List Rating</h6>
                  </div>
                  <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover" width="100%">
                      <thead class="thead-light">
                        <tr>
                          <th>Username</th>
                          <th>Nama</th>
                          <th>Rating</th>
                          <th>Komentar</th>
                          <th></th>
                          <th></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if (isset($data)) {
                          foreach ($data as $rating) { ?>
                            <tr>
                              <td><?= $rating['username'] ?></td>
                              <td><?= $rating['nama'] ?></td>
                              <td><?= $rating['rating'] ?></td>
                              <td colspan="3"><?= $rating['komentar'] ?></td>
                            </tr>
                        <?php }
                        } ?>
                      </tbody>
                    </table>
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
