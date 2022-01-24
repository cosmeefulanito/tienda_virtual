<div class="modal fade permisos-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Permisos roles de usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">        
        <div class="col-md-12">
          <div class="tile">            
            <form id="formPermisos" name="formPermisos" action="">
              <input type="hidden" name="idrol" id="idrol" value="<?= $data['idrol']; ?>">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                     <tr>
                      <th>#</th>
                      <th>Módulo</th>
                      <th>Leer</th>
                      <th>Escribir</th>
                      <th>Actualizar</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // dep($data);
                    $no=1;
                    $modulos = $data['modulos'];
                    for ($i=0; $i < count($modulos); $i++) { 
                      $permisos = $modulos[$i]['permisos'];
                      $Rcheck = $permisos['r'] == 1 ? " checked " : "" ;
                      $Wcheck = $permisos['w'] == 1 ? " checked " : "" ;
                      $Ucheck = $permisos['u'] == 1 ? " checked " : "" ;
                      $Dcheck = $permisos['d'] == 1 ? " checked " : "" ;
                      $idmodulo = $modulos[$i]['id'];
                    ?>
                    <tr>
                      <td>
                        <?= $no; ?>
                        <input type="hidden" name="modulos[<?= $i; ?>][id]" value="<?= $idmodulo; ?>">
                      </td>
                      <td>
                        <?= $modulos[$i]['titulo']; ?>
                      </td>
                      <td>
                      <div class="toggle-flip">
                        <label>
                          <input type="checkbox" name="modulos[<?=$i;?>][r]" <?= $Rcheck; ?> >
                          <span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                        </label>
                      </div>
                      </td>
                      <td>
                        <div class="toggle-flip">
                          <label>
                            <input type="checkbox" name="modulos[<?=$i;?>][w]" <?= $Wcheck; ?>>
                            <span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                          </label>
                        </div>
                      </td>
                      <td>
                        <div class="toggle-flip">
                          <label>
                            <input type="checkbox" name="modulos[<?=$i;?>][u]" <?= $Ucheck; ?>>
                            <span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                          </label>
                        </div>
                      </td>
                      <td>
                        <div class="toggle-flip">
                          <label>
                            <input type="checkbox" name="modulos[<?=$i;?>][d]" <?= $Dcheck; ?>>
                            <span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                          </label>
                        </div>
                      </td>
                    </tr>
                    <?php $no++;} ?>
                  </tbody>
                </table>
              </div>
              <div class="text-center">
                <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Guardar</button>
                <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Salir</button>
              </div>
            </form>
          </div>
        </div>
      </div>      
    </div>
  </div>
</div>

