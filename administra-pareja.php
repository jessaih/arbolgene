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
	<title>Ver Árbol Genealógico</title>

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
	<style>
		.formlabel {
			font-weight: bold;
			text-align: right;
		} 
		.required{
			color: red;
		}
		td.product-image-edit img {
			max-width: 175px;
			-webkit-box-shadow: none;
			box-shadow: none;
			margin-bottom: 0;
		}		
	</style>

</head>
<body ng-app="myApp" ng-controller="MyCtrl">
	
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

	<!-- end search area -->
	
	<!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>Administra</p>
						<h1>Pareja</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->
	<br/><br/>
        <div class="container">
                <div class="row">
                        <div class="col-lg-8 offset-lg-2 text-center">
                                <div class="section-title" ng-if="addPareja">
                                        <h3><span class="orange-text">Añade</span> Pareja</h3>
                                        <p>Completa el o los formularios necesarios para formar una pareja</p>
                                </div>
                                <div class="section-title" ng-if="editPareja">
                                        <h3><span class="orange-text">Actualiza</span> Pareja</h3>
                                        <p>Modifica la información que desees de la pareja</p>
                                </div>
                        </div>
                </div>
        </div>
        
	<!-- products -->
	<div class="abt-section mb-150">
		<div class="container">
			<div class="row">
				<!-- *********************-->
				<!-- First column of data-->
				<!-- *********************-->			
				<div class="col-lg-6 col-md-12">
					<form name="leftParejaForm" id="leftParejaForm" novalidate>
						<table class="cart-table" style="border: 1px solid black;" cellpadding="12" >				
							<tr >
								<td colspan="2" class="product-image-edit" style="text-align: center;">
									<img ng-src="{{leftImage}}" alt=""/>
								</td>
							</tr>
							<tr>
								<td class = "formlabel"><label for="newParejaImg">Imagen</label></td>
								<td>
									<input id="LFnewParejaImg" name="LFnewParejaImg" ng-model="LFnewParejaImg" type = "file" ng-disabled="leftDisabled" />
								</td>
							</tr>
							<tr>
								<td class = "formlabel"><label for="newParejaNombre">Nombre</label> <span class="required"> *</span></td>
								<td> 
									<input id="LFnewParejaNombre" name="LFnewParejaNombre" ng-model="LFnewParejaNombre" type="text" required ng-disabled="leftDisabled" /> 
									<label class="required" ng-show="leftParejaForm.LFnewParejaNombre.$dirty && leftParejaForm.LFnewParejaNombre.$error.required">* Campo Requerido</label>
								</td>
							</tr>								
							<tr>
								<td class = "formlabel"><label for="LFnewParejaApellido">Apellidos</label><span class="required"> *</span></td>
								<td> 
									<input id="LFnewParejaApellido" name="LFnewParejaApellido" ng-model="LFnewParejaApellido" type="text" required ng-disabled="leftDisabled"/> 
									<label class="required" ng-show="leftParejaForm.LFnewParejaApellido.$dirty && leftParejaForm.LFnewParejaApellido.$error.required">* Campo Requerido</label>
								</td>
							</tr>
							<tr>
								<td class = "formlabel"><label for="LFnewParejaNotas">Notas</label></td>
								<td> 
									<textarea id="LFnewParejaNotas" name="LFnewParejaNotas" ng-model="LFnewParejaNotas" rows="6" cols="40" style="resize: none;" ng-disabled="leftDisabled"> 
									</textarea>
								</td>
							</tr>
							<tr>
								<td > </td>
								<td class = "formlabel">
									<input type="reset" ng-disabled="leftDisabled"/> 
								</td>
							</tr>
						</table>
					</form>
				</div>
				<!-- *********************-->
				<!-- Second column of data-->
				<!-- *********************-->
				<div class="col-lg-6 col-md-12">
					<form name="rightParejaForm" id="rightParejaForm" novalidate>
						<table class="cart-table" style="border: 1px solid black;" cellpadding="12" >				
							<tr>
								<td colspan="2" class="product-image-edit" style="text-align: center;">
									<img ng-src="{{rightImage}}" alt=""/>
								</td>
							</tr>
							<tr>
								<td class = "formlabel"><label for="RFnewParejaImg">Imagen</label></td>
								<td>
									<input id="RFnewParejaImg" name="RFnewParejaImg" ng-model="RFnewParejaImg" type = "file" />
								</td>
							</tr>
							<tr>
								<td class = "formlabel"><label for="RFnewParejaNombre">Nombre</label> <span class="required"> *</span></td>
								<td> 
									<input id="RFnewParejaNombre" name="RFnewParejaNombre" ng-model="RFnewParejaNombre" type="text" required /> 
									<label class="required" ng-show="rightParejaForm.RFnewParejaNombre.$dirty && rightParejaForm.RFnewParejaNombre.$error.required">* Campo Requerido</label>
								</td>
							</tr>								
							<tr>
								<td class = "formlabel"><label for="RFnewParejaApellido">Apellidos</label><span class="required"> *</span></td>
								<td> 
									<input id="RFnewParejaApellido" name="RFnewParejaApellido" ng-model="RFnewParejaApellido" type="text" required/> 
									<label class="required" ng-show="rightParejaForm.RFnewParejaApellido.$dirty && rightParejaForm.RFnewParejaApellido.$error.required">* Campo Requerido</label>
								</td>
							</tr>								
							<tr>
								<td class = "formlabel"><label for="RFnewParejaNotas">Notas</label></td>
								<td> 
									<textarea id="RFnewParejaNotas" name="RFnewParejaNotas" ng-model="RFnewParejaNotas" rows="6" cols="40" style="resize: none;"> 
									</textarea>
								</td>
							</tr>								
							<tr>
								<td > </td>
								<td class = "formlabel"> 
									<input type="reset"/> 
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
                        <br/><br/>
                        <table class='cart-table' style="border: 1px solid black;width: 50%; margin-left: auto; margin-right: auto;" cellpadding="12" >
                            <tr>
                                    <td colspan="2" style="text-align: center; font-weight: bold;">Cargar imagen principal de la pareja (reemplazará la existente)</td>
                            </tr>
                            <tr >
                                    <td colspan="2" class="product-image-edit" style="text-align: center;">
                                        <img ng-src="{{centerParejaImage}}" alt=""/>
                                    </td>
                            </tr>
                            <tr>
                                    <td class = "formlabel"><label for="CFnewParejaImg">Imagen</label></td>
                                    <td align='center'>
                                            <input id="CFnewParejaImg" name="CFnewParejaImg" ng-model="CFnewParejaImg" type = "file" />
                                    </td>
                            </tr>
                            <tr>
                                    <td class = "formlabel"><label for="CFimgParejaNotas">Notas</label></td>
                                    <td align="center"> 
                                            <textarea id="CFimgParejaNotas" name="CFimgParejaNotas" ng-model="CFimgParejaNotas" rows="6" cols="40" style="resize: none;"> 
                                            </textarea>
                                    </td>
                            </tr>                                                               
                            <tr> 
                                    <td colspan="2" align='center'>
                                            <br/><br/>
                                            <a ng-click='modifyParejaCompleta()' class='cart-btn' ng-disabled="rightParejaForm.$invalid && lefttParejaForm.$invalid" ng-if="editPareja">
                                                    <i class='fas fa-pen' title='Editar'></i> Actualizar info pareja
                                            </a> 
                                            <a ng-click='addParejaADescendiente()' class='cart-btn' ng-disabled="rightParejaForm.$invalid" ng-if="addPareja">
                                                    <i class='fas fa-pen' title='Editar'></i> Crear pareja
                                            </a> 
                                    </td>  
                            </tr>
                        </table>
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
	var app = angular.module('myApp', []);

	app.controller('MyCtrl', ['$scope','$http', function($scope,$http) {
		const params = new URL(location.href).searchParams;
		const familiar_id = params.get('familiar_id');
		const pareja_id = params.get('pareja_id');
		const server_image_path = "assets/img/album/";
		const no_img = server_image_path + "no_img.png";
		
		$scope.leftImage = no_img;
		$scope.rightImage = no_img;
		$scope.centerParejaImage = no_img;
                $scope.addPareja = false;
                $scope.editPareja = false;
				
		angular.element(document).ready(function () {
			if(familiar_id !== null){
                            $scope.addPareja = true;
				$http({
					method: 'GET', 
					url: 'controller/FamiliarController.php',
					params: { 
						familiar_id : familiar_id
					},
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded'
					}
				}).then(function (response) {
                                        var familiar = response.data.familiar[0];
                                        var familiar_info = response.data.familiar_info;

                                        $scope.LFnewParejaNombre = familiar.nombres;
                                        $scope.LFnewParejaApellido = familiar.apellidos; 
                                        $scope.LFnewParejaNotas = familiar.notas;
                                        
                                        
                                        if(familiar_info !== null && familiar_info.length > 0){
                                            $scope.leftImage = server_image_path + familiar_info[0].ruta_img;
                                        }
					$scope.leftDisabled = true;
//					console.log(response.data);
				});	
			} else if (pareja_id !== null){
                            $scope.editPareja = true;
                             $http({
                                method: 'GET',
                                url: 'controller/ParejaController.php',
                                params: {
                                    pareja_id: pareja_id
                                },
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                }
                            }).then(function (response) {
                                if(response.data.status ==="OK"){
                                    var pareja = response.data.pareja[0];
                                    var pareja_info = response.data.pareja_info;
                                    var familiar_eo_info = response.data.familiar_eo_info;
                                    var familiar_ea_info = response.data.familiar_ea_info;

                                    $scope.LFID = pareja.eo_id;
                                    $scope.LFnewParejaNombre = pareja.nom_eo;
                                    $scope.LFnewParejaApellido = pareja.ape_eo;
                                    $scope.LFnewParejaNotas = pareja.notas_eo;

                                    $scope.RFID = pareja.ea_id;
                                    $scope.RFnewParejaNombre = pareja.nom_ea;
                                    $scope.RFnewParejaApellido = pareja.ape_ea;
                                    $scope.RFnewParejaNotas = pareja.notas_ea;
                                    
                                    if(familiar_eo_info !== null && familiar_eo_info.length > 0){
                                        $scope.leftImage = server_image_path + familiar_eo_info[0].ruta_img;
                                    }
                                    if(familiar_ea_info !== null && familiar_ea_info.length > 0){
                                        $scope.rightImage = server_image_path + familiar_ea_info[0].ruta_img;
                                    }
                                    if(pareja_info !== null && pareja_info.length > 0){
                                        $scope.centerParejaImage = server_image_path + pareja_info[0].ruta_img;
                                        $scope.CFimgParejaNotas = pareja_info[0].notas;
                                    }
                                }
                            });
			}
		});
                
                
                $scope.addParejaADescendiente = function(){
			let fdAdd = new FormData();
			
			let files = document.getElementById('RFnewParejaImg').files[0];
			let nombre = document.getElementById('RFnewParejaNombre').value;
			let apellido = document.getElementById('RFnewParejaApellido').value;
			let notas = document.getElementById('RFnewParejaNotas').value;
			
                        //Se obtiene imagen y notas del centro
                        let fileParejaCF = document.getElementById('CFnewParejaImg').files[0];
                        let notasCF = document.getElementById('CFimgParejaNotas').value;
                        
			fdAdd.append('file',files);
			fdAdd.append('nombres', nombre);
			fdAdd.append('apellidos', apellido);
			fdAdd.append('notas', notas);
			fdAdd.append('familiar_id', familiar_id);

                        fdAdd.append('file_pareja_img',fileParejaCF);
                        fdAdd.append('notas_pareja_img',notasCF);

			$http({
                            method: 'POST',
                            url: 'controller/ParejaController.php',
                            data: fdAdd,
                            headers: {'Content-Type': undefined, 'Process-Data': false}
			}).then(
				function(response){
                                    console.log(response.data);
                                    if(response.statusText ==="OK" ){
                                        alert("Pareja añadida exitosamente");
                                        var query = new URLSearchParams();
                                        query.append("pareja_id", response.data.pareja_id);
                                        location.href = "administra-descendientes.php?" + query.toString();
                                    } else{
                                        alert("ADDPAREJASOFT1 - Hubo un error, contacte al administrador");
					console.log(JSON.stringify(response));
                                    }
                                        
				}, function(response){
					alert("ADDPAREJAHARD1 - Hubo un error, contacte al administrador");
					console.log(JSON.stringify(response));
				}
			);
		};
                
                $scope.modifyParejaCompleta = function(){
			let fdAdd = new FormData();
			
                        //Se obtienen los valores del formulario izquierdo
			let fileLF = document.getElementById('LFnewParejaImg').files[0];
			let familiar_id_LF = $scope.LFID;
			let nombreLF = document.getElementById('LFnewParejaNombre').value;
			let apellidoLF = document.getElementById('LFnewParejaApellido').value;
			let notasLF = document.getElementById('LFnewParejaNotas').value;
                        
                        //Se obtienen los valores del formulario derecho
                        let fileRF = document.getElementById('RFnewParejaImg').files[0];
			let familiar_id_RF = $scope.RFID;
                        let nombreRF = document.getElementById('RFnewParejaNombre').value;
			let apellidoRF = document.getElementById('RFnewParejaApellido').value;
			let notasRF = document.getElementById('RFnewParejaNotas').value;
                        
                        //Se obtiene imagen y notas del centro
                        let fileParejaCF = document.getElementById('CFnewParejaImg').files[0];
                        let notasCF = document.getElementById('CFimgParejaNotas').value;
			
			fdAdd.append('file_eo',fileLF);
			fdAdd.append('esposo_id', familiar_id_LF);
			fdAdd.append('nombres_eo', nombreLF);
			fdAdd.append('apellidos_eo', apellidoLF);
			fdAdd.append('notas_eo', notasLF);
			
			fdAdd.append('file_ea',fileRF);
			fdAdd.append('esposa_id', familiar_id_RF);                        
			fdAdd.append('nombres_ea', nombreRF);
			fdAdd.append('apellidos_ea', apellidoRF);
			fdAdd.append('notas_ea', notasRF);
                        
                        fdAdd.append('file_pareja_img',fileParejaCF);
                        fdAdd.append('notas_pareja_img',notasCF);
                        fdAdd.append('pareja_id', pareja_id);
                        
			$http({
                            method: 'POST',
                            url: 'controller/ParejaController.php',
                            data: fdAdd,
                            headers: {'Content-Type': undefined, 'Process-Data': false}
			}).then(
				function(response){
                                    console.log(response);
                                    if(response.statusText === "OK" &&
                                        confirm("Pareja actualizada exitosamente, ¿desea volver a la administración de descendientes?") === true){
                                    
                                        var query = new URLSearchParams();
                                        query.append("pareja_id", pareja_id);
                                        location.href = "administra-descendientes.php?" + query.toString();
                                    } else if(response.statusText ==="Error" ){
                                        alert("ADDPAREJASOFT1 - Hubo un error, contacte al administrador");
					console.log(JSON.stringify(response));
                                    }
                                        
				}, function(response){
					alert("ADDPAREJAHARD1 - Hubo un error, contacte al administrador");
					console.log(JSON.stringify(response));
				}
			);
		};
	}]);

	</script>

</body>
</html>