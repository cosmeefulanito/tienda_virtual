var LoadingSpinner = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded',function(){
	var RolesTbl = $('#rolesTable').DataTable({
	"language": {
		"url": base_url+"/Assets/js/plugins/Spanish.json"
	},
	"ajax": {
		"url": base_url+"/Roles/getRoles",
		"dataSrc": ""
	},
        "columns": [
            { "data": "id" ,"name": "Id", "title": "ID"},
            { "data": "nombre","name": "nombre", "title": "NOMBRE" },
            { "data": "descripcion","name": "desc", "title": "DESCRIPCION" },          
            { "data": "status","name": "estado", "title": "ESTADO" } ,       
            { "data": "accion","name": "acciones", "title": "ACCION" }         
        ]
	});

	var formRol = document.querySelector("#rolForm");
	formRol.onsubmit = function(e){
		e.preventDefault();
		var intIdRol = document.querySelector("#idrol").value;
		var strNombre = document.querySelector("#nombre_rol").value;
		var strDescripcion = document.querySelector("#descripcion_rol").value;
		var intStatus = document.querySelector("#estado").value;

		if(strNombre == '' || strDescripcion == '' || intStatus == ''){
			swal("Atencion", "Formulario incompleto", "error");
			return false;
		}
		LoadingSpinner.style.display='flex';
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
		var ajaxurl = base_url+'/Roles/setRol';
		var formData= new FormData(formRol);
		request.open("POST",ajaxurl,true);
		request.send(formData);
		request.onreadystatechange = function(){			
			if(request.readyState == 4 && request.status == 200){				
				var Datos = JSON.parse(request.responseText);
					if(Datos.status){
						$('#modalFormRol').modal('hide');
						formRol.reset();
						swal("Roles de usuario", Datos.msg, "success");
						RolesTbl.ajax.reload();
					}else{
						swal("Roles de usuario", Datos.msg, "error");
					}
			}
			LoadingSpinner.style.display='none';
		}		
	}
})

// document.addEventListener('click',fntEditRol);
// document.addEventListener('click',fnDeleteRol);
// document.addEventListener('click',fntPermisosRol);

window.addEventListener('load',function(){	
	// fntEditRol();	
	// fnDeleteRol();	
	// fntPermisosRol();	

}, false);





function openModal(){
	document.querySelector('#idrol').innerHTML = '';
	document.querySelector('#titleModal').innerHTML = 'Ingresa un nuevo rol';
	document.querySelector('#btnText').innerHTML = 'Guardar';
	document.querySelector('.modal-header').classList.replace('headerUpdate', 'headerRegister');
	document.querySelector('#btnActionForm').classList.replace('headerUpdate', 'btn-info');
	document.querySelector('#rolForm').reset();
	$('#modalFormRol').modal('show');	
}

function fntEditRol(idrol){
	document.querySelector('#titleModal').innerHTML = 'Actualiza Rol';
	document.querySelector('#btnText').innerHTML = 'Actualizar';
	document.querySelector('.modal-header').classList.replace('headerRegister', 'headerUpdate');			
	document.querySelector('#btnActionForm').classList.replace('btn-info', 'headerUpdate');
	let IDRol = idrol;
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
	var ajaxurl = base_url+'/Roles/getRol/'+IDRol;			
	request.open("GET",ajaxurl,true);
	request.send();

		request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){				
			var Datos = JSON.parse(request.responseText);
			if(Datos.status){					
				document.querySelector('#idrol').value = Datos.data.id;
				document.querySelector('#nombre_rol').value = Datos.data.nombre;
				document.querySelector('#descripcion_rol').value = Datos.data.descripcion;
				document.querySelector('#estado').value = Datos.data.status;
			}	
		}
	}
	$('#modalFormRol').modal('show');
}

function fnDeleteRol(idrol){
	var idrol = idrol;
	swal({
		title: 'Eliminar rol',
		text: '¿Desea eliminar el rol?',
		type: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Si, eliminar',
		cancelButtonText: 'No, cancelar',
		closeOnConfirm: false,
		closeOnCanel: true
	}, function(isConfirm){
		if(isConfirm){
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
			var ajaxurl = base_url+'/Roles/delRol/';	
			var strData = "idrol="+idrol;
			request.open("POST",ajaxurl,true);
			request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			request.send(strData);
			request.onreadystatechange = function(){
				if(request.readyState == 4 && request.status == 200){				
					var Datos = JSON.parse(request.responseText);
					console.log("Datos Delete: ", Datos);
					if(Datos.status){
						swal('Eliminar',Datos.msg,'success');								
						$('#rolesTable').DataTable().ajax.reload();
						// RolesTbl.ajax.reload();				
					}else{
						swal('Atencion!',Datos.msg,'error');
					}
				}
			}

		}

	})
}

function fntPermisosRol(idrol){
	var IDRol = idrol;
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
	var ajaxurl = base_url+'/Permisos/getPermisosRol/'+IDRol;			
	request.open("GET",ajaxurl,true);
	request.send();

	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			document.querySelector("#ajaxResponse").innerHTML = request.responseText;
			$('.permisos-modal-xl').modal('show');
			document.querySelector('#formPermisos').addEventListener('submit',fntSavePermisos, false);
		}
	}
}

function fntSavePermisos(event){	
			event.preventDefault();
			LoadingSpinner.style.display='flex';
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
			var ajaxurl = base_url+'/Permisos/setPermisos/';			
			var formElement = document.querySelector("#formPermisos");
			var formData = new FormData(formElement);
			request.open("POST",ajaxurl,true);
			request.send(formData);

			request.onreadystatechange = function(){
				if(request.readyState == 4 && request.status == 200){					
					var Data = JSON.parse(request.responseText);
					if(Data.status){
						swal("Permisos de usuario", Data.msg, "success")
					}else{
						swal("Error de Permisos", Data.msg, "error")
					}
					
				}
				LoadingSpinner.style.display='none';
				return false;
			}

			
	
}