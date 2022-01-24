// Login Page Flipbox control
$('.login-content [data-toggle="flip"]').click(function() {
	$('.login-box').toggleClass('flipped');
	return false;
});



document.addEventListener('DOMContentLoaded',function(){
	if(document.querySelector("#loginForm")){

		let loginForm = document.querySelector("#loginForm");
		loginForm.onsubmit = function(e){
			
			e.preventDefault();
			var txtEmail = document.querySelector("#txtEmail").value;
			var txtPass = document.querySelector("#txtPassword").value;
			

			if(txtEmail == '' || txtPass == '' ){
				$(".alertLogin").html("<span>Campos incompletos</span>");
				return false;
			}else{
				$(".alertLogin span").remove();
			}
			var LoadingSpinner = document.querySelector("#divLoading");
			LoadingSpinner.style.display='flex';
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
			var ajaxurl = base_url+'/Login/Auth';
			var formData= new FormData(loginForm);
			request.open("POST",ajaxurl,true);
			request.send(formData);
			request.onreadystatechange = function(){			
			if(request.readyState == 4 && request.status == 200){			
					var Datos = JSON.parse(request.responseText);
					if(Datos.status){
						window.location.href = base_url+'/Dashboard';
					}else{
						$(".alertLogin").html("<span>"+Datos.msg+"</span>");
					}
				}
				LoadingSpinner.style.display='none';
			}
		}
	}

	// Ingresa email y envía correo para recuperación de contraseña
	if(document.querySelector("#resetForm")){
		let formReset = document.querySelector("#resetForm");
		formReset.onsubmit = function(e){
			e.preventDefault();

			if(document.querySelector("#txt_email").value == ''){
				alert("Error")
				return false;
			}else{
				var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
				var ajaxurl = base_url+'/Login/resetPassword';
				var formData= new FormData(formReset);
				request.open("POST",ajaxurl,true);
				request.send(formData);
				request.onreadystatechange = function(){
					console.log("Enviando email...", request)
					if(request.readyState != 4) return ;
					if(request.status == 200){
						var objData = JSON.parse(request.responseText);
						if (objData.status){
							swal("", "Se le ha enviado un correo para reestablecer su constraseña", "success");
							//http://localhost/mitienda/login/confirmUser/andres.astorga@mayor.cl/a770295ab44c31e90693-5a5539ef1e376c1bf07f-4fd28d01e90ddd4634a0-d777666a7026348702f5

						}else{
							alert("Ops!, ha ocurrido un problema")
						}
					}else{
						alert("Error en el proceso!!");
					}
				}				
			}
		}
	}

	if(document.querySelector("#loginFormReset")){
		let formPassReset = document.querySelector("#loginFormReset");
		formPassReset.onsubmit = function(e){
			e.preventDefault();

			if(document.querySelector("#txtNuevoPass").value == '' || document.querySelector("#txtConfirmaPass").value == ''){				
				swal("Error ","Campos incompleto","error");
				return false;
			}

			if(document.querySelector("#txtNuevoPass").value != document.querySelector("#txtConfirmaPass").value){
				// alert("Las contraseñas deben ser iguales")
				swal("Error al cambiar password!!","Las contraseñas deben ser iguales","error");
				return false;
			}

			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
				var ajaxurl = base_url+'/Login/changePassword';
				var formData= new FormData(formPassReset);
				request.open("POST",ajaxurl,true);
				request.send(formData);
				request.onreadystatechange = function(){
					console.log("...",request  );
					if(request.readyState!= 4) return;
					if(request.status == 200){
						var objData = JSON.parse(request.responseText);
						if (objData.status) {
							swal({
								title: 'Cambio de contraseña',
								text: "Su contraseña se ha reestablecido exitosamente",
								type: 'success',							  
								confirmButtonColor: '#3085d6',
								cancelButtonColor: '#d33',
								confirmButtonText: 'Iniciar sesion',
								allowOutsideClick: false
							}, function (isConfirm) {
									if (isConfirm) {window.location = base_url+'/login';}
							})

						}else{
							swal("Atencion",objData.msg,"error");
						}//objdata.status
					}else{
						swal("Error al cambiar password!!",objData.msg,"error");
					}
				}



		}
	}


},false)




				