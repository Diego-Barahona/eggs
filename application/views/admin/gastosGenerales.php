<div id="content-wrapper">
  <div class="container-fluid mb-5">

    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Gastos Comercial Ceballos de la Carrera .</li>
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
          En esta sección podrá agregar y editar gastos de la empresa.
          </div>
        </div>
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-table"></i>
        Lista de Gastos
        <button class="btn btn-success float-right" type='button' data-toggle="modal" id="btn" data-target="#modal_gastos"><i class="fas fa-plus"></i> agregar Gastos</button>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="list_gastos" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>idGasto</th>
                <th>nombre Gasto</th>
                <th>Costo Monetario $</th>
                <th>Editar</th>
                <th>Eliminar</th>
                </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
    <div class="row mb-3"></div>
    <div>
    <!-- Modal Agregar y Editar Gasto -->
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_gastos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo">Crear Gasto</h5>
                    <button type="button" class="close" onclick="close_modal_gastos()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form>
                

                    <div class="form-group" id="frm_nomGastoGeneral">
                        <label>Nombre del Gasto</label>
                        <input type="text" class="form-control" id="nomGastoGeneral" name="nomGastoGeneral" placeholder="Ingrese nombre del Gasto">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group" id="frm_costoMonetarioGeneral" > 
                        <label>Costo Monetario</label> 
                        <input type="text" class="form-control"  id="costoMonetarioGeneral" name="CostoMonetarioGeneral" placeholder="Ingrese el costo en $">
                        <div class="invalid-feedback"></div>
                    </div>
                    
                                     

                    


                    <div class="form-group float-right">
                        <button onclick="close_modal_gastos()" type="button" class="btn btn-secondary btn-danger">Cerrar</button>
                        <button id="btn_ok" type="button" class="btn btn-primary btn-success">Crear Gasto</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>


<script src="<?php echo base_url(); ?>assets/js_admin/gastos.js"></script>