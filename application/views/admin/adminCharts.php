<div id="content-wrapper">
  <div class="container-fluid mb-5">

    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Gráficos / Opciones de visualización</li>
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
           En esta sección se puede visualizar de manera organizada los indicadores por periodos de todos los parámetros relevantes del sistema , ejemplo: utilidades , gastos , montos de compra, entre otros , a través de gráficos.
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
          <table class="table table-bordered" id="table-charts" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Item </th>
                <th>Parámetro </th>
                <th>Acción</th>
              </tr>
            </thead>
          </table>
        </div>

      </div>
    </div>
   
    <div class="row mb-3"></div>

  </div>
</div>
<script src="<?php echo base_url(); ?>assets/js_admin/adminCharts.js"></script>