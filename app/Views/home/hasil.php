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
            <h1 class="h3 mb-0 text-gray-800">Hasil Kuisioner</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Hasil</li>
            </ol>
          </div>

          <h1>Hasil Diagnosa Dehidrasi</h1>
          <div class="row mb-3">
            <table border="1" cellpadding="10" cellspacing="0" width="100%">
              <tr>
                <td><strong>Judul</strong></td>
                <?php
                echo "<td> " . $data['name'] . '</td>';
                ?>
              </tr>
              <tr>
                <td><strong>Index Score</strong></td>
                <td><?= $index_score ?></td>
              </tr>
              <tr>
                <td><strong>Rentang nilai</strong></td>
                <td><?= $data['name'] .  ' (' . $data['range_min'] . '-' . $data['range_max'] . ')' ?></td>
              </tr>
              <?php
              if (isset($data['tingkat']) && !empty(trim($data['tingkat']))) {
              ?>
                <tr>
                  <td><strong>Tingkat</strong></td>
                  <td><?= $data['tingkat'] ?></td>
                </tr>
              <?php } ?>
              <?php
              if (isset($data['dampak']) && !empty(trim($data['dampak']))) {
              ?>
                <tr>
                  <td><strong>Dampak</strong></td>
                  <td><?= $data['dampak'] ?></td>
                </tr>
              <?php } ?>
              <?php
              if (isset($data['pelaksanaan']) && !empty(trim($data['pelaksanaan']))) {
              ?>
                <tr>
                  <td><strong>Pelaksanaan</strong></td>
                  <td><?= $data['pelaksanaan'] ?></td>
                </tr>
              <?php } ?>
              <?php
              if (isset($data['pencegahan']) && !empty(trim($data['pencegahan']))) {
              ?>
                <tr>
                  <td><strong>Pencegahan</strong></td>
                  <td><?= var_dump(trim($data['pencegahan'])) ?> </td>
                </tr>
              <?php } ?>
              <?php
              if (isset($data['description']) && !empty(trim($data['description']))) {
              ?>
                <tr>
                  <td><strong>Informasi Tambahan</strong></td>
                  <td><?= var_dump(trim($data['description'])) ?> </td>
                </tr>
              <?php } ?>
            </table>

            <a href="/" <?= (isset($is_rating) && !$is_rating) ? 'id="backButton"' : '' ?> class="btn btn-primary btn-block ">Kembali</a>
          </div>

        </div>
      </div>
    </div>
  </div>

  <?php
  if (isset($is_rating) && !$is_rating) { ?>
    <!-- Modal Review -->
    <div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="reviewModalLabel">Review</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="POST" action="/post/rating">
            <div class="modal-body">

              <div class="form-group">
                <label for="rating">Rating:</label>
                <div id="rating">
                  <span class="fa fa-star" data-value="1">
                  </span>
                  <span class="fa fa-star" data-value="2"></span>
                  <span class="fa fa-star" data-value="3"></span>
                  <span class="fa fa-star" data-value="4"></span>
                  <span class="fa fa-star" data-value="5"></span>
                  <input type="hidden" name="rating" id="ratingInput">
                </div>
              </div>
              <div class="form-group">
                <label for="kritikSaran">Kritik dan Saran:</label>
                <textarea class="form-control" id="kritikSaran" rows="3" name="comment"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  <?php }
  ?>




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

  <script>
    document.getElementById('backButton').addEventListener('click', function(event) {
      event.preventDefault();
      $('#reviewModal').modal('show');
    });

    $('#rating .fa').on('click', function() {
      var rating = $(this).data('value');
      $('#rating .fa').removeClass('checked');
      $('#rating .fa').each(function(index) {
        if (index < rating) {
          $(this).addClass('checked');
        }
      });
      $("#ratingInput").val(rating);
    });

    $('#submitReview').on('click', function() {
      var rating = $('#rating .fa.checked').length;
      var kritikSaran = $('#kritikSaran').val();
      console.log("Rating: " + rating);
      console.log("Kritik dan Saran: " + kritikSaran);
      $('#reviewModal').modal('hide');
      // Tambahkan logika untuk menyimpan review di sini, jika diperlukan.
    });
  </script>

  <style>
    #rating .fa {
      font-size: 1.5em;
      cursor: pointer;
    }

    #rating .fa.checked {
      color: gold;
    }
  </style>

</body>
</body>

</html>
