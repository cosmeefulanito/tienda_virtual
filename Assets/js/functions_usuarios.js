var tblUsuarios;
var LoadingSpinner = document.querySelector("#divLoading");
// LoadingSpinner.style.display='flex';
// LoadingSpinner.style.display='none';
document.addEventListener('DOMContentLoaded', function(){
	tblUsuarios = $('#usuariosTable').DataTable({
		"language": {
			"url": base_url+"/Assets/js/plugins/Spanish.json"
		},
		"ajax": {
			"url": base_url+"/usuarios/getusuarios",
			"dataSrc": ""
		},
		"pageLength": 5,
	    "columns": [
	        { "data": "id" ,"name": "Id", "title": "ID"},
	        { "data": "nombres","name": "nombre", "title": "NOMBRES" },
	        { "data": "apellidos","name": "desc", "title": "APELLIDOS" },          
	        { "data": "email","name": "desc", "title": "E-MAIL" },          
	        { "data": "telefono","name": "desc", "title": "TELEFONO" },       
	        { "data": "nombre","name": "desc", "title": "ROL" },       
	        { "data": "status","name": "estado", "title": "ESTADO" } ,       
	        { "data": "accion","name": "acciones", "title": "ACCION" }         
	    	],
	    "dom": 'lBfrtip',
	    "buttons": [
		    	{
		    		"extend": "copyHtml5",
		    		"text" : "<i class='fas fa-copy'> COPIAR</i>",
		    		"titleAttr" : "COPIAR",
		    		"className" :"btn btn-secondary"
		    	},
		    	{
		    		"extend": "excelHtml5",
		    		"text" : "<i class='fas fa-file-excel'> EXCEL</i>",
		    		"titleAttr" : "EXCEL",
		    		"className" :"btn btn-success"
		    	},
		    	{
		    		"extend": "csvHtml5",
		    		"text" : "<i class='fas fa-file-csv'> CSV</i>",
		    		"titleAttr" : "CSV",
		    		"className" :"btn btn-info"
		    	},
		    	{
		    		"extend": "pdfHtml5",
		    		"text" : "<i class='far fa-file-pdf'> PDF</i>",
		    		"titleAttr" : "PDF",
		    		"className" :"btn btn-danger"
		    	}
	    	]
	});
	
	if (document.querySelector('#usuarioForm')) {
		var formUsuario = document.querySelector('#usuarioForm');
		formUsuario.onsubmit = function(e){
			e.preventDefault();
			var rut = document.querySelector('txt_rut');
			var nombre = document.querySelector('txt_nombre');
			var apellidos = document.querySelector('txt_apellidos');
			var telefono = document.querySelector('txt_telefono');
			var email = document.querySelector('txt_email');
			var rol = document.querySelector('listRol');
			var estado = document.querySelector('listStatus');
			var pswd = document.querySelector('txt_password');

			if(rut == '' || nombre == '' || apellidos == '' || telefono == '' || email == '' || rol == '' || estado == '' || pswd == ''){
				swal('Todos los campos son obligatorios', 'error')
				return false;
			}

			 let elementsValid = document.getElementsByClassName("valid");
	        for (let i = 0; i < elementsValid.length; i++) { 
	            if(elementsValid[i].classList.contains('is-invalid')) { 
	                swal("Atención", "Por favor verifique los campos en rojo." , "error");
	                return false;
	            } 
	        }
	        
			LoadingSpinner.style.display='flex';			
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
			var ajaxUrl = base_url+ '/Usuarios/setUsuario';
			var formData = new FormData(formUsuario);
			request.open("POST",ajaxUrl,true);
			request.send(formData);
			request.onreadystatechange = function() {
				if(request.readyState == 4 && request.status == 200){
					var objData = JSON.parse(request.responseText);
					console.log(objData.status);
					if(objData.status){
						$("#usuarioFormModal").modal('hide');
						formUsuario.reset();
						tblUsuarios.ajax.reload();
						
						swal('Usuarios',objData.msg,'success');
					}else{
						swal('Error',objData.msg,'error');
					}
				}
				LoadingSpinner.style.display='none';
				return false;
			}

			console.log("submit form usuario modal!!!");
		} //fin onsubmit
	}

	// ** Actualizar Perfil ** 
	if (document.querySelector('#perfilForm')) {
		var formPerfil = document.querySelector('#perfilForm');
		formPerfil.onsubmit = function(e){
			e.preventDefault();
			var rut = document.querySelector('txt_rut');
			var nombre = document.querySelector('txt_nombre');
			var apellidos = document.querySelector('txt_apellidos');
			var telefono = document.querySelector('txt_telefono');
			var pass = document.querySelector('#txt_password').value;
			var passConf = document.querySelector('#txt_confirmPassword').value;

			if (pass!='' || passConf!='') {
				if (pass!=passConf) {
					swal("Atencion","Las contraseñas no son iguales", "info");
					return false;
				}
				if (pass.length<5) {
					swal("Atencion","Las contraseñas deben tener un largo minimo de 5 caracteres", "info");									
					return false;
				}
			}

			if(rut == '' || nombre == '' || apellidos == '' || telefono == ''){
				swal('Todos los campos son obligatorios', 'error')
				return false;
			}

			 let elementsValid = document.getElementsByClassName("valid");
	        for (let i = 0; i < elementsValid.length; i++) { 
	            if(elementsValid[i].classList.contains('is-invalid')) { 
	                swal("Atención", "Por favor verifique los campos en rojo." , "error");
	                return false;
	            } 
	        }
	        LoadingSpinner.style.display='flex';
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
			var ajaxUrl = base_url+ '/Usuarios/putperfil';
			var formData = new FormData(formPerfil);
			request.open("POST",ajaxUrl,true);
			request.send(formData);
			request.onreadystatechange = function() {
				if (request.readyState != 4) return;
				if(request.status == 200){
					var objData = JSON.parse(request.responseText);
					if (objData) {
						$("#modalFormPerfil").modal("hide");
						swal({
						  title: '',
						  text: objData.msg,
						  icon: 'success',						  
						  confirmButtonColor: '#3085d6',						  
						  confirmButtonText: 'Aceptar'
						}, function(isConfirm){
							location.reload();
						})
					}else{
						swal("Error", objData.msg, "warning");
					}

				}
				LoadingSpinner.style.display='none';
				return false;
			}

			console.log("submit form usuario modal!!!");
		} //fin onsubmit
	}

	// ** Actualizar Perfil Datos Fiscales ** 
	if (document.querySelector('#formDataFiscal')) {
		var formDatosFiscal = document.querySelector('#formDataFiscal');
		formDatosFiscal.onsubmit = function(e){
			e.preventDefault();
			var rutFiscal = document.querySelector('#txt_rut_fiscal').value;
			var nombreFiscal = document.querySelector('#txt_nombre_fiscal').value;
			var apellidosFiscal = document.querySelector('#txt_direccion_fiscal').value;

			if(rutFiscal == '' || nombreFiscal == '' || apellidosFiscal == ''){
				swal('error','Todos los campos son obligatorios', 'error')
				return false;
			}

			 let elementsValid = document.getElementsByClassName("valid");
	        for (let i = 0; i < elementsValid.length; i++) { 
	            if(elementsValid[i].classList.contains('is-invalid')) { 
	                swal("Atención", "Por favor verifique los campos en rojo." , "error");
	                return false;
	            } 
	        }

	        LoadingSpinner.style.display='flex';			
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
			var ajaxUrl = base_url+ '/Usuarios/putDFiscal';
			var formData = new FormData(formDatosFiscal);
			request.open("POST",ajaxUrl,true);
			request.send(formData);
			request.onreadystatechange = function() {
				if (request.readyState != 4) return;
				if(request.status == 200){
					var objData = JSON.parse(request.responseText);
					if (objData) {
						$("#modalFormPerfil").modal("hide");
						swal({
						  title: '',
						  text: objData.msg,
						  icon: 'success',						  
						  confirmButtonColor: '#3085d6',						  
						  confirmButtonText: 'Aceptar'
						}, function(isConfirm){
							location.reload();
						})
					}else{
						swal("Error", objData.msg, "warning");
					}
				}
				LoadingSpinner.style.display='none';
				return false;
			}

			console.log("submit form usuario modal!!!");
		} //fin onsubmit
	}


})

