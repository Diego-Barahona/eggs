<div id="content-wrapper">
  <div class="container-fluid mb-5">

    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Caja / Administración de Costos </li>
    </ol>

    <div class="accordion" id="accordionExample">
      <div class="card mb-3">
        <div class="card-header" id="headingOne">
          <h2 class="mb-0">
            <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              INSTRUCCIONES
            </button>
          </h2>
        </div>

        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
          <div class="card-body">
           En esta sección podrás administrar los diferentes costos de la empresa, especialmente los que tienen relación con compras a proveedores para el manejo de stock de productos.
          </div>
        </div>
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-table"></i>
        Lista de costos 
        <button class="btn btn-success float-right" type='button' data-toggle="modal" id="btn_modal_register" data-target="#modalCigar"><i class="fas fa-plus"></i> Registrar costo</button>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="table-cost" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Codigo</th>
                <th>Proveedor</th>
                <th>Fecha</th>
                <th>Costo total</th>
                <th>Editar</th>
                <th>Ver productos</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
    <div class="row mb-3"></div>
</div>
</div>

    
<div class="modal fade bd-example-modal-lg" id="registerCost" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title">Registrar nuevo costo</h5>
        <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <div class="row mb-2 ">
                <input type="hidden" class="form-control" id="categoria" >
             
                 <div class="col-md-4">
                      <label for="activities">Código factura</label>
                       <input type="text" class="form-control" id="codeCost" placeholder="Código de factura"  >
                        <div class="invalid-feedback"></div>
                    
                </div>
                
                <div class="col-md-4  ">
                <label for="activities">Proveedor</label>
                            <select class="custom-select d-block w-100" name="select" id='proveedor'>
                                <option value=""></option>
                      
                                    </select>
                </div>
                
                <div class="col-md-4">
                <label for="activities">Fecha de compra</label>
                <input type="text" class="form-control" id="dateCost" name="fecha" placeholder="Fecha">
                 <div class="invalid-feedback"></div>
                </div>
               
          </div>
          
          
          <div class="card mb-3">
                <div class="card-header">
                     <i class="fas fa-table"></i>
                  Agregar compras
          </div>
           <div class="card-body">
                <div id="contCosto">
                <div class="row mb-3 " id="rowCosto_1">
                        
                               <input type="hidden" class="form-control" id="categoria_1" >
                                <div class="col-md-3">
                                <label for="activities">Producto</label>
                                <select class="custom-select d-block w-100" name="select" id='producto_1'>
                                      
                                    </select>
                                </div>
                        
                        <div class="col-md-3">
                        <label for="activities">Precio </label>
                            <input type="number" class="form-control" id="valorinsumos_1" style="background:white" min="1" pattern="^[0-9]+" placeholder="valor" aria-describedby="inputGroupPrepend3" disabled>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                <label for="activities">Cantidad unidades</label>
                                    <input type="number" min="0" class="form-control" id="cantinsumos_1"  min="0" pattern="^[0-9]+" placeholder="cantidad" aria-describedby="inputGroupPrepend3" onchange="changeTotalCostos(this)">
                                </div>
                                <div class="col-md-6">
                                <label for="activities">Total</label>
                                    <input type="text" class="form-control" id="totalinsumos_1" placeholder="Total" aria-describedby="inputGroupPrepend3" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-end mb-3">
                    <div class="col-md-2 align-items-end">
                        <input type="text" class="form-control" id="costoTotal" placeholder="Total" aria-describedby="inputGroupPrepend3" disabled>
                    </div>
                    <div class="col-md-4  align-items-end">
                        <button class="btn btn-primary float-right" type='button' id="tr_btn_add"><i class="fas fa-plus"></i> Añadir costo</button>
                    </div>
                    <div class="col-md-4  align-items-end">
                        <button class="btn btn-danger float-right" type='button' id="removerCosto"><i class="fas fa-times"></i> Eliminar costo</button>
                    </div>
                </div>

              </div> <!-- card-body end -->
            </div>
       
    
            <div class="form-group float-right">
            <button type="button" id="close2" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" id="btn_register_cost" class="btn btn-primary">Guardar</button>
           </div>
      
     
  
    
      </div>
    </div>
  </div>
