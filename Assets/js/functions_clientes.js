// jQuery(document).ready(function($) {
// 	console.log("cargo desde el functions clientes")
// });
var tblClientes;
var LoadingSpinner = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){
	tblClientes = $('#clientesTable').DataTable({
		"language": {
			"url": base_url+"/Assets/js/plugins/Spanish.json"
		},
		"ajax": {
			"url": base_url+"/clientes/getClientes",
			"dataSrc": ""
		},
		"pageLength": 5,
	    "columns": [
	        { "data": "nit" ,"name": "Id", "title": "RUT"},
	        { "data": "nombre_fiscal","name": "nombre", "title": "RAZON SOCIAL" },
	        { "data": "nombre_fantasia","name": "desc", "title": "NOMBRE" },          
	        { "data": "email","name": "desc", "title": "CONTACTO" },          
	        { "data": "telefono","name": "desc", "title": "CONTACTO TELEFONO" },	             
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
	}); //fin table clientes

	if (document.querySelector('#clienteForm')) {
		var ClienteForm = document.querySelector('#clienteForm');
		ClienteForm.onsubmit = function(e){
			e.preventDefault();
			// Datos contacto
			var rut = document.querySelector('txt_rut');
			var nombre = document.querySelector('txt_nombre');
			var apellidos = document.querySelector('txt_apellidos');
			var telefono = document.querySelector('txt_telefono');
			var email = document.querySelector('txt_email');
			var pswd = document.querySelector('txt_password');
			// Datos empresa
			var rut_empresa = document.querySelector('txt_rut_empresa');
			var razon_social = document.querySelector('txt_razon_social');
			var nombre_fantasia = document.querySelector('txt_nombre_fantasia');
			var direccion_empresa = document.querySelector('txt_direccion_empresa');
			// var telefono_empresa = document.querySelector('txt_telefono_empresa');			


			if(rut == '' || nombre == '' || apellidos == '' || telefono == '' || email == '' || pswd == '' || rut_empresa == '' || razon_social == '' || nombre_fantasia == ''){
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
			var ajaxUrl = base_url+ '/Clientes/setCliente';
			var formData = new FormData(ClienteForm);
			request.open("POST",ajaxUrl,true);
			request.send(formData);
			request.onreadystatechange = function() {
				if(request.readyState == 4 && request.status == 200){
					var objData = JSON.parse(request.responseText);
					console.log(objData.status);
					if(objData.status){
						$("#clienteFormModal").modal('hide');
						ClienteForm.reset();
						tblClientes.ajax.reload();
						
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
	} //fin submit cliente

}, false)

function fntViewCliente(idusuario){	
	var idp = idusuario;
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
	var ajaxUrl = base_url+'/Clientes/getCliente/'+idp;
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
				$("#rut_empresa").text(Datos.data.nit);				
				$("#nombre_empresa").text(Datos.data.nombre_fiscal);				
				$("#direccion_empresa").text(Datos.data.direccion_fiscal);				
				document.querySelector('#fecha_registro').innerHTML = Datos.data.fecha_crea;
				$("#ModalviewCliente").modal('show');
			}else{
				swal("Error", Datos.msg, "error");
			}
		}
	}
}

function fntEditCliente(idusuario){
	document.querySelector('#idusuario').innerHTML = '';
	document.querySelector('#titleModal').innerHTML = 'Actualizacion de cliente';
	document.querySelector('#btnText').innerHTML = 'Actualizar';
	let head = document.querySelector('.modal-header').classList;
	head.replace('headerRegister', 'headerUpdate');
	document.querySelector('#btnActionForm').classList.replace('btn-info', 'btn-info');
	var idp = idusuario;
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
	var ajaxUrl = base_url+'/Clientes/getCliente/'+idp;
	request.open("GET",ajaxUrl,true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){					
			var Datos = JSON.parse(request.responseText);
			console.log("editar cliente:  " , Datos)
			if (Datos.status) {
				document.querySelector('#idusuario').value = Datos.data.id;
				document.querySelector('#txt_rut').value = Datos.data.identificacion;
				document.querySelector('#txt_nombre').value = Datos.data.nombres;
				document.querySelector('#txt_apellidos').value = Datos.data.apellidos;
				document.querySelector('#txt_telefono').value = Datos.data.telefono;
				document.querySelector('#txt_email').value = Datos.data.email;
				document.querySelector('#txt_rut_empresa').value = Datos.data.nit;
				document.querySelector('#txt_razon_social').value = Datos.data.nombre_fiscal;
				document.querySelector('#txt_nombre_fantasia').value = Datos.data.nombre_fantasia;
				document.querySelector('#txt_direccion_empresa').value = Datos.data.direccion_fiscal;
				// document.querySelector('#fecha_registro').value = Datos.data.status;				
			}

			$("#clienteFormModal").modal('show');
		}

		
	}
}

function fntDeleteCliente(idusuario){
	var idu = idusuario;
	swal({
		title: 'Eliminar Cliente',
		text: '¿Desea eliminar el cliente?',
		type: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Si, eliminar',
		cancelButtonText: 'No, cancelar',
		closeOnConfirm: false,
		closeOnCanel: true
	}, function(isConfirm){
		if(isConfirm){
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
			var ajaxurl = base_url+'/Clientes/delCliente';	
			var strData = "idusuario="+idu;
			request.open("POST",ajaxurl,true);
			request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			request.send(strData);
			request.onreadystatechange = function(){
				if(request.readyState == 4 && request.status == 200){				
					var Datos = JSON.parse(request.responseText);
					console.log("Datos Delete cliente: ", Datos);
					if(Datos.status){
						swal('Eliminar',Datos.msg,'success');								
						tblClientes.ajax.reload();											
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
	document.querySelector('#titleModal').innerHTML = 'Ingresa un nuevo cliente';
	document.querySelector('#btnText').innerHTML = 'Guardar';
	let head = document.querySelector('.modal-header').classList;
	head.replace('headerUpdate', 'headerRegister');
	document.querySelector('#btnActionForm').classList.replace('btn-info', 'btn-primary');
	document.querySelector('#clienteForm').reset();
	$('#clienteFormModal').modal('show');	
}