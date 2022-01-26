<!-- Modal -->
<div class="modal fade" id="clienteFormModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="clienteForm" name="clienteForm" class="form-horizontal">
	      <div class="modal-body">      	
		        <input type="hidden" id="idusuario" name="idusuario" value="">
		        <p class="text-primary">Todos los campos (<span class="required">*</span>) son obligatorios</p>
		        <div class="form-row">
			        <div class="form-group col-md-3">
	              <label for="txt_rut">RUT<span class="required">*</span></label>
	              <input class="form-control valid validRut" id="txt_rut" name="txt_rut" type="text" required="" placeholder="XXXXXXXX-X" autocomplete="off">
	            </div>
	            <div class="form-group col-md-3">
	              <label for="txt_nombre">Nombres<span class="required">*</span></label>
	              <input class="form-control valid validText" id="txt_nombre" name="txt_nombre" type="text" required="" autocomplete="off">
	            </div>
	            <div class="form-group col-md-3">
	              <label for="txt_apellidos">Apellidos<span class="required">*</span></label>
	              <input class="form-control valid validText" id="txt_apellidos" name="txt_apellidos" type="text" required="" autocomplete="off">
	            </div>
	            <div class="form-group col-md-3">
	              <label for="txt_telefono">Teléfono<span class="required">*</span></label>
	              <input class="form-control valid validNumber" id="txt_telefono" name="txt_telefono" type="text" required="" autocomplete="off" onkeypress="return controlTag(event);">
	            </div>       	
		        </div>
		        <div class="form-row">
		        	<div class="form-group col-md-6">
	              <label for="txt_email">E-mail<span class="required">*</span></label>
	              <input class="form-control valid validEmail" id="txt_email" name="txt_email" type="text" required="" autocomplete="off">
	            </div>
		        	<div class="form-group col-md-6">
	              <label for="txt_password">Password</label>
	              <input class="form-control" id="txt_password" name="txt_password" type="password" autocomplete="off">
	            </div>
		        </div> 
		        <p class="text-primary">Datos empresa</p>
		        <div class="form-row">
		        	<div class="form-group col-md-4">
	              <label for="txt_rut_empresa">RUT<span class="required">*</span></label>
	              <input class="form-control valid validRut" id="txt_rut_empresa" name="txt_rut_empresa" type="text" required="" autocomplete="off">
	            </div>
		        	<div class="form-group col-md-4">
	              <label for="txt_razon_social">Razón social<span class="required">*</span></label>
	              <input class="form-control valid validText" id="txt_razon_social" name="txt_razon_social" type="text" required="" autocomplete="off">
	            </div>
		        	<div class="form-group col-md-4">
	              <label for="txt_nombre_fantasia">Nombre de fantasia<span class="required">*</span></label>
	              <input class="form-control valid validText" id="txt_nombre_fantasia" name="txt_nombre_fantasia" type="text" required="" autocomplete="off">
	            </div>
		        	<div class="form-group col-md-6">
	              <label for="txt_direccion_empresa">Direccion</label>
	              <input class="form-control" id="txt_direccion_empresa" name="txt_direccion_empresa" type="text" autocomplete="off">
	            </div>
		        	<!-- <div class="form-group col-md-6">
	              <label for="txt_telefono_empresa">Telefono</label>
	              <input class="form-control" id="txt_telefono_empresa" name="txt_telefono_empresa" type="text" autocomplete="off">
	            </div> -->
		        </div>    
	      </div>
	      <div class="modal-footer">        	
	      	<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i> Cancelar</button>
	      	<button type="submit" class="btn btn-info" id="btnActionForm"><i class="fas fa-check-circle"></i> <span id="btnText">Guardar</span></button>
	      </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal view user -->
<!-- Modal -->
<div class="modal fade" id="ModalviewCliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header header-view">
        <h5 class="modal-title" id="titleModal">Datos del cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>      
	      <div class="modal-body">
	      	<table class="table table-bordered">
					  <tbody>
					    <tr>
					      <td>RUT:</td>
					      <td><span id="identificacion"></span></td>					      
					    </tr>
					    <tr>
					      <td>Nombre:</td>
					      <td><span id="nombre"></span></td>
					    </tr>
					    <tr>
					      <td>Telefono:</td>
					      <td><span id="fono"></span></td>
					    </tr>
					    <tr>
					      <td>E-mail:</td>
					      <td><span id="email"></span></td>
					    </tr>
					    <tr>
					    	<td>RUT empresa</td>
					    	<td id="rut_empresa"></td>
					    </tr>
					    <tr>
					    	<td>Nombre empresa</td>
					    	<td id="nombre_empresa"></td>
					    </tr>
					    <tr>
					    	<td>Direccion empresa</td>
					    	<td id="direccion_empresa"></td>
					    </tr>					    
					    <tr>
					    	<td>Fecha registro</td>
					    	<td id="fecha_registro"></td>
					    </tr>
					  </tbody>
					</table>
	      </div>
	      <div class="modal-footer">        	
	      	<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times-circle"></i> Cerrar</button>
	      </div>      
    </div>
  </div>
</div>