</div>



<div class="modal fade bd-example-modal-lg" id="modalShowCost" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title">Registrar nuevo</h5>
        <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="card mb-3">

      <div class="card-header">
        <i class="fas fa-table"></i>
         Lista de compras 
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="table-compras" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Categoría producto</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Valor</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>




      </div>
    </div>
  </div>
</div>




<div class="modal fade bd-example-modal-lg" id="costEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title">Editar compras </h5>
        <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <div class="row mb-2 ">
                <input type="hidden" class="form-control" id="categoria_edit" >
             
                 <div class="col-md-4">
                      <label for="activities">Código factura</label>
                       <input type="text" class="form-control" style="background:white" id="codeCost_edit" placeholder="Código de factura"  disabled>
                        <div class="invalid-feedback"></div>
                    
                </div>
                
                <div class="col-md-4  ">
                <label for="activities">Proveedor</label>
                            <select class="custom-select d-block w-100" name="select" id='proveedor_edit'>
                                <option value=""></option>
                      
                                    </select>
                </div>
                
                <div class="col-md-4">
                <label for="activities">Fecha de compra</label>
                <input type="text" class="form-control" id="dateCost_edit" name="fecha" placeholder="Fecha">
                 <div class="invalid-feedback"></div>
                </div>
               
          </div>
          
          
          <div class="card mb-3">
                <div class="card-header">
                     <i class="fas fa-table"></i>
                  Agregar compras
          </div>
           <div class="card-body">
                <div id="contCostoEdit">
                <div class="row mb-3 " id="rowCostoEdit_1">
                        
                               <input type="hidden" class="form-control" id="categoriaEdit_1" >
                                <div class="col-md-3">
                                <label for="activities">Producto</label>
                                <select class="custom-select d-block w-100" name="select" id='productoEdit_1'>
                                      
                                    </select>
                                </div>
                        
                        <div class="col-md-3">
                        <label for="activities">Precio </label>
                            <input type="number" class="form-control" id="valorinsumosEdit_1" style="background:white" min="1" pattern="^[0-9]+" placeholder="valor" aria-describedby="inputGroupPrepend3" disabled>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                <label for="activities">Cantidad unidades</label>
                                    <input type="number" min="0" class="form-control" id="cantinsumosEdit_1"  min="0" pattern="^[0-9]+" placeholder="cantidad" aria-describedby="inputGroupPrepend3" onchange="changeTotalCostosEdit(this)">
                                </div>
                                <div class="col-md-6">
                                <label for="activities">Total</label>
                                    <input type="text" class="form-control" id="totalinsumosEdit_1" placeholder="Total" aria-describedby="inputGroupPrepend3" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-end mb-3">
                    <div class="col-md-2 align-items-end">
                        <input type="text" class="form-control" id="costoTotal_Edit" placeholder="Total" aria-describedby="inputGroupPrepend3" disabled>
                    </div>
                    <div class="col-md-4  align-items-end">
                        <button class="btn btn-primary float-right" type='button' id="tr_btn_add_Edit"><i class="fas fa-plus"></i> Añadir costo</button>
                    </div>
                    <div class="col-md-4  align-items-end">
                        <button class="btn btn-danger float-right" type='button' id="removerCosto_Edit"><i class="fas fa-times"></i> Eliminar costo</button>
                    </div>
                </div>

              </div> <!-- card-body end -->
            </div>
       
    
            <div class="form-group float-right">
            <button type="button" id="close2" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" id="btn_Edit_cost" class="btn btn-primary">Guardar</button>
           </div>
      
     
  
    
      </div>
    </div>
  </div>
</div>


<script src="<?php echo base_url(); ?>assets/js_admin/adminCost.js"></script>

<script src="<?php echo base_url(); ?>assets/js_admin/adminCostEdit.js"></script>
