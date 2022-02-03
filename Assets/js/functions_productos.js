
let tblProductos;
$(document).ready(function () {});

document.write(`<script src="${base_url}/Assets/js/plugins/JsBarcode.all.min.js"></script>`);
if (document.querySelector('#txtCodigo')) {
  let inputCodigo = document.querySelector('#txtCodigo');

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
  
  tblProductos = $('#productosTable').DataTable({
		"language": {
			"url": base_url+"/Assets/js/plugins/Spanish.json"
		},
		"ajax": {
			"url": base_url+"/Productos/getProductos",
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

 function fntSelectCategorias(){
  if (document.querySelector("#listCategoria")) {
    let ajaxUrl = base_url+"/Categorias/getSelectCategorias";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function() {
      if (request.readyState == 4 && request.status == 200) {
        document.querySelector("#listCategoria").innerHTML = request.responseText;
        $("#listCategoria").selectpicker("render");        
      }      
    }
  }
 }

 function fntBarCode(codigo){
  // console.log("--> ", codigo)
  JsBarcode("#barcode", codigo);
 }

 function fntPrintBarCode(area){
   console.log("AREA: ", area)
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
	$('#productoFormModal').modal('show');
	// removePhoto();
}