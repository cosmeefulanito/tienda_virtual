// let LoadingSpinner = document.querySelector("#divLoading");
let tblCategorias;
let rowTable = "";
document.addEventListener('DOMContentLoaded', function(){
	if(document.querySelector("#foto")){
	    let foto = document.querySelector("#foto");
	    foto.onchange = function(e) {
	        let uploadFoto = document.querySelector("#foto").value;
	        let fileimg = document.querySelector("#foto").files;
	        let nav = window.URL || window.webkitURL;
	        let contactAlert = document.querySelector('#form_alert');
	        if(uploadFoto !=''){
	            let type = fileimg[0].type;
	            let name = fileimg[0].name;
	            if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png'){
	                contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';
	                if(document.querySelector('#img')){
	                    document.querySelector('#img').remove();
	                }
	                document.querySelector('.delPhoto').classList.add("notBlock");
	                foto.value="";
	                return false;
	            }else{  
	                    contactAlert.innerHTML='';
	                    if(document.querySelector('#img')){
	                        document.querySelector('#img').remove();
	                    }
	                    document.querySelector('.delPhoto').classList.remove("notBlock");
	                    let objeto_url = nav.createObjectURL(this.files[0]);
	                    document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src="+objeto_url+">";
	                }
	        }else{
	            alert("No selecciono foto");
	            if(document.querySelector('#img')){
	                document.querySelector('#img').remove();
	            }
	        }
	    }
	}

	if(document.querySelector(".delPhoto")){
	    let delPhoto = document.querySelector(".delPhoto");
	    delPhoto.onclick = function(e) {
	        removePhoto();
	    	document.querySelector("#foto_remove").value=1;
	    }
	}


	tblCategorias = $('#categoriasTable').DataTable({
		"language": {
			"url": base_url+"/Assets/js/plugins/Spanish.json"
		},
		"ajax": {
			"url": base_url+"/Categorias/getCategorias",
			"dataSrc": ""
		},
		"pageLength": 3,
	    "columns": [
	        { "data": "id" ,"name": "Id", "title": "ID"},
	        { "data": "nombre","name": "nombre", "title": "NOMBRE" },
	        { "data": "descripcion","name": "desc", "title": "DESCRIPCION" },          
	        { "data": "status","name": "desc", "title": "ESTADO" },         	        
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

	if (document.querySelector('#categoriaForm')) {
		let CategoriaForm = document.querySelector('#categoriaForm');
		CategoriaForm.onsubmit = function(e){
			e.preventDefault();
			let intIdCategoria = document.querySelector("#idcategoria").value;
			let strNombre = document.querySelector('#nombre_cat').value;
			let strDescripcion = document.querySelector('#descripcion_cat').value;
			let intEstado = document.querySelector('#estado_cat').value;		


			if(strNombre == '' || strDescripcion == '' || intEstado == ''){
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
	        
			// LoadingSpinner.style.display='flex';
			let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
			let ajaxUrl = base_url+ '/Categorias/setCategoria';
			let formData = new FormData(CategoriaForm);
			request.open("POST",ajaxUrl,true);
			request.send(formData);
			request.onreadystatechange = function() {
				if(request.readyState == 4 && request.status == 200){
					let objData = JSON.parse(request.responseText);					
					if(objData.status){
						if (rowTable == "") {
							tblCategorias.ajax.reload();							
						}else{
							rowTable.cells[1].textContent = strNombre
							rowTable.cells[2].textContent = strDescripcion
							htmlStatus = intEstado == 1 ? '<span class="badge badge-pill badge-success">Activo</span>' : '<span class="badge badge-pill badge-danger">Inactivo</span>';
							rowTable.cells[3].innerHTML = htmlStatus;
							rowTable="";
						}

						$("#categoriaFormModal").modal('hide');
						CategoriaForm.reset();
						swal('Categorias',objData.msg,'success');
						removePhoto();
					}else{
						swal('Error',objData.msg,'error');
					}
				}
				// LoadingSpinner.style.display='none';
				return false;
			}			
		} //fin onsubmit
	} //fin submit Categoria

}, false);



function fntViewCategoria(idcat){
	document.querySelector('#titleModal').innerHTML = 'Actualiza categoria';
	document.querySelector('#btnText').innerHTML = 'Actualizar';
	document.querySelector('.modal-header').classList.replace('headerRegister', 'headerUpdate');			
	document.querySelector('#btnActionForm').classList.replace('btn-info', 'headerUpdate');	
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
	let ajaxurl = base_url+'/Categorias/getCategoria/'+idcat;			
	request.open("GET",ajaxurl,true);
	request.send();
	request.onreadystatechange = function(){
	if(request.readyState == 4 && request.status == 200){		
			let Datos = JSON.parse(request.responseText);
			if(Datos.status){
				$("#intIdCat").text(Datos.data.id);
				$("#txtNombreCat").text(Datos.data.nombre);
				$("#txtDescripcionCat").text(Datos.data.descripcion);				
				let bdgeStatus = Datos.data.status == 1 ? '<span class="badge badge-primary">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>';
				document.querySelector('#txtEstadoCat').innerHTML = bdgeStatus;
				document.querySelector('#PortadaCat').innerHTML = '<img src="'+Datos.data.url_portada+'"></img>';
				$("#txtFechaCrea").text(Datos.data.datecreated);
			}	
		}
	}
	$('#modalViewCategoria').modal('show');
}


function fntEditCategoria(element,idcat){
	rowTable = element.parentNode.parentNode.parentNode;
	console.log("Elemento: ", element);
	console.log("rowTable: ", rowTable);
	document.querySelector('#titleModal').innerHTML = 'Actualiza Categoria';
	document.querySelector('#btnText').innerHTML = 'Actualizar';
	document.querySelector('.modal-header').classList.replace('headerRegister', 'headerUpdate');	
	document.querySelector('#btnActionForm').classList.replace('btn-info', 'headerUpdate');	
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
	let ajaxurl = base_url+'/Categorias/getCategoria/'+idcat;			
	request.open("GET",ajaxurl,true);
	request.send();

		request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){				
			let Datos = JSON.parse(request.responseText);
			if(Datos.status){					
				document.querySelector('#idcategoria').value = Datos.data.id;
				document.querySelector('#nombre_cat').value = Datos.data.nombre;
				document.querySelector('#descripcion_cat').value = Datos.data.descripcion;
				document.querySelector('#foto_actual').value = Datos.data.portada;
				document.querySelector("#foto_remove").value=0;
				if (Datos.data.status==1) {document.querySelector('#estado_cat').value=1}else{document.querySelector('#estado_cat').value=2}
					$('#estado_cat').selectpicker('render');
				if (document.querySelector("#img")) {
					document.querySelector("#img").src = Datos.data.url_portada;
					document.querySelector("#img").alt = Datos.data.nombre;
				}else{
					let img = document.createElement("img");
					img.src = Datos.data.url_portada;
					img.alt = Datos.data.nombre;
					img.id = "img";
					document.querySelector(".prevPhoto div").appendChild(img);
					// document.querySelector(".prevPhoto div").innerHTML = "<img id='img' src='"+Datos.data.url_portada+"' ";			

				}

				if (Datos.data.portada == "portada_categoria.png") {
					document.querySelector(".delPhoto").classList.add("notBlock");
				}else{
					document.querySelector(".delPhoto").classList.remove("notBlock");
				}


			}	
		}
	}
	$('#categoriaFormModal').modal('show');
}

function fntDeleteCategoria(idcat){	
	swal({
		title: 'Eliminar Categoria',
		text: '¿Desea eliminar la categoria?',
		type: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Si, eliminar',
		cancelButtonText: 'No, cancelar',
		closeOnConfirm: false,
		closeOnCanel: true
	}, function(isConfirm){
		if(isConfirm){
			let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
			let ajaxurl = base_url+'/Categorias/delCategoria';	
			let strData = "idCategoria="+idcat;
			request.open("POST",ajaxurl,true);
			request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			request.send(strData);
			request.onreadystatechange = function(){
				if(request.readyState == 4 && request.status == 200){				
					let Datos = JSON.parse(request.responseText);
					console.log("Datos Delete categoria: ", Datos);
					if(Datos.status){
						swal('Eliminar',Datos.msg,'success');								
						tblCategorias.ajax.reload();											
					}else{
						swal('Atencion!',Datos.msg,'error');
					}
				}
			}

		}

	})
}


function removePhoto(){
    document.querySelector('#foto').value ="";
    document.querySelector('.delPhoto').classList.add("notBlock");
    if (document.querySelector('#img')) {
    	document.querySelector('#img').remove();
    }
}


function openModal(){
	rowTable="";
	document.querySelector('#idcategoria').value = '';
	document.querySelector('#titleModal').innerHTML = 'Ingresa una nueva categoria';
	document.querySelector('#btnText').innerHTML = 'Guardar';
	// document.querySelector('.modal-header').classList.replace('headerRegister', 'headerRegister');
	let head = document.querySelector('.modal-header').classList;
	head.replace('headerUpdate', 'headerRegister');
	document.querySelector('#btnActionForm').classList.replace('btn-info', 'btn-primary');
	document.querySelector('#categoriaForm').reset();	
	$('#categoriaFormModal').modal('show');
	removePhoto();
}