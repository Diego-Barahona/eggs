<div id="content-wrapper">
  <div class="container-fluid mb-5">

    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Producto / Administrador de huevos</li>
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
           En esta sección gestionar el ingreso de nuevos productos (huevos) y llevar el control de precios por cliente.
          </div>
        </div>
      </div>
    </div>
    <div class="accordion" id="accordionExample">
      <div class="card mb-3">
      <div class="card-header" id="headingOne">
      <div style="padding-right: 40px">
      <button class="btn btn-success float-right" type='button' data-toggle="modal"  id="register_eggs"><i class="fas fa-plus"></i> Registrar Huevo </button>
    </div>
      </div>
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-table"></i>
        Lista de productos
      </div>
      <div class="card-body">
      <div class="table-responsive">
          <table class="table table-bordered" id="table-eggs" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Producto</th>
                <th>Tipo </th>
                <th>stock</th>
                <th>Estado</th>
                <th>Editar</th>
                <th>Precios</th>
                <th>Des/Habilitar</th>
              </tr>
            </thead>
          </table>
        </div>

      </div>
    </div>
   
    <div class="row mb-3"></div>

  </div>
</div>

<div class="modal fade bd-example-modal-lg" id="modal_eggs" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title">Registrar nuevo</h5>
        <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm">
            <p id="UserModalInfo"></p>
          </div>
        </div>
      
        <div class="form-group">
        
        <form>
            <input type="hidden" class="form-control" id="id" name="id" >
            <div class="form-group" id="frm_tipoHuevo">
                <label>Tipo de huevo</label>
                <input type="text" class="form-control" id="tipoHuevo" name="tipoHuevo" placeholder="Ingrese nombre">
                 <div class="invalid-feedback"></div>
            </div>
            <div class="form-group" id="frm_stock">
                <label>Stock</label>
                <input type="number" class="form-control" id="stock" min="1" pattern="^[0-9]+" name="stock" placeholder="Ingrese nombre">
                 <div class="invalid-feedback"></div>
            </div>
            <div class="form-group float-right">
            <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" id="createEgg" class="btn btn-primary">Guardar</button>
           </div>

        </form>
      </div>
         </div>
    </div>
  </div>
</div>


<div class="modal fade bd-example-modal-lg" id="modal_eggs_client" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitlewrwerwr" >
  <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title2"></h5>
        <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm">
            <p id="UserModalInfo"></p>
          </div>
        </div>
      
        <div class="form-group">
        <form>
        <div class="row" >
            <input type="hidden" class="form-control" id="id2" name="id2" >
            
            <div class="form-group col-md-6" id="frm_client">
                        <label for="activities">Cliente</label>
                        <select class="form-select form-control" id="client" name="client" placeholder="Seleccione cliente" >
                            <option></option>
                        </select>
                        <div class="invalid-feedback"></div>
            </div>
            
            <div class="form-group col-md-6" id="frm_precio">
            <label for="activities">Precio</label>
                <input type="number" class="form-control" id="precio" min="1" pattern="^[0-9]+" name="precio" placeholder="Precio">
                 <div class="invalid-feedback"></div>
            </div>
          </div>
            <div class="form-group float-right">
            <button type="button" id="close2" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" id="createEggClient" class="btn btn-primary">Guardar</button>
           </div>
        
      </form>
      </div>
  

        <div class="table-responsive">
          <table class="table table-bordered" id="table-eggs-client" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Nombre cliente</th>
                <th>Precio</th>
                <th>Acciones</th>
              </tr>
            </thead>
          </table>
        </div>

        </div>
  </div>
</div>
</div>

<script src="<?php echo base_url(); ?>assets/js_admin/adminEggs.js"></script>