<?php
    require_once 'util/SecurityValidator.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">

	<!-- title -->
	<title>Visualiza Parejas Origen</title>

	<!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
	<!-- fontawesome -->
	<link rel="stylesheet" href="assets/css/all.min.css">
	<!-- bootstrap -->
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<!-- owl carousel -->
	<link rel="stylesheet" href="assets/css/owl.carousel.css">
	<!-- magnific popup -->
	<link rel="stylesheet" href="assets/css/magnific-popup.css">
	<!-- animate css -->
	<link rel="stylesheet" href="assets/css/animate.css">
	<!-- mean menu css -->
	<link rel="stylesheet" href="assets/css/meanmenu.min.css">
	<!-- main style -->
	<link rel="stylesheet" href="assets/css/main.css">
	<!-- responsive -->
	<link rel="stylesheet" href="assets/css/responsive.css">

</head>
<body>
	
	<!--PreLoader-->
    <div class="loader">
        <div class="loader-inner">
            <div class="circle"></div>
        </div>
    </div>
    <!--PreLoader Ends-->
	
	<!-- header -->
	<div class="top-header-area" id="sticker">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-sm-12 text-center">
					<div class="main-menu-wrap">
						<!-- logo -->
						<div class="site-logo">
							<a href="index.html">
								<img src="assets/img/logo.png" alt="">
							</a>
						</div>
						<!-- logo -->

						<!-- menu start -->
						<nav class="main-menu" style="text-align:left;">
							<ul>
								<li><a href="visualiza-parejas-origen.php">Visualiza Parejas Origen</a></li>
								<li>&nbsp;</li>
								<li><a href="controller/SecurityController.php">Cierra Sesión</a></li>
								<li>&nbsp;</li>
							</ul>
						</nav>
						<!-- menu end -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end header -->

	<!-- search area -->

	<!-- end search arewa -->
	
	<!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>Visualiza</p>
						<h1>Parejas Origen</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->



	<!-- products -->
	<div id="product-section" class="product-section mt-150 mb-150" ng-app="App" ng-controller="MyCtrl">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="section-title">	
						<h3><span class="orange-text">Parejas</span> Registrados</h3>
						<p>Para ver los descendientes de cada pareja origen, da click en su imagen o nombres.</p>
					</div>
				</div>
			</div>		
		
			<div id="origen-ancestros" class="row product-lists" >
				<div class="col-lg-4 col-md-6 text-center" >
					<div class="single-product-item" >
						<div class="product-image">
                                                    <img src="assets/img/album/no_img.png" alt="">
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end products -->

	<!-- logo carousel -->

	<!-- end logo carousel -->

	<!-- footer -->
	<div class="footer-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6">
					<div class="footer-box about-widget">
						<h2 class="widget-title">Acerca</h2>
						<p>
						Grupo de todos los herederos de los 6 hermanos González González nacidos en Tzurumuato hoy Pastor Ortiz, Michoacán.
						Nuestros ancestros son:
						<br/><br/>
						Teodomira, Eulalia, Josefa, Antonio, Francisca y Maria nacidos entre 1875 y 1890, todos hijos de Francisco González y Francisca González</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="footer-box get-in-touch">
						<h2 class="widget-title">Contactáme</h2>
						<ul>
							<li></li>
							<li>Email: jessaigh@gmail.com</li>
							<li>Whatsapp</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end footer -->
	
	<!-- copyright -->
	<div class="copyright">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-12">
					<p>Copyrights &copy; 2023 - <a href="https://imransdesign.com/">Imran Hossain</a>,  All Rights Reserved.</p>
				</div>
			</div>
		</div>
	</div>
	<!-- end copyright -->
	
	<!-- jquery -->
	<script src="assets/js/jquery-1.11.3.min.js"></script>
	<!-- bootstrap -->
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<!-- count down -->
	<script src="assets/js/jquery.countdown.js"></script>
	<!-- isotope -->
	<script src="assets/js/jquery.isotope-3.0.6.min.js"></script>
	<!-- waypoints -->
	<script src="assets/js/waypoints.js"></script>
	<!-- owl carousel -->
	<script src="assets/js/owl.carousel.min.js"></script>
	<!-- magnific popup -->
	<script src="assets/js/jquery.magnific-popup.min.js"></script>
	<!-- mean menu -->
	<script src="assets/js/jquery.meanmenu.min.js"></script>
	<!-- sticker js -->
	<script src="assets/js/sticker.js"></script>
	<!-- main js -->
	<script src="assets/js/main.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.8.3/angular.js"></script>

	<script>
	var app = angular.module('App', []);

	app.controller('MyCtrl', ['$scope','$http', function($scope,$http) {
		angular.element(document).ready(function () {
			$http({
				method: 'GET', 
				url: 'controller/ArbolGenealogicoController.php',
				params: { },
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				}
			}).then(function (response) {
				var data = response.data;
                                if(data.length > 0){

                                    var index = 0;
                                    document.getElementById("origen-ancestros").innerHTML = "";
                                    while (index < data.length) {
                                        document.getElementById("origen-ancestros").innerHTML +=
                                                "<div class='col-lg-4 col-md-6 text-center'>" +
                                                "<div class='single-product-item'>" +
                                                "<div class='product-image'>" +
                                                    "<a href='administra-descendientes.php?pareja_id=" + data[index].pareja_id + "'>" +
                                                        "<img src='assets/img/album/" + (data[index].pi_img === null ? "no_img.png" : data[index].pi_img) + "' alt=''>" +
                                                        "<h3>" + data[index].nom_eo + " " + data[index].ape_eo +" <br/> & <br/> " + data[index].nom_ea + " " + data[index].ape_ea + "</h3>" +
                                                    "</a>" +
                                                "</div>" +
                                                "</div>" +
                                                "</div>";
                                        index++;
                                    }
                                    
                                    var indexFactor = index / 3 ;
                                    indexFactor = (indexFactor * 450);
                                    document.getElementById("product-section").style.marginBottom = indexFactor.toString() + "px";
                                }
			});	
		});
	}]);

	</script>

</body>
</html>