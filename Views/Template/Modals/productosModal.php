<!-- Modal -->
<div class="modal fade" id="productoFormModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="productoForm" name="productoForm" class="form-horizontal">
              <input type="hidden" id="idproducto" name="idproducto" value="">
              <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
              <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                      <label class="control-label">Nombre producto<span class="required">*</span></label>
                      <input class="form-control validText" id="strNombreProducto" name="strNombreProducto" type="text" placeholder="Nombre producto" required="">
                    </div>
                    <div class="form-group">
                      <label class="control-label">Descripción producto</label>
                      <textarea class="form-control" id="txtDescripcionProducto" name="txtDescripcionProducto" rows="4"></textarea>
                    </div>                     
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Código <span class="required">*</span></label>
                        <input type="text" class="form-control validNumber" id="txtCodigoProducto" name="txtCodigoProducto" placeholder="934819" required="">
                        <br>
                        <div id="divBarCode" class="notBlock textcenter">
                          <div id="printCode">
                            <svg id="barcode"></svg>
                          </div>
                          <button type="button" class="btn btn-success btn-sm" onClick="fntPrintBarCode('#printCode')">Imprimir <i class="fas fa-print"></i></button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Precio<span class="required">*</span></label>
                                <input class="form-control validNumber" id="intPrecioProducto" name="intPrecioProducto" type="text" placeholder="$" required="">
                            </div>
                        </div>
                        <div class="col-md-6 form-group">                        
                            <label class="control-label">Stock <span class="required">*</span></label>
                            <input class="form-control validNumber" id="intStockProducto" name="intStockProducto" type="text"  required="">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="listCategoriaProducto" class="control-label">Categoria<span class="required">*</span></label>                                
                                <select class="form-control validText" id="listCategoriaProducto" name="listCategoriaProducto" required="" data-live-search="true"></select>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <div class="form-group">
                                <label for="listStatus">Estado <span class="required">*</span></label>
                                <select class="form-control selectpicker" id="listStatusProducto" name="listStatusProducto" required="">
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form group col-md-6">
                        <button id="btnActionForm" class="btn btn-primary btn-lg btn-block" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span>
                        </button>&nbsp;&nbsp;&nbsp;
                        </div>
                        
                        <div class="form group col-md-6">
                        <button class="btn btn-danger btn-lg btn-block" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
                        </div>

                    </div>
                    
                </div> <!--fin col-md-4 -->
              </div>
              
              <div class="tile-footer">
                <div class="form-group col-md-12">
                  <div class="containerGallery">
                    <span>Galería de fotos</span>
                    <button class="btnAddImage btn btn-info btn-sm" type="button"><i class="fas fa-plus"></i></button>
                  </div>
                  <hr>

                  <div id="containerImages">
                    <!-- <div id="div24">
                      <div class="prevImage"><img src="<?=media();?>/image/polera.jpg" alt=""></div>
                      <input type="file" id="img1" name="foto" class="inputUploadFile">
                      <label for="img1" class="btnUploadFile"><i class="fas fa-upload"></i></label>
                      <button type="button" class="btnDeleteImage" onclick="fntDelItem('div24');"><i class="far fa-trash-alt"></i></button>
                    </div>
                    <div id="div24">
                      <div class="prevImage"><img class="loading" src="<?=media();?>/image/Blocks.svg" alt=""></div>
                      <input type="file" id="img1" name="foto" class="inputUploadFile">
                      <label for="img1" class="btnUploadFile"><i class="fas fa-upload"></i></label>
                      <button type="button" class="btnDeleteImage" onclick="fntDelItem('div24');"><i class="far fa-trash-alt"></i></button>
                    </div> -->
                  </div>
                </div>                
              </div>
            </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewProducto" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" >
    <div class="modal-content">
      <div class="modal-header headerUpdate">
        <h5 class="modal-title" id="titleModal">Datos del producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Codigo:</td>
              <td id="intICodigo"></td>
            </tr>
            <tr>
              <td>Nombres:</td>
              <td id="txtNombre"></td>
            </tr>
            <tr>
              <td>Precio:</td>
              <td id="intPrecio"></td>
            </tr>
            <tr>
              <td>Stock:</td>
              <td id="intStock"></td>
            </tr>
            <tr>
              <td>Categoria:</td>
              <td id="txtCategoria"></td>
            </tr>
            <tr>
              <td>Estado:</td>
              <td id="intEstado"></td>
            </tr>
            <tr>
              <td>Descripcion:</td>
              <td id="txtDescripcion"></td>
            </tr>
            <tr>
              <td>Foto referencia:</td>
              <td id="fileFotoReferencia"></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

