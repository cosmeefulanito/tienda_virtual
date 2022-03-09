
let tblProductos;
let rowTable;
var LoadingSpinner = document.querySelector("#divLoading");

document.write(`<script src="${base_url}/Assets/js/plugins/JsBarcode.all.min.js"></script>`);
if (document.querySelector('#txtCodigoProducto')) {
  let inputCodigo = document.querySelector('#txtCodigoProducto');

  inputCodigo.onkeyup = function () {
    if (inputCodigo.value.length>=5) {
      document.querySelector("#divBarCode").classList.remove("notBlock");
      fntBarCode(inputCodigo.value);
    }else{
      document.querySelector("#divBarCode").classList.add("notBlock");
    }
  }  
}

// Prevent jQuery UI dialog from blocking focusin
$(document).on('focusin', function(e) {
	if ($(e.target).closest(".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
	  e.stopImmediatePropagation();
	}
});


                

window.addEventListener('load', function () {
  fntSelectCategorias();
  fntValidText();
	fntValidNumber();
	fntInputFile();
  
  tblProductos = $('#productosTable').DataTable({
		"language": {
			"url": base_url+"/Assets/js/plugins/Spanish.json"
		},
		"ajax": {
			"url": base_url+"/Productos/getProductos",
			"dataSrc": ""
		},
		"pageLength": 10,
	    "columns": [
	        { "data": "id" ,"name": "Id", "title": "ID"},
	        { "data": "nombre","name": "nombre", "title": "NOMBRE" },
	        { "data": "nombreCategoria","name": "desc", "title": "CATEGORIA" },          
          { "data": "precio","name": "precio", "title": "PRECIO" }, 
	        { "data": "status","name": "estado", "title": "ESTADO" },         	        
	        { "data": "accion","name": "acciones", "title": "ACCION" }         
	    	],
        "columnDefs": [
          {'className' : "textcenter", "targets": [0]},
          {'className' : "textcenter", "targets": [1]},
          {'className' : "textcenter", "targets": [2]},
          {'className' : "textcenter", "targets": [3]}
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
		    		"className" :"btn btn-success",
            "exportOptions" : {
              "columns" : [0,1,2,3]
            }
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


  if (document.querySelector('#productoForm')) {
		let ProductoForm = document.querySelector('#productoForm');
		ProductoForm.onsubmit = function(e){
			e.preventDefault();
			 let intIdProducto = document.querySelector("#idproducto").value;
			let strNombreProducto = document.querySelector('#strNombreProducto').value;
      let strDescripcionProducto = document.querySelector('#txtDescripcionProducto').value;
			let intCodigoProducto = document.querySelector('#txtCodigoProducto').value;
			let intPrecioProducto = document.querySelector('#intPrecioProducto').value;
      let intStockProducto = document.querySelector('#intStockProducto').value;
      let intCategoriaProducto = document.querySelector('#listCategoriaProducto').value;
      let intStatusProducto = document.querySelector('#listStatusProducto').value;
      
      if(intCodigoProducto.length<5){
        swal('El codigo debe ser de largo mayor o igual a 5', 'error')
        return false;
      }

			if(strNombreProducto == '' || strDescripcionProducto == '' || intCodigoProducto == '' || intPrecioProducto == '' || intStockProducto == '' || intCategoriaProducto == '' || intStatusProducto == ''){
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
      tinymce.triggerSave();
			let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
			let ajaxUrl = base_url+ '/Productos/setProducto';
			let formData = new FormData(ProductoForm);
			request.open("POST",ajaxUrl,true);
			request.send(formData);
			request.onreadystatechange = function() {
				if(request.readyState == 4 && request.status == 200){
					let objData = JSON.parse(request.responseText);					
					console.log(objData)
					if(objData.status){
						if (rowTable=="") {
							tblProductos.ajax.reload();
						}else{
							htmlStatus = intStatusProducto == 1 ? '<span class="badge badge-pill badge-success">Activo</span>' : '<span class="badge badge-pill badge-danger">Inactivo</span>';
							rowTable.cells[4].innerHTML = htmlStatus;
							rowTable.cells[1].textContent = strNombreProducto;
							rowTable.cells[2].textContent = intCategoriaProducto; //Actualiza categoria con id, revisar mas adelante para que se vea limpio para el usuario
							rowTable.cells[3].textContent = SMoney+intPrecioProducto;
							rowTable="";

						}
						swal('Productos',objData.msg,'success');
						document.querySelector(".containerGallery").classList.remove('notBlock');
						// $("#productoFormModal").modal('hide');            
						ProductoForm.reset();
					}else{
						swal('Error',objData.msg,'error');
					}
				}
				LoadingSpinner.style.display='none';
				return false;
			}			
		} //fin onsubmit
	} //fin submit producto

	if (document.querySelector(".btnAddImage")) {
		let BtnAddImage = document.querySelector(".btnAddImage ");
		BtnAddImage.onclick	= function(e){
			let newDiv = document.createElement("div");
			let divId = Date.now();
			newDiv.id = "div"+divId;
			newDiv.innerHTML = `<div class="prevImage"></div>
                      <input type="file" id="img${divId}" name="foto" class="inputUploadFile">
                      <label for="img${divId}" class="btnUploadFile"><i class="fas fa-upload"></i></label>
                      <button type="button" class="btnDeleteImage notBlock" onclick="fntDelItem('#div${divId}');"><i class="far fa-trash-alt"></i></button>`;
                      document.querySelector("#containerImages").appendChild(newDiv);
                      document.querySelector("#div"+divId+" .btnUploadFile").click();
                      fntInputFile();
		}
	}


}, false);


// tinymce.init({
// 	selector: '#txtDescripcionProducto',
// 	width: "100%",
//     height: 400,    
//     statubar: true,
//     plugins: [
//         "advlist autolink link image lists charmap print preview hr anchor pagebreak",
//         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
//         "save table contextmenu directionality emoticons template paste textcolor"
//     ],
//     toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
// });

var useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;

tinymce.init({
  selector: 'textarea#txtDescripcionProducto',
  plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
  imagetools_cors_hosts: ['picsum.photos'],
  menubar: 'file edit view insert format tools table help',
  toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
  toolbar_sticky: true,
  autosave_ask_before_unload: true,
  autosave_interval: '30s',
  autosave_prefix: '{path}{query}-{id}-',
  autosave_restore_when_empty: false,
  autosave_retention: '2m',
  image_advtab: true,
  link_list: [
    { title: 'My page 1', value: 'https://www.tiny.cloud' },
    { title: 'My page 2', value: 'http://www.moxiecode.com' }
  ],
  image_list: [
    { title: 'My page 1', value: 'https://www.tiny.cloud' },
    { title: 'My page 2', value: 'http://www.moxiecode.com' }
  ],
  image_class_list: [
    { title: 'None', value: '' },
    { title: 'Some class', value: 'class-name' }
  ],
  importcss_append: true,
  file_picker_callback: function (callback, value, meta) {
    /* Provide file and text for the link dialog */
    if (meta.filetype === 'file') {
      callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
    }

    /* Provide image and alt text for the image dialog */
    if (meta.filetype === 'image') {
      callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
    }

    /* Provide alternative source and posted for the media dialog */
    if (meta.filetype === 'media') {
      callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
    }
  },
  templates: [
        { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
    { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
    { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
  ],
  template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
  template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
  height: 600,
  image_caption: true,
  quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
  noneditable_noneditable_class: 'mceNonEditable',
  toolbar_mode: 'sliding',
  contextmenu: 'link image imagetools table',
  skin: useDarkMode ? 'oxide-dark' : 'oxide',
  content_css: useDarkMode ? 'dark' : 'default',
  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
 });

function fntInputFile(){
	let inputUploadFile = document.querySelectorAll(".inputUploadFile");
	inputUploadFile.forEach(function(inputUploadFile) {
		inputUploadFile.addEventListener('change', function(){
			let productoId = document.querySelector("#idproducto").value;
			let parentId = this.parentNode.getAttribute("id");
			let idFile = this.getAttribute("id");
			let uploadPhoto = document.querySelector("#"+idFile).value;
			let filePhoto = document.querySelector("#"+idFile).files;
			let prevImage = document.querySelector("#"+parentId+" .prevImage");
			let nav = window.URL || window.webkitURL;
			console.log("productoId: ", productoId);
			console.log("parentId: ", parentId);
			console.log("idFile: ", idFile);
			console.log("uploadPhoto: ", uploadPhoto);
			console.log("filePhoto: ", filePhoto);
			console.log("prevImage: ", prevImage);
			console.log("nav: ", nav);

			if (uploadPhoto!=''){	
				let type = filePhoto[0].type;
				let name = filePhoto[0].name;

				if (type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png') {
					prevImage.innerHTML = 'Extension no permitida';
					uploadPhoto.value ="";
					return false;
				}else{
					let obj_url = nav.createObjectURL(this.files[0]);
					prevImage.innerHTML = `<img class="loading" src="${base_url}/Assets/image/Blocks.svg">`;
					let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
					let ajaxUrl = base_url+'/Productos/setImage';
					let formData = new FormData();
					formData.append("idproducto",productoId );
					formData.append("photo",this.files[0] );
					request.open("POST", ajaxUrl, true);
					request.send(formData);
					request.onreadystatechange = function() {
						if (request.readyState!=4) return;
						if (request.status == 200) {
							let objData = JSON.parse(request.responseText);
							if (objData.status) {
								prevImage.innerHTML = `<img src="${obj_url}">`;
								document.querySelector("#"+parentId+" .btnDeleteImage").setAttribute("imgname",objData.imgname);
								document.querySelector("#"+parentId+" .btnUploadFile").classList.add("notBlock")
								document.querySelector("#"+parentId+" .btnDeleteImage").classList.remove("notBlock");								
							}else{

							}
						}
					}
				} //type format end

			}

		})//change event
	})//foreach
}

function fntDelItem(element){
	let image = document.querySelector(element+" .btnDeleteImage").getAttribute("imgname");	
	console.log("element: "+element);
	console.log("image: "+image);
	let idProducto = document.querySelector("#idproducto").value;
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
	let ajaxurl = base_url+'/Productos/delImg';
	let formData = new FormData();
	formData.append("idproducto", idProducto);
	formData.append("file", image);
	request.open("POST",ajaxurl,true);
	request.send(formData);

	request.onreadystatechange = function(){
		if (request.readyState !=4) return;
		if (request.status == 200) {
			let objData = JSON.parse(request.responseText);
			if (objData.status) {
				let elementRemove = document.querySelector(element);
				elementRemove.parentNode.removeChild(elementRemove);
			}else{
				swal("Error", objData.msg, "error");
			}
		}
	}
	
}



function fntViewProducto(idprod){
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
	var ajaxUrl = base_url+'/Productos/getProducto/'+idprod;
	request.open("GET",ajaxUrl,true);
	request.send();
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			var Datos = JSON.parse(request.responseText);
			let imagen = Datos.data.imagen;				
			if(Datos.status){
				var bdgeStatus = Datos.data.status == 1 ? '<span class="badge badge-primary">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>';
				$("#intICodigo").text(Datos.data.codigo);
				$("#txtNombre").text(Datos.data.nombre);
				$("#intPrecio").text(Datos.data.precio);
				$("#txtCategoria").text(Datos.data.nombrecategoria);
				$("#intStock").text(Datos.data.stock);				
				document.querySelector('#txtDescripcion').innerHTML = Datos.data.descripcion;			
				console.log("---->>>> ",Datos.data);
				if(typeof imagen !== 'undefined') {
					let img = '';
					for (var i = 0; i<imagen.length; i++) {
						img+='<img src="'+ imagen[i]['pathimg']+'" alt="">';
					}

					document.querySelector('#fileFotoReferencia').innerHTML = img;
				}else{
					document.querySelector('#fileFotoReferencia').innerHTML = '';
				}
				document.querySelector('#intEstado').innerHTML = bdgeStatus;
				// document.querySelector('#fecha_registro').innerHTML = Datos.data.fecha_crea;
				$("#modalViewProducto").modal('show');
			}else{
				swal("Error", Datos.msg, "error");
			}
		}
	}
}

function fntEditProducto(element,idprod){
	rowTable = element.parentNode.parentNode.parentNode;
	console.log("Elemento: ", element);
	console.log("rowTable: ", rowTable);
	document.querySelector('#titleModal').innerHTML = 'Actualizar Producto';
	document.querySelector('#btnText').innerHTML = 'Actualizar';
	document.querySelector('.modal-header').classList.replace('headerRegister', 'headerUpdate');	
	document.querySelector('#btnActionForm').classList.replace('btn-info', 'headerUpdate');	
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
	let ajaxurl = base_url+'/Productos/getProducto/'+idprod;			
	request.open("GET",ajaxurl,true);
	request.send();

		request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){				
			let Datos = JSON.parse(request.responseText);
			let imagen = Datos.data.imagen;
			if(Datos.status){
				console.log(Datos);
				document.querySelector('#idproducto').value = Datos.data.id;
				document.querySelector('#strNombreProducto').value = Datos.data.nombre;
				document.querySelector('#txtCodigoProducto').value = Datos.data.codigo;				
				tinymce.get('txtDescripcionProducto').setContent(Datos.data.descripcion);
				document.querySelector("#intPrecioProducto").value=Datos.data.precio;
				document.querySelector("#intStockProducto").value=Datos.data.stock;
				document.querySelector("#listCategoriaProducto").value=Datos.data.idcategoria;
				document.querySelector("#listStatusProducto").value=Datos.data.status;
				$("#listCategoriaProducto").selectpicker('render');
				$("#listStatusProducto").selectpicker('render');
				fntBarCode(Datos.data.codigo);

				if (document.querySelector("#divBarCode").classList.contains("notBlock")) {
						document.querySelector("#divBarCode").classList.remove("notBlock")
				}

				let htmlImg='';
				if(typeof imagen !== 'undefined') {		
					for (var i = 0; i<imagen.length; i++) {						
						let divId = "div"+Date.now()+i;						
						htmlImg+= `
											<div id="${divId}">
												<div class="prevImage"><img src="${imagen[i]['pathimg']}" alt=""></div>	                      
	                      <button type="button" class="btnDeleteImage" onclick="fntDelItem('#${divId}');" imgname="${imagen[i].imagen}">
	                      <i class="far fa-trash-alt"></i></button>
                      </div>`;                      
                    }
            document.querySelector("#containerImages").innerHTML = htmlImg;
				}else{
					document.querySelector('#containerImages').innerHTML = '';
				}
			}	
		}
	}
	$('#productoFormModal').modal('show');
}

function fntDeleteProducto(idprod){	
	swal({
		title: 'Eliminar producto',
		text: '¿Desea eliminar el producto?',
		type: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Si, eliminar',
		cancelButtonText: 'No, cancelar',
		closeOnConfirm: false,
		closeOnCanel: true
	}, function(isConfirm){
		if(isConfirm){
			let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsft.XMLHTTP');
			let ajaxurl = base_url+'/Productos/delProducto';	
			let strData = "idProducto="+idprod;
			request.open("POST",ajaxurl,true);
			request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			request.send(strData);
			request.onreadystatechange = function(){
				if(request.readyState == 4 && request.status == 200){				
					let Datos = JSON.parse(request.responseText);
					console.log("Datos Delete Producto: ", Datos);
					if(Datos.status){
						swal('Eliminar',Datos.msg,'success');								
						tblProductos.ajax.reload();											
					}else{
						swal('Atencion!',Datos.msg,'error');
					}
				}
			}

		}

	})
}

 function fntSelectCategorias(){
  if (document.querySelector("#listCategoriaProducto")) {
    let ajaxUrl = base_url+"/Categorias/getSelectCategorias";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
      if (request.readyState == 4 && request.status == 200) {
        document.querySelector("#listCategoriaProducto").innerHTML = request.responseText;
        $("#listCategoriaProducto").selectpicker();        
      }      
    }
  }
 }

 function fntBarCode(codigo){  
  JsBarcode("#barcode", codigo);
 }

 function fntPrintBarCode(area){   
   let elementArea = document.querySelector(area);
   let vprint = window.open('  ','MyWindow', 'height=400,width=600');
   vprint.document.write(elementArea.innerHTML);
   vprint.document.close;
   vprint.print();
   vprint.close();
 }


function openModal(){
	rowTable="";	
	document.querySelector('#idproducto').value = '';
	document.querySelector('#titleModal').innerHTML = 'Ingresa un nuevo producto';
	document.querySelector('#btnText').innerHTML = 'Guardar';
	// document.querySelector('.modal-header').classList.replace('headerRegister', 'headerRegister');
	let head = document.querySelector('.modal-header').classList;
	head.replace('headerUpdate', 'headerRegister');
	document.querySelector('#btnActionForm').classList.replace('btn-info', 'btn-primary');
	document.querySelector('#productoForm').reset();	
	document.querySelector("#divBarCode").classList.add('notBlock');
	document.querySelector(".containerGallery").classList.add('notBlock');
	document.querySelector("#containerImages").innerHTML="";
	$('#productoFormModal').modal('show');
	
}