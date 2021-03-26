$('#rolesTable').DataTable({
	// "aProcessing": true,
	// "aServerSide": true,
	// "responsive": true,
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


function openModal(){
	// alert("HOLA")	
	$("#modalFormRol").modal("show");	
}