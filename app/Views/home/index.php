<?php
$groupData = [];
if (isset($questions)) {
  foreach ($questions as $quest) {
    $id = $quest['id'];
    if (!isset($groupData[$id])) {
      $groupData[$id] = [
        'id' => $id,
        'name' => $quest['name'],
        'nama' =>  $quest['nama'],
        'options' => []
      ];
    }
    $groupData[$id]['options'][$quest['index_score']] = $quest['description'];
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include(__DIR__ . '/../layouts/header.php');
  ?>
  <style>
    .modal-backdrop {
      opacity: 0.5 !important;
      background-color: #000 !important;
    }

    /* Desain harga */
    .price-container {
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      font-weight: bold;
      color: #333;
    }

    .original-price {
      text-decoration: line-through;
      margin-right: 20px;
      font-size: 1.5rem;
      color: #999;
    }

    .discount-price {
      color: #e74c3c;
      /* Warna merah */
    }

    .btn-close {
      transition: transform 0.3s ease;
      /* Animasi transformasi */
    }

    .btn-close:hover {
      transform: translateX(-5px);
      /* Bergerak ke kiri saat hover */
    }
  </style>
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
          <form action="/question/hasil" method="GET">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
              <h1 class="h3 mb-0 text-gray-800">Kuisioner</h1>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kuisioner</li>
              </ol>
            </div>
            <div class="row mb-3">
              <?php if (isset($success_insert) && !empty($success_insert)) { ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <h6><i class="fas fa-check"></i><b> Berhasil!</b></h6>
                  Rating anda telah dikirim
                </div>
              <?php } ?>
              <div class="table-responsive">
                <table class="table align-items-center table-flush">
                  <thead class="thead-light">
                    <tr>
                      <th>Kategori Penilaian</th>
                      <th>Pilihan 1</th>
                      <th>Pilihan 2</th>
                      <th>Pilihan 3</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php
                    foreach ($groupData as $quest) { ?>
                      <tr>
                        <td><?= $quest['name'] ?></td>
                        <?php
                        foreach ($quest['options'] as  $index => $opsi) { ?>
                          <td>
                            <div class="custom-control custom-radio">
                              <input type="radio" id="pilihan<?= $quest['id'] . $index ?>" value="<?= $index ?>" name="pilihan<?= $quest['id'] ?>" class="custom-control-input">
                              <label class="custom-control-label" for="pilihan<?= $quest['id'] . $index ?>"><?= $opsi ?></label>
                            </div>
                          </td>
                        <?php }
                        ?>
                      </tr>
                    <?php }
                    ?>
                  </tbody>
                </table>
              </div>

              <!-- Iklan
            <div class="modal" id="adModal" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content" style="background-color: #fff; border-radius: 30px; box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);">
                  <div class="modal-body text-center py-5">
                    <h2 class="mb-4">🎉 Selamat Datang! 🎉</h2>
                    <p class="fs-5 mb-4">Jangan lewatkan kesempatan istimewa ini!</p>
                     Desain harga -->
              <!-- <div class="price-container mb-3">
                      <span class="original-price">Rp 1.900.000</span>
                      <span class="discount-price">Rp 1.300.000</span>
                    </div> -->
              <!-- <p class="text-muted mb-4">Harga awal</p>
                    <p class="fs-4 mb-4">Harga Spesial Hari Ini!</p>
                    <p class="text-muted mb-4">Anda harus membayar terlebih dahulu sebelum mengakses fitur-fitur kami.</p> -->
              <!-- Tombol untuk menutup modal -->
              <!-- <button type="button" id="tombol_nakal" class="btn btn-danger btn-lg btn-close" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary btn-lg">Bayar Sekarang!</button>
                  </div>
                </div>
              </div>
            </div> -->
              <!-- Iklan -->
            </div>
            <button type="submit" class="btn btn-primary btn-block">Hitung</button>
          </form>
          <!---Container Fluid-->
        </div>
      </div>
    </div>
  </div>


  <script src="../assets/vendor/jquery/jquery.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../assets/js/ruang-admin.min.js"></script>
  <script src="../assets/vendor/chart.js/Chart.min.js"></script>
  <script src="../assets/js/demo/chart-area-demo.js"></script>
  <script>
    document.getElementById('openAd').addEventListener('click', function() {
      $('#adModal').modal('show');
    });

    // LISTENER EVENT TOMBOL BERGERAK
    function makeNaughtyButtonMove(event) {
      const button = document.getElementById('tombol_nakal');
      const modal = document.querySelector('.modal-content');
      const modalRect = modal.getBoundingClientRect();
      const buttonRect = button.getBoundingClientRect();
      let newX = event.clientX - buttonRect.width / 2;
      let newY = event.clientY - buttonRect.height / 2;

      // Membalik arah jika tombol mencapai batas modal
      if (newX < modalRect.left || newX + buttonRect.width > modalRect.right) {
        newX = Math.min(Math.max(newX, modalRect.left), modalRect.right - buttonRect.width);
      }
      if (newY < modalRect.top || newY + buttonRect.height > modalRect.bottom) {
        newY = Math.min(Math.max(newY, modalRect.top), modalRect.bottom - buttonRect.height);
      }

      button.style.transform = `translate(${newX}px, ${newY}px)`;
    }

    // Event saat cursor bergerak
    document.querySelector('.modal-content').addEventListener('mousemove', makeNaughtyButtonMove);
  </script>
</body>

</html>
