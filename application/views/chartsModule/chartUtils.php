<div id="content-wrapper">
  <div class="container-fluid mb-5">

    <ol class="breadcrumb">
      <li class="breadcrumb-item active" id="header-title">Información de utilidades</li>
    </ol>
    
    
    <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-table"></i>
        Indicadores de utilidades
      </div>
      <div class="card-body">

              <div class="row">
                  
                    <div class="col-md-3 mb-3" id="frm_priority">
                        <label for="actividad">Periodos</label>
                        <select class="custom-select d-block w-100" id="periodo" name="priority" required="">
                            <option></option>
                            <option value="1">ANUAL</option>
                            <option value="2">MENSUAL</option>
                            <option value="3">DIARIO</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div> <!-- fin class col-->

                    <div class="col-md-3 mb-3" id="frm_month" >
                        <label for="actividad">Mes</label>
                        <select class="custom-select d-block w-100" id="month" name="priority" required="">
                            <option></option>
                            <option value="1">Enero</option>
                            <option value="2">Febrero</option>
                            <option value="3">Marzo</option>
                            <option value="4">Abril</option>
                            <option value="5">Mayo</option>
                            <option value="6">Junio</option>
                            <option value="7">Julio</option>
                            <option value="8">Agosto</option>
                            <option value="9">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Noviembre</option>

                        </select>
                        <div class="invalid-feedback"></div>
                    </div> <!-- fin class col-->
                    <div class="col-md-3 mb-3" id="frm_year" >
                        <label for="actividad">Año</label>
                        <select class="custom-select d-block w-100" id="year" name="year" required="">
                            <option></option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-md-3 mb-2 mt-4"> 
                          <button type="button" id="btn_generate" class="btn btn-primary"><i class="fas fa-search"></i> Examinar  </button>
                    </div> 
               </div>

               <div class="row justify-content-end" id="content-graphic"><!-- ghrapic-->
                    <div class="col-md-6 mb-3 text-align:center;" >
                        <div id="barcolumn" style="width:450px ;height:400px"></div>
                    </div>

                    <div class="col-md-6  mb-3 text-align:center;" >
                         <div id="piechart"  style="width:500px ;height:480px"></div>
                    </div>
                </div>
                <div class="row " id="alert"><!-- ghrapic-->
                    <div class="col-md-12  mb-3 " >
                        <div class="alert alert-info" role="alert">
                            No hay utilidades registradas en los periódos consultados.
                       </div>
                    </div>
              </div>

               

      <div class="table-responsive">
          <table class="table table-bordered" id="table-utilidades" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Fecha</th>
                <th>Codigo Venta </th>
                <th>Monto recaudado</th>
                <th>Acción</th>
              </tr>
            </thead>
          </table>
        </div> <!-- class responsive-->

      </div>
    </div>
    <div class="row mb-3"></div>
  </div>
</div>

<script src="<?php echo base_url(); ?>assets/js_admin/chartUtils.js"></script>