<div id="content-wrapper">
  <div class="container-fluid mb-5">

    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Proveedores Comercial Ceballos de la Carrera .</li>
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
          En esta sección podrá agregar , editar y deshabilitar Proveedores de la empresa.
          </div>
        </div>
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-table"></i>
        Lista de Proveedores 
        <button class="btn btn-success float-right" type='button' data-toggle="modal" id="btn" data-target="#modal_proveedor"><i class="fas fa-plus"></i> agregar Proveedor</button>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="list_proveedor" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre Proveedor</th>
                <th>Rut </th>
                <th>Telefono</th>
                <th>Correo</th>
                <th>Producto</th>
                <th>estado</th>
                <th>Editar</th>
                <th>Des/Habilitar</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
    <div class="row mb-3"></div>
    <div>
    <!-- Modal Agregar y Editar Proveedor -->
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_proveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo">Crear Proveedor</h5>
                    <button type="button" class="close" onclick="close_modal_proveedor()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form>
                    <div class="form-group" id="frm_nomCliente">
                        <label>Nombre Proveedor</label>
                        <input type="text" class="form-control" id="nomProveedor" name="nomProveedor" placeholder="Ingrese nombre del Proveedor">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group" id="frm_rutProveedor" > 
                        <label>Rut Proveedor</label> 
                        <input type="text" class="form-control"  id="rutProveedor" name="rutProveedor" placeholder="Ingrese rutProveedor">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group" id="frm_telefono">
                        <label>Telefono </label>
                        <input type="number" class="form-control" id="telefono" name="telefono" placeholder="Ingrese telefono">
                        <div class="invalid-feedback"></div>
                    </div>
                    
                   
                    <div class="form-group" id="frm_correoProveedor"> 
                        <label>Correo electronico</label> 
                        <input type="text" class="form-control"  id="correoProveedor" name="correo Proveedor" placeholder="Ingrese correo electronico" >
                        <div class="invalid-feedback"></div>
                    </div>  
                    <div class="form-group" id="frm_codProducto"> 
                        <label>Producto </label> 
                        <select name=" codProducto " id="codProducto" placeholder="Ingrese producto ">
                        <option name='Huevos' value="1">Huevos</option>
                        <option name='Cigarros' value="2">Cigarros</option>
                        <!-- <input type="text" class="form-control"  id="codProducto" name="codProducto" placeholder="Ingrese producto " > -->
                        <div class="invalid-feedback"></div>
                    </div>    

                     <div class="form-group" id="frm_state" style="display: none">
                        <label>Estado</label>
                        <input type="text" class="form-control" id="state" name="state" readonly>
                    </div>


                    <div class="form-group float-right">
                        <button onclick="close_modal_proveedor()" type="button" class="btn btn-secondary btn-danger">Cerrar</button>
                        <button id="btn_ok" type="button" class="btn btn-primary btn-success">Crear Proveedor</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>


<script src="<?php echo base_url(); ?>assets/js/rut.js"></script>
<script src="<?php echo base_url(); ?>assets/js_admin/proveedor.js"></script>