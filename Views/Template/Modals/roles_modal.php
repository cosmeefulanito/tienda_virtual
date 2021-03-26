<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="modalFormRol" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ingresa un nuevo rol</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="nombre_rol">Nombre</label>
            <input class="form-control" id="nombre_rol" type="text" aria-describedby="emailHelp" placeholder="Enter email" required="">
          </div>
          <div class="form-group">
            <label for="descripcion_rol">Descripcion</label>
            <input class="form-control" id="descripcion_rol" type="text" aria-describedby="emailHelp" placeholder="" required="">
          </div>
          <div class="form-group">
            <label for="exampleSelect1">Estado</label>
            <select class="form-control" id="exampleSelect1">
              <option value="1">Activo</option>
              <option value="0">Inactivo</option>              
            </select>
          </div>          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>