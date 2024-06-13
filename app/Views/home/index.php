<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Website Pakar</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicon -->
  <link href="../vendor/img/favicon.ico" rel="icon">

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

  <!-- Icon Font Stylesheet -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Libraries Stylesheet -->
  <link href="../vendor/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="../vendor/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

  <!-- Customized Bootstrap Stylesheet -->
  <link href="../vendor/css/bootstrap.min.css" rel="stylesheet">

  <!-- Template Stylesheet -->
  <link href="../vendor/css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="../vendor/css/styled.css">
</head>

<body>

  <!-- Navbar Start -->
  <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
    <?php if (isset($respon)) { ?>
      <a href="/" class="btn btn-primary m-2"><i class="fa fa-backspace me-2"></i>Kembali</a>
    <?php } ?>
    <div class="navbar-nav align-items-center ms-auto">

      <div class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
          <img class="rounded-circle me-lg-2" src="../vendor/img/user_kosong.jpg" alt="" style="width: 40px; height: 40px;">
          <span class="d-none d-lg-inline-flex"><?php echo session()->get("username") ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
          <a href="/users/logout" class="dropdown-item text-white">Log Out</a>
        </div>
      </div>
    </div>
  </nav>
  <!-- Navbar End -->

  <?php if (isset($respon)) { ?>


    <!-- Blank Start -->
    <div class="container-fluid pt-4 px-4">
      <div class="row vh-100 bg-secondary rounded align-items-center justify-content-center mx-0">
        <div class="col-md-4">
          <table class="table table-bordered text-center border-white">
            <thead>
              <tr>
                <th colspan="2">
                  <h4>Hasil</h4>
                </th>
              </tr>
              <tr>
                <th>
                  <h5>Status</h5>
                </th>
                <th>
                  <h5>Skor</h5>
                </th>
              </tr>
            </thead>
            <tbody class="text-white">
              <tr>
                <td class="p-4">
                  <?php
                  if (isset($status)) {
                    echo $status;
                  }
                  ?>
                </td>
                <td class="p-lg-4">
                  <?php
                  if (isset($score)) {
                    echo $score;
                  }
                  ?></td>
              </tr>
            </tbody>
          </table>
        </div>


        <div class="col-md-8 table-responsive">
          <table class="table table-bordered border-white">
            <thead class="text-center">
              <tr>
                <th>
                  <h5>Result</h5>
                </th>
              </tr>
            </thead>
            <tbody class="text-white">
              <tr>
                <td>
                  <p class="text-right p-3">
                    <?php
                    if (isset($tingkat)) {
                      echo "<h4>Tingkat Dehidrasi " . $stat . "</h4>";

                      echo $tingkat;
                    }
                    ?>
                  </p>
                  <p class="text-right p-3">
                    <?php
                    if (isset($dampak)) {
                      echo "<h4>Dampak Dehidrasi " . $stat . "</h4>";
                      echo $dampak;
                    }
                    ?>
                  </p>
                  <p class="text-right p-3">
                    <?php
                    if (isset($pelaksanaan)) {
                      echo "<h4>Pelaksanaan Dehidrasi " . $stat . "</h4>";
                      echo $pelaksanaan;
                    }
                    ?>
                  </p>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    </div>
    <!-- Blank End -->
  <?php } else { ?>


    <div class="container-fluid position-relative d-flex p-0">
      <!-- Blank Start -->
      <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary rounded h-100 p-4">
          <?php echo form_open("/") ?>
          <table class="table table-hover table-bordered text-left ">
            <thead class="color-font color-head">
              <tr>
                <th scope="col" colspan="4" class="p-4 text-center text-white h4">Quizioner Tingkat Dehidrasi</th>
              </tr>
            </thead>
            <tbody class="color-font text-white">
              <tr>
                <th scope="col" class="text-center h6"> Yang Dinilai</th>
                <td class="text-center text-white">1</td>
                <td class="text-center text-white">2</td>
                <td class="text-center text-white">3</td>
              </tr>
              <tr>
                <td class="text-white">Kesadaran Umum</td>
                <td>
                  <div class="form-check form-check-inline ">
                    <input class="form-check-input" type="radio" name="kesadaran_umum" id="kesadaran_umum_1" value="1" required>
                    <label class="form-check-label" for="kesadaran_umum_1">Baik</label>
                  </div>
                </td>
                <td>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="kesadaran_umum" id="kesadaran_umum_2" value="2" required>
                    <label class="form-check-label" for="kesadaran_umum_2">Normal, Lelah, Gelisah</label>
                  </div>
                </td>
                <td>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="kesadaran_umum" id="kesadaran_umum_3" value="3" required>
                    <label class="form-check-label" for="kesadaran_umum_3">Gelisah, Lemas, Mengantuk, Penurunan Kesadaran</label>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Mata</td>
                <td>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="mata" id="mata_1" value="1" required>
                    <label class="form-check-label" for="mata_1">Normal</label>
                  </div>
                </td>
                <td>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="mata" id="mata_2" value="2" required>
                    <label class="form-check-label" for="mata_2">Sedikit Cekung</label>
                  </div>
                </td>
                <td>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="mata" id="mata_3" value="3" required>
                    <label class="form-check-label" for="mata_3">Sangat Cekung</label>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Air Mata</td>
                <td>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="air_mata" id="air_mata_1" value="1" required>
                    <label class="form-check-label" for="air_mata_1">Ada</label>
                  </div>
                </td>
                <td>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="air_mata" id="arti_mata_2" value="2" required>
                    <label class="form-check-label" for="arti_mata_2">Berkurang</label>
                  </div>
                </td>
                <td>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="air_mata" id="arti_mata_3" value="3" required>
                    <label class="form-check-label" for="arti_mata_3">Tidak Ada</label>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Mulut Dan Lidah</td>
                <td>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="mulut_dan_lidah" id="mulut_dan_lidah_1" value="1" required>
                    <label class="form-check-label" for="mulut_dan_lidah_1">Bersih</label>
                  </div>
                </td>
                <td>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="mulut_dan_lidah" id="mulut_dan_lidah_2" value="2" required>
                    <label class="form-check-label" for="mulut_dan_lidah_2">Kering</label>
                  </div>
                </td>
                <td>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="mulut_dan_lidah" id="mulut_dan_lidah_3" value="3" required>
                    <label class="form-check-label" for="mulut_dan_lidah_3">Sangat Kering</label>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Rasa Haus</td>
                <td>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rasa_haus" id="rasa_haus_1" value="1" required>
                    <label class="form-check-label" for="rasa_haus_1">Minum Biasa, Tidak Haus</label>
                  </div>
                </td>
                <td>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rasa_haus" id="rasa_haus_2" value="2" required>
                    <label class="form-check-label" for="rasa_haus_2">Haus, Ingin Minum Banyak</label>
                  </div>
                </td>
                <td>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="rasa_haus" id="rasa_haus_3" value="3" required>
                    <label class="form-check-label" for="rasa_haus_3">Malas Minum Atau Tidak Bisa Minum</label>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Cubitan Kulit</td>
                <td>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="cubitan_kulit" id="cubitan_kulit_1" value="1" required>
                    <label class="form-check-label" for="cubitan_kulit_1">Segera Kembali</label>
                  </div>
                </td>
                <td>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="cubitan_kulit" id="cubitan_kulit_2" value="2" required>
                    <label class="form-check-label" for="cubitan_kulit_2">Kembali < 2 Detik</label>
                  </div>
                </td>
                <td>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="cubitan_kulit" id="cubitan_kulit_3" value="3" required>
                    <label class="form-check-label" for="cubitan_kulit_3">Kembali > 2 Detik</label>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Ekstremitas (Telapak Tangan Dan Kaki)</td>
                <td>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="ekstremitas" id="ekstremitas_1" value="1" required>
                    <label class="form-check-label" for="ekstremitas_1">Hangat</label>
                  </div>
                </td>
                <td>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="ekstremitas" id="ekstremitas_2" value="2" required>
                    <label class="form-check-label" for="ekstremitas_2">Agak Dingin</label>
                  </div>
                </td>
                <td>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="ekstremitas" id="ekstremitas_3" value="3" required>
                    <label class="form-check-label" for="ekstremitas_3">Dingin, Kebiruan</label>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Kencing</td>
                <td>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="kencing" id="kencing_1" value="1" required>
                    <label class="form-check-label" for="kencing_1">Normal</label>
                  </div>
                </td>
                <td>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="kencing" id="kencing_2" value="2" required>
                    <label class="form-check-label" for="kencing_2">Berkurang</label>
                  </div>
                </td>
                <td>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="kencing" id="kencing_3" value="3" required>
                    <label class="form-check-label" for="kencing_3">Minimal (Sedikit)</label>
                  </div>
                </td>
              </tr>

            </tbody>
          </table>
          <button class="btn btn-success w-100 m-2 p-3" type="submit">Hitung</button>
          <?php echo form_close() ?>




        </div>
      <?php }  ?>
      </div>

      <!-- Blank End -->

      <!-- Footer End -->
    </div>
    <!-- Content End -->


    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/lib/chart/chart.min.js"></script>
    <script src="../vendor/lib/easing/easing.min.js"></script>
    <script src="../vendor/lib/waypoints/waypoints.min.js"></script>
    <script src="../vendor/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../vendor/lib/tempusdominus/js/moment.min.js"></script>
    <script src="../vendor/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="../vendor/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="../vendor/js/main.js"></script>
</body>

</html>