function fntDeleteUsuario(idusuario){
	var idu = idusuario;
	swal({
		title: 'Eliminar Usuario',
		text: '¿Desea eliminar el usuario?',
		type: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Si, eliminar',
		cancelButtonText: 'No, cancelar',
		closeOnConfirm: false,
		closeOnCanel: true
	}, function(isConfirm){
		if(isConfirm){
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
			var ajaxurl = base_url+'/Usuarios/delUsuario/';	
			var strData = "idusuario="+idu;
			request.open("POST",ajaxurl,true);
			request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			request.send(strData);
			request.onreadystatechange = function(){
				if(request.readyState == 4 && request.status == 200){				
					var Datos = JSON.parse(request.responseText);
					console.log("Datos Delete usuario: ", Datos);
					if(Datos.status){
						swal('Eliminar',Datos.msg,'success');								
						tblUsuarios.ajax.reload();											
					}else{
						swal('Atencion!',Datos.msg,'error');
					}
				}
			}

		}

	})
}


function openModal(){
	document.querySelector('#idusuario').value = '';
	document.querySelector('#titleModal').innerHTML = 'Ingresa un nuevo usuario';
	document.querySelector('#btnText').innerHTML = 'Guardar';
	document.querySelector('.modal-header').classList.replace('headerRegister', 'headerRegister');
	document.querySelector('#btnActionForm').classList.replace('btn-info', 'btn-primary');
	document.querySelector('#usuarioForm').reset();
	$('#usuarioFormModal').modal('show');	
}

