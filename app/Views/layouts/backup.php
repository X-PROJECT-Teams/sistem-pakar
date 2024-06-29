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
        <?php
        include(__DIR__ . '/../layouts/navbar.php');
        ?>

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">List Account</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Kuisioner</a></li>
              <li class="breadcrumb-item active" aria-current="page">Home</li>
            </ol>
            <div class="row mb-3">

            </div>
            <div class="mb-4 mx-auto">
              <div class="card">
                <!-- Table With Hover -->
                <div class="col-lg-12">
                  <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">List Account</h6>
                    </div>
                    <div class="table-responsive p-3">
                      <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                          <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </tfoot>
                        <tbody>
                          <?php
                          if (isset($data)) {
                            foreach ($data as $user) { ?>
                              <tr>
                                <td><a href="#">ID<?= $user['id'] ?></a></td>
                                <td><?= $user['username'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td><?= $user['name'] ?></td>
                                <td><?php echo ($user['is_admin'] ?
                                      '<span class="badge badge-success">Admin</span>' :
                                      '<span class="badge badge-warning">Member</span>')
                                    ?></td>
                                <td>
                                  <div class="d-flex">
                                    <button type="button" class="btn btn-secondary mb-1 me-3">Edit</button>
                                    <div class="p-2"></div>
                                    <button type="button" class="btn btn-danger mb-1" onclick="deleteUser('<?= $user['email'] ?>')">Delete</button>
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
          </div>

        </div>

        <!---Container Fluid-->
      </div>

    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

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


    function deleteUser(email) {
      let testToken = `eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvZGVoaWRyYXNpLnd0d2J1aWxkaW5nLm15LmlkIiwiYXVkIjoiUml6a2kiLCJzdWIiOiI3IiwibmJmIjoxNzE4MzI2MDU1LCJpYXQiOjE3MTgzMjYwNDUsImV4cCI6MTcxODMyOTY0NSwiZGF0YSI6eyJlbWFpbCI6InRlc3QyOTAyQGdtYWlsLmNvbSJ9fQ.ITbOF_w_05tisR0j17NglNtV-UdMnE_p67y76ZqNv4M`;
      fetch(`/api/auth/remove_account?email=${encodeURIComponent(email)}&token=` + testToken, {
          method: 'DELETE'
        })
        .then(response => {
          if (response.ok) {
            alert("User deleted successfully.");
            window.location.reload();
          } else {
            throw new Error('Failed to delete user.');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert(error.message);
        });
    }
  </script>

</body>

</html>
