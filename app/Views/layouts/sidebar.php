<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon">
      <img src="../assets/img/logo/logo2.png">
    </div>
    <div class="sidebar-brand-text mx-3">Sistem Pakar Terhidrasi</div>
  </a>
  <hr class="sidebar-divider my-0">
  <li class="nav-item">
    <a class="nav-link" href="/">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Home</span></a>
  </li>
  <?php
  if (isset($is_admin) && $is_admin == 1) { ?>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
      Features
    </div>
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTable" aria-expanded="true" aria-controls="collapseTable">
        <i class="fas fa-fw fa-table"></i>
        <span>Admin Kuisioner</span>
      </a>
      <div id="collapseTable" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Kuisioner</h6>
          <a class="collapse-item" href="/admin/create-quiz">Membuat Kuisioner</a>
          <a class="collapse-item" href="/admin/list-quiz">List Kuisioner</a>
          <a href="/admin/create-formula" class="collapse-item">Create Formula</a>
          <a href="/admin/list-formula" class="collapse-item">List Formula</a>
          <a href="/admin/list-rating" class="collapse-item">List Rating User</a>
        </div>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/account/list">
        <i class="fas fa-fw fa-person-booth"></i>
        <span>View Account</span>
      </a>
    </li>
  <?php } ?>
  <hr class="sidebar-divider">
  <div class="version" id="version-ruangadmin"></div>
</ul>
