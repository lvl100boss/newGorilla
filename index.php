<?php require_once('./config.php'); ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<style>
  body {
    background-color: #121212;
    color: #e0e0e0;
    font-family: 'Arial', sans-serif;
  }

  #header {
    height: 70vh;
    width: calc(100%);
    position: relative;
    top: -1em;
  }

  #header:before {
    content: "";
    position: absolute;
    height: calc(100%);
    width: calc(100%);
    background-image: url(<?= validate_image($_settings->info("cover")) ?>);
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    filter: brightness(0.5);
  }

  #header>div {
    position: absolute;
    height: calc(100%);
    width: calc(100%);
    z-index: 2;
  }

  #top-Nav a.nav-link {
    color: #e0e0e0;
  }

  #top-Nav a.nav-link.active {
    color: #14453d;
    font-weight: 900;
    position: relative;
  }

  #top-Nav a.nav-link.active:before {
    content: "";
    position: absolute;
    border-bottom: 2px solid #14453d;
    width: 33.33%;
    left: 33.33%;
    bottom: 0;
  }

  @media (max-width:760px) {
    #top-Nav a.nav-link.active {
      background: #14453d;
      color: #fff;
    }

    #top-Nav a.nav-link.active:before {
      content: "";
      position: absolute;
      border-bottom: 2px solid #14453d;
      width: 100%;
      left: 0;
      bottom: 0;
    }

    h1.w-100.text-center.site-title.px-5 {
      font-size: 2.5em !important;
    }
  }

  .btn-primary {
    background-color: #14453d;
    border-color: #14453d;
  }

  .btn-primary:hover {
    background-color: #0f3a32;
    border-color: #0f3a32;
  }

  .modal-content {
    background-color: #1e1e1e;
    color: #e0e0e0;
  }

  .modal-header,
  .modal-footer {
    border-color: #333;
  }

  .modal-header .close {
    color: #e0e0e0;
  }

  .modal-header .close:hover {
    color: #fff;
  }

  .site-title {
    color: #e0e0e0;
  }

  .content-wrapper {
    background-color: #1e1e1e;
  }

  a {
    color: #14453d;
  }

  a:hover {
    color: #0f3a32;
  }
</style>
<?php require_once('inc/header.php') ?>

<body class="layout-top-nav layout-fixed layout-navbar-fixed font-mono" style="height: auto;">
  <div class="wrapper">
    <?php $page = isset($_GET['page']) ? $_GET['page'] : 'home';  ?>
    <?php require_once('inc/topBarNav.php') ?>
    <?php if ($_settings->chk_flashdata('success')): ?>
      <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
      </script>
    <?php endif; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper pt-5 bg-black" style="">
      <?php if ($page == "home" || $page == "about"): ?>
        <div id="header" class="shadow mb-4">
          <div class="d-flex justify-content-center h-100 w-100 align-items-center flex-column px-3">
            <h1 class="w-100 text-center site-title px-5 font-italic">CLOTHING FOR THE MODERN FASHIONISTA</h1>
            <!-- <h3 class="w-100 text-center px-5 site-subtitle"><?php echo $_settings->info('name') ?></h3> -->
          </div>
        </div>
      <?php endif; ?>
      <!-- Main content -->
      <section class="content bg-black">
        <div class="container">
          <?php
          if (!file_exists($page . ".php") && !is_dir($page)) {
            include '404.html';
          } else {
            if (is_dir($page))
              include $page . '/index.php';
            else
              include $page . '.php';
          }
          ?>
        </div>
      </section>
      <!-- /.content -->
      <div class="modal fade rounded-0" id="uni_modal" role='dialog'>
        <div class="modal-dialog modal-md modal-dialog-centered rounded-0" role="document">
          <div class="modal-content rounded-0">
            <div class="modal-header rounded-0">
              <h5 class="modal-title"></h5>
            </div>
            <div class="modal-body rounded-0">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade rounded-0" id="confirm_modal" role='dialog'>
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header rounded-0">
              <h5 class="modal-title">Confirmation</h5>
            </div>
            <div class="modal-body rounded-0">
              <div id="delete_content"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade rounded-0" id="uni_modal_right" role='dialog'>
        <div class="modal-dialog modal-full-height  modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header rounded-0">
              <h5 class="modal-title"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="fa fa-arrow-right"></span>
              </button>
            </div>
            <div class="modal-body rounded-0">
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="viewer_modal" role='dialog'>
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
            <img src="" alt="">
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-wrapper -->
    <?php require_once('inc/footer.php') ?>
</body>

</html>