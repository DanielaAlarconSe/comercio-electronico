<!DOCTYPE html>
<html lang="en">

<head>
   
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
  
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="viewport" content="initial-scale=1, maximum-scale=1">

   <title>Comercio Electrónico PHP</title>
   <meta name="keywords" content="">
   <meta name="description" content="">
   <meta name="author" content="">
  
   <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/principal/css/bootstrap.min.css">
  
   <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/principal/css/style.css">
 
   <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/principal/css/responsive.css">
  
   <link rel="icon" href="<?php echo BASE_URL; ?>assets/principal/images/fevicon.png" type="image/gif" />
  
   <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/principal/css/jquery.mCustomScrollbar.min.css">
   
   <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
 
   <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
 
   <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 
   <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Poppins:400,700&display=swap&subset=latin-ext" rel="stylesheet">
   <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/principal/css/owl.carousel.min.css">
   <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/principal/css/owl.theme.default.min.css">

   <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/principal/slick/slick.css">
   <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/principal/slick/slick-theme.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
   <script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID; ?>&currency=<?php echo MONEDA; ?>"></script>
   <style>
      .table>tbody>tr>td {
         vertical-align: middle;
      }
   </style>
</head>

<body>
 
   <div class="banner_bg_main">
      <div class="logo_section">
         <div class="container">
            <div class="row">
               <div class="col-sm-12">
                  <div class="logo"><a href="<?php echo BASE_URL; ?>"><img src="<?php echo BASE_URL; ?>assets/images/logoL.png" width="80"></a></div>
               </div>
            </div>
         </div>
      </div>
 
      <div class="header_section">
         <div class="container">
            <div class="containt_main">
               <div id="mySidenav" class="sidenav">
                  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                  <?php foreach ($data['categorias'] as $categoria) { ?>
                     <a href="#categoria_<?php echo $categoria['id']; ?>"><?php echo $categoria['categoria']; ?></a>
                  <?php } ?>
               </div>
               <span class="toggle_icon" onclick="openNav()"><img src="<?php echo BASE_URL; ?>assets/principal/images/toggle-icon.png"></span>
               <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categorias
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                     <?php foreach ($data['categorias'] as $categoria) { ?>
                        <a class="dropdown-item" href="#categoria_<?php echo $categoria['id']; ?>"><?php echo $categoria['categoria']; ?></a>
                     <?php } ?>
                  </div>
               </div>
               <div class="main">
                 
                  <div class="input-group">
                     <input type="text" class="form-control" placeholder="Buscar Producto" id="search">
                     <div class="input-group-append">
                        <button class="btn btn-secondary" type="button" style="background-color: black; border-color: #615EFC ">
                           <i class="fa fa-search"></i>
                        </button>
                     </div>
                  </div>
                  <div class="position-absolute row" id="resultBusqueda" style="z-index: 99999;"></div>
               </div>
               <div class="header_box">
                  <div class="login_menu">
                     <ul>
                        <li><a href="#" id="verCarrito">
                              <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                              <span class="padding_10" id="btnCantidadCarrito">Cart</span></a>
                        </li>
                        <?php if (empty($_SESSION['nombreCliente'])) {
                           echo '<li><a href="#" data-toggle="modal" data-target="#modalLogin">
                                 <i class="fa fa-user" aria-hidden="true"></i>
                                 <span class="padding_10">Iniciar Sesión</span></a>
                           </li>';
                        } else {
                           echo '<li><a href="' . BASE_URL . 'clientes">
                                 <i class="fa fa-user" aria-hidden="true"></i>
                                 <span class="padding_10 text-capitalize">' . $_SESSION['nombreCliente'] . '</span></a>
                           </li>';
                        }
                        ?>

                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>