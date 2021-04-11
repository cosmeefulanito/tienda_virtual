<!-- Modal -->
<div class="modal fade" id="modalFormRol" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Ingresa un nuevo rol</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="rolForm" name="rolForm">
        <input type="hidden" id="idrol" name="idrol" value="">
        <div class="modal-body">        
            <div class="form-group">
              <label for="nombre_rol">Nombre</label>
              <input class="form-control" id="nombre_rol" name="nombre_rol" type="text" aria-describedby="emailHelp" required="" autocomplete="off">
            </div>
            <div class="form-group">
              <label for="descripcion_rol">Descripcion</label>
              <input class="form-control" id="descripcion_rol" name="descripcion_rol" type="text" aria-describedby="emailHelp" required="" autocomplete="off">
            </div>
            <div class="form-group">
              <label for="estado">Estado</label>
              <select class="form-control" id="estado" name="estado">
                <option value="1">Activo</option>
                <option value="2">Inactivo</option>              
              </select>
            </div>        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-info" id="btnActionForm"><span id="btnText">Guardar</span></button>
        </div>
      </form>
    </div>
  </div>
</div>
