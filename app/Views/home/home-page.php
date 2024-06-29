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

    .button-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100px;
      /* Adjust as needed */
    }

    .btn {
      margin-top: 20px;
      /* Adjust as needed */
    }

    .card {
      margin-top: 20px;
    }

    .justify-content-center {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .img-fluid {
      max-width: 100%;
      height: auto;
    }

    .pt-5 {
      padding-top: 3rem !important;
    }

    .logo {
      margin-bottom: 20px;
      animation: bounce 2s infinite;
      margin: 20px 0;
    }

    @keyframes bounce {

      0%,
      100% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-20px);
      }
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
          <div class="container-lg">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-12 col-md-3 d-flex justify-content-center align-items-center">
                    <img src="/assets/img/logo/air.jpg" alt="" class="img-fluid logo" width="500" />
                  </div>
                  <div class="col-12 col-md-8 pt-5 ">
                    <h1 class="text-primary">Terhidrasi</h1>
                    <div class="card">
                      <div class="card-body">
                        <p class="card-title">
                          Selamat Datang, dan salam kenal Saya “TERHIDRASI” yang
                          akan membantu anda atau keluarga anda untuk memonitor
                          tingkat dehidrasi (kegawatdaruratan) dan memberikan solusi
                          rencana tindak lanjut terlait kecukupan cairan tubuh.
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="text-center ">
                  <a href="/start" class="btn btn-primary btn-lg">
                    Mulai
                  </a>
                </div>
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
