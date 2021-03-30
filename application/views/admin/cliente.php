<div id="content-wrapper">
  <div class="container-fluid mb-5">

    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Clientes Comercial Ceballos de la Carrera .</li>
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
          En esta sección podrá agregar y editar y  clientes de la empresa.
          </div>
        </div>
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-table"></i>
        Lista de Clientes 
        <button class="btn btn-success float-right" type='button' data-toggle="modal" id="btn" data-target="#modal_cliente"><i class="fas fa-plus"></i> agregar Cliente</button>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="list_clientes" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Nombre Cliente</th>
                <th>Rut Cliente</th>
                <th>Sector</th>
                <th>nombre Calle</th>
                <th>numero Calle</th>
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
    <!-- Modal Agregar y Editar Empresa -->
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_cliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo">Crear cliente</h5>
                    <button type="button" class="close" onclick="close_modal_cliente()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form>
                    <div class="form-group" id="frm_nomCliente">
                        <label>Nombre Cliente</label>
                        <input type="text" class="form-control" id="nomCliente" name="nomCliente" placeholder="Ingrese nombre Cliente">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group" id="frm_rutCliente" > 
                        <label>Rut Cliente</label> 
                        <input type="text" class="form-control"  id="rutCliente" name="rutCliente" placeholder="Ingrese rutCliente">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group" id="frm_sector">
                        <label>Sector </label>
                        <input type="text" class="form-control" id="sector" name="sector" placeholder="Ingrese sector">
                        <div class="invalid-feedback"></div>
                    </div>
                    
                   
                    <div class="form-group" id="frm_nombreCalle"> 
                        <label>Nombre Calle</label> 
                        <input type="text" class="form-control"  id="nombreCalle" name="nombreCalle" placeholder="nombre de la calle" >
                        <div class="invalid-feedback"></div>
                    </div>  
                    <div class="form-group" id="frm_numCalle"> 
                        <label>Numero de calle </label> 
                        <input type="text" class="form-control"  id="numCalle" name="numCalle" placeholder="Ingrese numero de casa" >
                        <div class="invalid-feedback"></div>
                    </div>    

                     <div class="form-group" id="frm_state" style="display: none">
                        <label>Estado</label>
                        <input type="text" class="form-control" id="state" name="state" readonly>
                    </div>


                    <div class="form-group float-right">
                        <button onclick="close_modal_cliente()" type="button" class="btn btn-secondary btn-danger">Cerrar</button>
                        <button id="btn_ok" type="button" class="btn btn-primary btn-success">Crear cliente</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>


<script src="<?php echo base_url(); ?>assets/js/rut.js"></script>
<script src="<?php echo base_url(); ?>assets/js_admin/clientes.js"></script>