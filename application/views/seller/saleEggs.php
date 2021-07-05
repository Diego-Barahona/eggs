<div id="content-wrapper">
  <div class="container-fluid mb-5">

    <ol class="breadcrumb">
      <li class="breadcrumb-item active" id="header-title">Ventas de huevos</li>
    </ol>
    
    
    <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-table"></i>
       Información por períodos
      </div>
      <div class="card-body">
      
            <div class="row">
            <div class="col-md-2 mb-3" id="frm_priority">
                        <label for="actividad">Períodos</label>
                        <select class="custom-select d-block w-100" id="periodo" name="priority" required="">
                            <option></option>
                            <option value="1">Anual</option>
                            <option value="2">Mensual</option>
                            <option value="3">Diario</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div> 


            </div>

              <div class="row ml-2">

                   <div class="col-md-2 mb-3" id="frm_year" >
                        <label for="actividad">Año </label>
                        <select class="custom-select d-block w-100" id="year" name="year" required="">
                            <option></option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-md-2 mb-3" id="frm_month" >
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
                            <option value="12">Diciembre</option>
                             
                        </select>
                        <div class="invalid-feedback"></div>
                    </div> <!-- fin class col-->
                  

                    <div class="col-md-2 mb-3" id="frm_date1" >
                          <label for="activities">Fecha </label>
                          <input type="text" class="form-control" id="date1" name="fecha" placeholder="Ingrese fecha ">
                           <div class="invalid-feedback"></div>
                    </div>
                  
                    <div class="col-md-3 mb-2 mt-4" id="btn_periodo1"> 
                
                          <button type="button" id="btn_generate" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
               </div>

              <div class ="row justify-content-center" id="title_info1" >
 
               <h4> <i class="fa fa-th-large" style="font-size: 20px"></i><span>&nbsp; Consulta anual <span></h4> 
              
              </div>

              <div class ="row justify-content-center" id="title_info2" >
              
              <h4> <i class="fa fa-th-large" style="font-size: 20px"></i><span>&nbsp; Consulta mensual<span></h4> 
              
             </div>
             <div class ="row justify-content-center" id="title_info3" >
              
              <h4> <i class="fa fa-th-large" style="font-size: 20px"></i><span>&nbsp; Consulta diaria<span></h4> 
             
             </div>


              <br>

               
               <div class="row " id="content_info"><!-- ghrapic-->
               
                    
                    <div class="col-md-6 mb-3 text-align:center;"id="info_ano" >
                    <label for="activities">Año consultado: </label>
                          <input type="text" class="form-control" id="tiempo_anual" style="background-color:white" name="fecha" disabled>
                    </div>
                    <div class="col-md-6 mb-3 text-align:center;" id="info_mes">
                    <label for="activities">Mes consultado:  </label>
                          <input type="text" class="form-control" id="tiempo_mensual" style="background-color:white" name="fecha" disabled>
                    </div>
                    <div class="col-md-6 mb-3 text-align:center;" id="info_dia">
                    <label for="activities">Fecha específica:  </label>
                          <input type="text" class="form-control" id="tiempo_dia" style="background-color:white" name="fecha" disabled>
                    </div>
                    <div class="col-md-6 mb-3 text-align:center;" >
                          <label for="activities">Cantidad total de ventas:  </label>
                          <input type="text" class="form-control" id="cantidad_total" style="background-color:white" name="fecha" disabled>
                    </div>
                    <div class="col-md-6  mb-3 text-align:center;" >
                             <label for="activities">Monto total de ventas : </label>
                    <input type="text" class="form-control" id="suma_total"style="background-color:white" name="fecha" disabled>
                    </div>
                </div>

                
                <div class="row " id="alert"><!-- ghrapic-->
                    <div class="col-md-12  mb-3 " >
                        <div class="alert alert-info" role="alert">
                            No hay utilidades registradas en los periódos consultados.
                       </div>
                    </div>
              </div>

            <br>
      <div class="table-responsive">
          <table class="table table-bordered" id="table-utilidades" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Fecha</th>
                <th>Código Venta </th>
                <th>Monto recaudado</th>
                <th>Acción</th>
              </tr>
            </thead>
          </table>
        </div> <!-- class responsive-->
       
        
    </div>
  </div>
</div>
</div>



<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_ventah" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo">Detalles de la venta</h5>
                <button type="button" class="close" onclick="close_modal_proveedorCigarro()" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <form>
                 <div class="form-group" id="frm_range">
                      <label>Fecha del gasto</label>
                      <input type="text" class="form-control"  id="modal_fecha" name="modal_fecha" disabled>
                      <div class="invalid-feedback"></div>
                  </div>
                 
                  <div class="form-group" id="frm_range">
                      <label>Código</label>
                      <input type="text" class="form-control" id="modal_codigo" name="modal_codigo"disabled>
                      <div class="invalid-feedback"></div>
                  </div>
                
                  <div class="form-group" id="frm_range">
                      <label>Rut cliente </label>
                      <input type="text" class="form-control" id="modal_cliente" name="modal_cliente" disabled>
                      <div class="invalid-feedback"></div>
                  </div> 
               
                  <div class="form-group" id="frm_precio">
                      <label>Total venta</label>
                      <input type="text" class="form-control" id="modal_venta" name="modal_precio"  disabled>
                  </div> 
            
                
                  <div class="form-group" id="frm_precio">
                      <label>Utilidad recaudada</label>
                      <input type="text" class="form-control" id="modal_utilidad" name="modal_precio"  disabled>
                  </div> 
                  <div class="form-group float-right">
                      <button onclick="close_modal_proveedorCigarro()" type="button" class="btn btn-secondary btn-danger">Cerrar</button>
         
                  </div>
              </form>
            </div>
        </div>
    </div>
</div>





<script src="<?php echo base_url(); ?>assets/js_seller/saleEggs.js"></script>