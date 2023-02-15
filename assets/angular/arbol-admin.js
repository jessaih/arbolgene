
	var app = angular.module('myApp', []);

	app.controller('MyCtrl', ['$scope','$http', '$compile', function($scope,$http, $compile) {

		const params = new URL(location.href).searchParams;
		const pareja_id = params.get('pareja_id');
		$scope.addNewDescendienteCheck = true;
		
		/*$("#myModal").on("hidden.bs.modal", function () {
			
		});*/
		
		angular.element(document).ready(function () {

			$http({
				method: 'GET', 
				url: 'controller/DescendienteController.php',
				params: {
					pareja_id : pareja_id,
					full_content: true
				},
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				}
			}).then(function (response) {
				$scope.descendientes = response.data.descendientes;
				$scope.pareja = response.data.pareja;
				$scope.pareja_info = response.data.pareja_info;
				
				if($scope.pareja_info.length !== null && $scope.pareja_info.length > 0){
					document.getElementById("ancestro_img_principal").setAttribute("src", "assets/img/album/" + $scope.pareja_info[0].ruta_img);
					
					document.getElementById("ancestro_nota_principal").innerText = $scope.pareja_info[0].notas;
					if($scope.pareja_info.length > 1){
						//Estableciendo el indice en 1 para que continue con la secuencia de imagenes
						var index = 1;
						document.getElementById("ancestro_galeria").innerHTML = "";
						while(index < $scope.pareja_info.length){
							document.getElementById("ancestro_galeria").innerHTML += 
								"<div class='col-lg-4 col-md-6 text-center strawberry'>" + 
									"<div class='single-product-item'>" + 
										"<div class='product-image'>" +
											"<img src='assets/img/album/" + $scope.pareja_info[index].ruta_img + "' alt=''>" +
										"</div>" + 
										"<h3>"+ $scope.pareja_info[index].notas +"</h3>" +
									"</div>" + 
								"</div>"
							;
							index++;
						}
						document.getElementById("ancestro_galeria").innerHTML += "<br/><br/>";
					}
				}
				
				if($scope.pareja != null){
					document.getElementById("ancestro_nombres").innerHTML = "<h3 style='text-align: center;'>" + $scope.pareja[0].nom_eo + " " + $scope.pareja[0].ape_eo + "<br/> y <br/>" + $scope.pareja[0].nom_ea + " " + $scope.pareja[0].ape_ea +"</h3>"
						+ "<br/> <p> <b> Notas sobre " + $scope.pareja[0].nom_eo + ":</b> " + ($scope.pareja[0].notas_eo == null ? "-" : $scope.pareja[0].notas_eo) + "</p>"
						+ "<br/> <p> <b> Notas sobre " + $scope.pareja[0].nom_ea + ":</b> " + ($scope.pareja[0].notas_ea == null ? "-" : $scope.pareja[0].notas_ea) + "</p>";
				}

			});	
		});

		$scope.add = function(){
			let fdAdd = new FormData();
			
			let files = document.getElementById('newDescendienteImg').files[0];
			let nombre = document.getElementById('newDescendienteNombre').value;
			let apellido = document.getElementById('newDescendienteApellido').value;
			let numero = document.getElementById('newDescendienteNumero').value;
			let notas = document.getElementById('newDescendienteNotas').value;
			
			fdAdd.append('file',files);
			fdAdd.append('nombres', nombre);
			fdAdd.append('apellidos', apellido);
			fdAdd.append('numero', numero);
			fdAdd.append('notas', notas);
			fdAdd.append('pareja_id', pareja_id);
			fdAdd.append('http_put', false);

			$http({
			   method: 'POST',
			   url: 'controller/DescendienteController.php',
			   data: fdAdd,
			   headers: {'Content-Type': undefined}
			}).then(
				function(response){
					$http({
						method: 'GET', 
						url: 'controller/DescendienteController.php',
						params: {
							pareja_id : pareja_id,
							full_content: false
						},
						headers: {
							'Content-Type': 'application/x-www-form-urlencoded'
						}
					}).then(
						function(response){
							$scope.descendientes = response.data.descendientes;
							$scope.resetAddModifyForm();
							$('#modal-dismiss').click();
						}, function(response){
							alert("ADDHARD1 - Hubo un error, contacte al administrador");
							console.log(JSON.stringify(response));
						}
					);					
				}, function(response){
					alert("ADDHARD2 - Hubo un error, contacte al administrador");
					console.log(JSON.stringify(response));
				}
			);
		}		
		
		$scope.modify = function(){
			let fdModify = new FormData();
			
			let files = document.getElementById('newDescendienteImg').files[0];
			let nombre = document.getElementById('newDescendienteNombre').value;
			let apellido = document.getElementById('newDescendienteApellido').value;
			let numero = document.getElementById('newDescendienteNumero').value;
			let notas = document.getElementById('newDescendienteNotas').value;
			let descendiente_id = $scope.descendienteModifyId;
			
			fdModify.append('file',files);
			fdModify.append('nombres', nombre);
			fdModify.append('apellidos', apellido);
			fdModify.append('numero', numero);
			fdModify.append('notas', notas);
			fdModify.append('descendiente_id', descendiente_id);
			fdModify.append('http_put', true);
			
			$http({
				method: 'POST', 
				url: 'controller/DescendienteController.php',
				data: fdModify,
				headers: {'Content-Type': undefined}
			}).then(
				function(response){
					$http({
						method: 'GET', 
						url: 'controller/DescendienteController.php',
						params: {
							pareja_id : pareja_id,
							full_content: false
						},
						headers: {
							'Content-Type': 'application/x-www-form-urlencoded'
						}
					}).then(
						function(response){
							$scope.descendientes = response.data.descendientes;
							$scope.resetAddModifyForm();
							$('#modal-dismiss').click();
						}, function(response){
							alert("MODHARD1 - Hubo un error, contacte al administrador");
							console.log(JSON.stringify(response));
						}
					);
				}, function(response){
					alert("MODHARD2 - Hubo un error, contacte al administrador");
					console.log(JSON.stringify(response));
				}
			);
		}
		
		$scope.delete = function(descendiente_id, nombres, apellidos){
						
			if (confirm("¿Desea eliminar descendiente " + nombres + " " + apellidos +" ?") == true) {
				$http({
					method: 'DELETE', 
					url: 'controller/DescendienteController.php',
					params: {
						descendiente_id : descendiente_id
					},
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded'
					}
				}).then(
					function(response){
						let status = response.data.status;
						
						if(status == 'OK'){
							$http({
								method: 'GET', 
								url: 'controller/DescendienteController.php',
								params: {
									pareja_id : pareja_id,
									full_content: false
								},
								headers: {
									'Content-Type': 'application/x-www-form-urlencoded'
								}
							}).then(
								function(response){
									$scope.descendientes = response.data.descendientes;
								}, function(response){
									alert("DELHARD1 - Hubo un error, contacte al administrador");
									console.log(JSON.stringify(response));
								}
							);
						} else{
							alert("DELSOFT - Hubo un error, contacte al administrador");
							console.log(JSON.stringify(response) );
						}
								
					}, function(response){
						alert("DELHARD2 - Hubo un error, contacte al administrador");
						console.log(JSON.stringify(response));
					}
				);
			}
		}		

		$scope.addNewDescendiente = function(){
			$scope.resetAddModifyForm();
			let ultimoHermanoTd = document.querySelectorAll("td.product-number");
			let ultimoHermanoText = ultimoHermanoTd[ultimoHermanoTd.length - 1].innerText;
			$scope.newDescendienteNumero = parseInt(ultimoHermanoText) + 1;
			document.getElementById("modal-title").innerText = "Agregar Nuevo Descendiente";
			$scope.addNewDescendienteCheck = true;
		}	
		
		$scope.modifyNewDescendiente = function(index, descendienteModifyId){
			$scope.resetAddModifyForm();
			document.getElementById("modal-title").innerText = "Modificar Descendiente";
			$scope.addNewDescendienteCheck = false;
			$scope.modifyImage = document.getElementById("img" + index).src;
			$scope.descendienteModifyId = descendienteModifyId;
			
			let nombres = document.querySelector("#tr" + index + " td.product-name").innerText.trim();
			let apellidos = document.querySelector("#tr" + index + " td.product-lastname").innerText.trim();
			let numero_hermano = document.querySelector("#tr" + index + " td.product-number").innerText.trim();
			let notas = document.querySelector("#tr" + index + " td.product-notas ").innerText.trim();
			
			$scope.newDescendienteNombre = nombres;
			$scope.newDescendienteApellido = apellidos;
			$scope.newDescendienteNumero = parseInt(numero_hermano);
			$scope.newDescendienteNotas = notas;
		}

		$scope.resetAddModifyForm = function(){
			$scope.newDescendienteNombre = "";
			$scope.newDescendienteApellido = "";
			$scope.newDescendienteNumero = 0;
			$scope.newDescendienteNotas = "";
			$scope.newDescendienteImg = null;
			document.getElementById("newDescendienteImg").value = '';
		}
		
		$scope.viewDescendientes = function(familiar_id){
			var query = new URLSearchParams();
			query.append("familiar_id", familiar_id);
			location.href = "controller/ParejaController.php?" + query.toString();
		}

		$scope.addPareja = function(familiar_id){
			var query = new URLSearchParams();
			query.append("familiar_id", familiar_id);
			location.href = "administra-pareja.html?" + query.toString();
		}
	}]);
