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
		var strNombre = document.querySelector("#nombre_rol").value;
		var strDescripcion = document.querySelector("#descripcion_rol").value;
		var intStatus = document.querySelector("#estado").value;

		if(strNombre == '' || strDescripcion == '' || intStatus == ''){
			swal("Atencion", "Formulario incompleto", "error");
			return false;
		}

		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
		var ajaxurl = base_url+'/Roles/setRol';
		var formData= new FormData(formRol);
		request.open("POST",ajaxurl,true);
		request.send(formData);
		request.onreadystatechange = function(){			
			if(this.readyState == 4 && this.status == 200){				
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
		}
		
	}

	
})
// editModal();
window.addEventListener('click',editModal);




function openModal(){
	document.querySelector('#idrol').innerHTML = '';
	document.querySelector('#titleModal').innerHTML = 'Ingresa un nuevo rol';
	document.querySelector('#btnText').innerHTML = 'Guardar';
	document.querySelector('.modal-header').classList.replace('headerUpdate', 'headerRegister');
	document.querySelector('#btnActionForm').classList.replace('headerUpdate', 'btn-info');
	document.querySelector('#rolForm').reset();
	$('#modalFormRol').modal('show');	
}


function editModal(){
	var btnEditRol = document.querySelectorAll(".btnEditarRol");
	btnEditRol.forEach(function(btnEditRol){
		btnEditRol.addEventListener('click', function(){
			document.querySelector('#titleModal').innerHTML = 'Actualiza Rol';
			document.querySelector('#btnText').innerHTML = 'Actualizar';
			document.querySelector('.modal-header').classList.replace('headerRegister', 'headerUpdate');			
			document.querySelector('#btnActionForm').classList.replace('btn-info', 'headerUpdate');			
			$('#modalFormRol').modal('show');
		});
	});
}