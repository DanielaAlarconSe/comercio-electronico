<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo BASE_URL; ?>assets/admin/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>assets/admin/img/favicon.png">
  <title>
    <?php echo $data['title']; ?>
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="<?php echo BASE_URL; ?>assets/admin/css/nucleo-icons.css" rel="stylesheet" />
  <link href="<?php echo BASE_URL; ?>assets/admin/css/nucleo-svg.css" rel="stylesheet" />
  <link id="pagestyle" href="<?php echo BASE_URL; ?>assets/admin/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
</head>

<body class="bg-gray-200">
  <main class="main-content  mt-0">
  <div class="page-header align-items-start min-vh-100" style="background-image: url('assets/images/fondoa.jpg');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-dark shadow-primary border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Login administrador</h4>
                </div>
              </div>
              <div class="card-body">
                <form role="form" class="text-start" id="formulario" autocomplete="off">
                  <div class="input-group input-group-outline my-3">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" id="email" name="email" class="form-control">
                  </div>
                  <div class="input-group input-group-outline mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" id="clave" name="clave" class="form-control">
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-dark w-100 my-4 mb-2 text-white">Ingresar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer position-absolute bottom-2 py-2 w-100">
        <div class="container">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-12 col-md-6 my-auto ml-10">
              <div class="copyright text-center text-sm text-white text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script>
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>
  <!--   Core JS Files   -->
  <script src="<?php echo BASE_URL; ?>assets/admin/js/core/popper.min.js"></script>
  <script src="<?php echo BASE_URL; ?>assets/admin/js/core/bootstrap.min.js"></script>
  <script src="<?php echo BASE_URL; ?>assets/admin/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="<?php echo BASE_URL; ?>assets/admin/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?php echo BASE_URL; ?>assets/admin/js/material-dashboard.min.js?v=3.1.0"></script>
  <script>
        const base_url = '<?php echo BASE_URL; ?>';
    </script>
    <script src="<?php echo BASE_URL; ?>assets/js/sweetalert2.all.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/modulos/login.js"></script>
</body>

</html>