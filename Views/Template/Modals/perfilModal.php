<!-- Modal -->
<div class="modal fade" id="modalFormPerfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerUpdate">
        <h5 class="modal-title" id="titleModal">Actualizar datos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="perfilForm" name="perfilForm" class="form-horizontal">
	      <div class="modal-body">      			        
		        <p class="text-primary">Los campos con asterico (<span class="required">*</span>) son obligatorios</p>
		        <div class="form-row">
			        <div class="form-group col-md-6">
		              <label for="txt_rut">RUT <span class="required">*</span></label>
		              <input class="form-control valid validRut" id="txt_rut" name="txt_rut" type="text" required="" placeholder="XXXXXXXX-X" autocomplete="off" value="<?= $_SESSION['userSession']['identificacion']; ?>">
		            </div>		        	
		        </div>
		        <div class="form-row">
		        	<div class="form-group col-md-6">
		              <label for="txt_nombre">Nombre <span class="required">*</span></label>
		              <input class="form-control valid validText" id="txt_nombre" name="txt_nombre" type="text" required="" autocomplete="off" value="<?=$_SESSION['userSession']['nombres']; ?>">
		            </div>
		            <div class="form-group col-md-6">
		              <label for="txt_apellidos">Apellidos <span class="required">*</span></label>
		              <input class="form-control valid validText" id="txt_apellidos" name="txt_apellidos" type="text" required="" autocomplete="off" value="<?=$_SESSION['userSession']['apellidos']; ?>">
		            </div>
		        </div>
		        <div class="form-row">
		        	<div class="form-group col-md-6">
		              <label for="txt_telefono">Teléfono <span class="required">*</span></label>
		              <input class="form-control valid validNumber" id="txt_telefono" name="txt_telefono" type="text" required="" autocomplete="off" onkeypress="return controlTag(event);" value="<?= $_SESSION['userSession']['telefono']; ?>">
		            </div>
		            <div class="form-group col-md-6">
		              <label for="txt_email">E-mail</label>
		              <input class="form-control valid validEmail" id="txt_email" name="txt_email" type="text" required="" readonly disabled autocomplete="off" value="<?= $_SESSION['userSession']['email'];?>">
		            </div>
		        </div>
		        <div class="form-row">
		        	<div class="form-group col-md-6">
	              <label for="txt_password">Password</label>
	              <input class="form-control" id="txt_password" name="txt_password" type="password" autocomplete="off">
	            </div>
		        	<div class="form-group col-md-6">
	              <label for="txt_confirmPassword">Confirmar password</label>
	              <input class="form-control" id="txt_confirmPassword" name="txt_confirmPassword" type="password" autocomplete="off">
	            </div>
		        </div>     
	      </div>
	      <div class="modal-footer">        	
	      	<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i> Cancelar</button>
	      	<button type="submit" class="btn btn-info" id="btnActionForm"><i class="fas fa-check-circle"></i> <span id="btnText">Actualizar</span></button>
	      </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal view user -->
<!-- Modal -->
<div class="modal fade" id="ModalviewUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header header-view">
        <h5 class="modal-title" id="titleModal">Datos del usuario</h5>
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
					      <td>Rol:</td>
					      <td><span id="rol"></span></td>
					    </tr>
					    <tr>
					    	<td>Estado</td>
					    	<td id="estado"></td>
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
