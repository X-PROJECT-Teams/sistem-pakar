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
          <div class="row mt-5 justify-content-center align-items-center">
            <div class="col-lg-6">
              <div class="card">
                <div class="card-header">
                  Silahkan jawab pertanyaan dibawah ini sesuai kondisi yang dialami
                  saat ini
                </div>
                <div class="card-body">
                  <form action="/question/hasil" method="GET">
                    <?php foreach ($groupData as $index => $quest) { ?>
                      <div class="question" style="display: none;" id="question<?= $index ?>">
                        <h5 class="card-title">
                          <?= $quest['name']; ?>
                        </h5>

                        <?php

                        foreach ($quest['options'] as  $index => $opsi) { ?>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" id="pilihan<?= $quest['id'] . $index ?>" name="pilihan<?= $quest['id'] ?>" value="<?= $index ?>" />
                            <label class="form-check-label" for="pilihan<?= $quest['id'] . $index ?>"><?= $opsi ?></label>
                          </div>

                        <?php }
                        ?>
                      </div>
                    <?php } ?>
                    <div class="mt-3 d-flex justify-content-between">
                      <button type="button" class="btn btn-primary text-white" id="prevBtn" style="visibility: hidden">Sebelumnya</button>
                      <button type="button" class="btn btn-primary text-white" id="nextBtn">Selanjutnya</button>
                      <button type="submit" class="btn btn-primary text-white" id="submitBtn" style="display: none">Kirim</button>
                    </div>
                  </form>
                  <p id="warning" style="color: red; display: none">
                    Silahkan pilih salah satu opsi sebelum melanjutkan.
                  </p>
                </div>
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
    document.addEventListener('DOMContentLoaded', function() {
      const questions = document.querySelectorAll('.question');
      const prevBtn = document.getElementById('prevBtn');
      const nextBtn = document.getElementById('nextBtn');
      const submitBtn = document.getElementById('submitBtn');

      let currentQuestionIndex = 0;

      function showQuestion(index) {
        questions.forEach((question, i) => {
          question.style.display = i === index ? 'block' : 'none';
        });

        prevBtn.style.visibility = index > 0 ? 'visible' : 'hidden';
        nextBtn.style.display = index < questions.length - 1 ? 'inline-block' : 'none';
        submitBtn.style.display = index === questions.length - 1 ? 'inline-block' : 'none';
      }

      prevBtn.addEventListener('click', function() {
        if (currentQuestionIndex > 0) {
          currentQuestionIndex--;
          showQuestion(currentQuestionIndex);
        }
      });

      nextBtn.addEventListener('click', function() {
        if (currentQuestionIndex < questions.length - 1) {
          currentQuestionIndex++;
          showQuestion(currentQuestionIndex);
        }
      });

      // Show the first question initially
      showQuestion(currentQuestionIndex);
    });
  </script>
</body>

</html>
