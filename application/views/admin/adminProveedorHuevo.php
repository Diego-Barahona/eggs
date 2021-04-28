<div id="content-wrapper">
  <div class="container-fluid mb-5">

    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Proveedor de huevos.</li>
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
          En esta sección se mostrara los proveedores de Huevos de la empresa.
          </div>
        </div>
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-table"></i>
        Lista de usuarios 
        <button class="btn btn-success float-right" type='button' data-toggle="modal" id="btn" data-target="#modal_proveedorHuevo"><i class="fas fa-plus"></i> Agregar Precio</button>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="list_proveedorHuevo" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Nombre Proveedor</th>
                <th>Tipo de Huevo</th>
                <th>Precio unidad (Caja)</th>
                <th>Editar</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Agregar precio -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_proveedorHuevo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo">Agregar Precio</h5>
                <button type="button" class="close" onclick="close_modal_proveedorHuevo()" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <form>
                  <div class="form-group" id="frm_id">
                      <label>id</label>
                      <input type="number" class="form-control" id="id" name="id" readonly>
                      <div class="invalid-feedback"></div>
                  </div>
                  <!-- <div class="form-group" id="frm_nomProveedor" > 
                      <label>nom</label> 
                      <input type="password" class="form-control"  id="passwd" name="passwd" placeholder="Ingrese contraseña">
                      <div class="invalid-feedback"></div>
                  </div>
                  <div class="form-group" id="frm_full_name">
                      <label>Nombre Completo</label>
                      <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Ingrese nombre">
                      <div class="invalid-feedback"></div>
                  </div>
                  <div class="form-group" id="frm_email"> 
                      <label>Correo electrónico</label> 
                      <input type="email" class="form-control"  id="email" name="email" placeholder="Ingrese correo electrónico" >
                      <div class="invalid-feedback"></div>
                  </div>                 
                  <div class="form-group" id="frm_range">
                      <label>Nivel de usuario</label>
                      <select class="form-select form-control" id="range" name="range" >
                          <option></option>
                      </select>
                      <div class="invalid-feedback"></div>
                  </div>
                  <div class="form-group" id="frm_state" style="display: none">
                      <label>Estado</label>
                      <input type="text" class="form-control" id="state" name="state" readonly>
                  </div> -->
                  <div class="form-group float-right">
                      <button onclick="close_modal_proveedorHuevo()" type="button" class="btn btn-secondary btn-danger">Cerrar</button>
                      <button id="btn_ok" type="button" class="btn btn-primary btn-success">Agregar Precio</button>
                  </div>
              </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js_admin/proveedorHuevo.js"></script>