window.addEventListener('load',function(){	
	fntRolesUsuarios();	
}, false);


function fntRolesUsuarios(){
	if (document.querySelector('#listRol')) {
		var ajaxUrl = base_url+ '/Roles/getSelectRoles';
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
		request.open("GET",ajaxUrl,true);
		request.send();

		request.onreadystatechange = function(){
				if(request.readyState == 4 && request.status == 200){
					document.querySelector('#listRol').innerHTML = request.responseText;
					// document.querySelector('#listRol').value = 1;
					$('#listRol').selectpicker('render');
				}
		}
	}	
}

function fntViewUsuario(idusuario){
	var idp = idusuario;
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
	var ajaxUrl = base_url+'/Usuarios/getUsuario/'+idp;
	request.open("GET",ajaxUrl,true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			var Datos = JSON.parse(request.responseText);						
			if(Datos.status){
				var bdgeStatus = Datos.data.status == 1 ? '<span class="badge badge-primary">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>';
				$("#identificacion").text(Datos.data.identificacion);
				$("#nombre").text(Datos.data.nombres+' '+Datos.data.apellidos);
				$("#fono").text(Datos.data.telefono);
				$("#email").text(Datos.data.email);
				$("#rol").text(Datos.data.nombre_rol);
				document.querySelector('#estado').innerHTML = bdgeStatus;
				document.querySelector('#fecha_registro').innerHTML = Datos.data.fecha_crea;
				$("#ModalviewUser").modal('show');
			}else{
				swal("Error", Datos.msg, "error");
			}
		}
	}
}

function fntEditUsuario(idusuario){
	document.querySelector('#idusuario').innerHTML = '';
	document.querySelector('#titleModal').innerHTML = 'Actualizacion de usuario';
	document.querySelector('#btnText').innerHTML = 'Actualizar';
	document.querySelector('.modal-header').classList.replace('headerRegister', 'headerUpdate');
	document.querySelector('#btnActionForm').classList.replace('btn-info', 'btn-info');
	var idp = idusuario;
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
	var ajaxUrl = base_url+'/Usuarios/getUsuario/'+idp;
	request.open("GET",ajaxUrl,true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){					
			var Datos = JSON.parse(request.responseText);
			console.log("---- " , Datos)
			if (Datos.status) {
				document.querySelector('#idusuario').value = Datos.data.id;
				document.querySelector('#txt_rut').value = Datos.data.identificacion;
				document.querySelector('#txt_nombre').value = Datos.data.nombres;
				document.querySelector('#txt_apellidos').value = Datos.data.apellidos;
				document.querySelector('#txt_telefono').value = Datos.data.telefono;
				document.querySelector('#txt_email').value = Datos.data.email;
				document.querySelector('#listRol').value = Datos.data.rolid;
				document.querySelector('#listStatus').value = Datos.data.status == 1 ? 1 : 2;
				$("#listRol").selectpicker('render');
				$("#listStatus").selectpicker('render');
			}

			$("#usuarioFormModal").modal('show');
		}

		
	}
}

// ** VISTA PERFIL ** 
function openModalPerfil(){
	$("#modalFormPerfil").modal("show");
}




