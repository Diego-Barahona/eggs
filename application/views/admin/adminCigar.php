<div id="content-wrapper">
  <div class="container-fluid mb-5">

    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Productos / Cigarrillos </li>
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
           En esta sección podrá crear, editar y deshabilitar/habilitar cigarillos.
          </div>
        </div>
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-table"></i>
        Lista de usuarios 
        <button class="btn btn-success float-right" type='button' data-toggle="modal" id="btn" data-target="#modalCigar"><i class="fas fa-plus"></i> Registrar Cigarro</button>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="listCigar" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Precio Venta</th>
                <th>Stock</th>
                <th>Estado</th>
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
    <!-- Modal Agregar y Editar Empresa -->
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalCigar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo">Registrar Cigarro</h5>
                    <button type="button" class="close" onclick="closeModalCigar()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form>
                    <div class="form-group" id="frmName">
                        <label>Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese Nombre">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group" id="frmPrice" > 
                        <label>Precio</label> 
                        <input type="number" min='0' class="form-control"  id="price" name="price" placeholder="Ingrese Precio de venta">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group" id="frmStock">
                        <label>Stock</label>
                        <input type="number" min='0' class="form-control" id="stock" name="stock" placeholder="Ingrese la cantidad disponible del nuevo producto">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group" id="frmState" style="display: none">
                        <label>Estado</label>
                        <input type="text" class="form-control" id="state" name="state" readonly>
                    </div>
                    <div class="form-group float-right">
                        <button onclick="closeModalCigar()" type="button" class="btn btn-secondary btn-danger">Cerrar</button>
                        <button id="btnOk" type="button" class="btn btn-primary btn-success">Crear Cigarro</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js_admin/cigar.js"></script>