<div class="conteiner text-center ">
   <h3> <i class="fa fa-th-large" style="font-size: 40px"></i><span id="title_counter">&nbsp;<span></h3>
   <hr>
   <br>
   <div class="row justify-content-center ">


      <div class="card text-white bg-info mb-3 mx-2" style="width: 13rem; height:13rem;">
         <div class="card-header text-center" style="font-weight: bold; color:black;" id="utilidades"><strong>0</strong> </div>
         <div class="card-body">
            <h5 class="card-title">Utilidades</h5>
            <button type="button" class="btn btn-outline-light"><i class="fas fa-hand-holding-usd" style="font-size:60px;" id="btn_utilidades"></i></button>
         </div>
      </div>
      <div class="card text-white mb-3 mx-3" style="width: 13rem; height:13rem; background-color: #ab47bc">
         <div class="card-header text-center" style="font-weight: bold; color:black" id="gastos"><strong>0</strong></div>
         <div class="card-body">
            <h5 class="card-title">Gastos</h5>
            <button type="button" class="btn btn-outline-light"><i class="fas fa-user-clock" style="font-size:60px;" id="btn_gastos"></i></button>
         </div>
      </div>
      <div class="card text-white mb-3 ml-2" style="width: 13rem; height:13rem; background:#00897b">
      <div class="card-header text-center" style="font-weight: bold; color:black" id="ventas"><strong>0</strong> </div>
         <div class="card-body">
            <h5 class="card-title">Venta cigarros</h5>
            <button type="button" class="btn btn-outline-light"><i class="fas fa-smoking" style="font-size:60px;" id="btn_ventas"></i></button>
           
         </div> 
      </div>
      
   </div>

   <div class="row justify-content-center">
      <div class="card text-white  mb-3 mx-2" style="width: 13rem; height:13rem; background:#00897b">
         <div class="card-header text-center" style="font-weight: bold; color:black" id="compras"><strong>0</strong> </div>
         <div class="card-body">
            <h5 class="card-title">Compras</h5>
            <button type="button" class="btn btn-outline-light"><i class="fas fa-shopping-cart" style="font-size:60px;" id="btn_compras"></i></button>
         </div> 
        
      </div>
      <div class="card text-white  mb-3 mx-3" style="width: 13rem; height:13rem; background: #ffa726 ">
         <div class="card-header text-center" style="font-weight: bold; color:black" id="credito"><strong>0</strong> </div>
         <div class="card-body">
            <h5 class="card-title"> Crédito</h5>
            <button type="button" class="btn btn-outline-light"><i class="fas fa-funnel-dollar" style="font-size:60px;" id="btn_credito"></i></button>
         </div>
      </div>
      
      <div class="card text-white bg-danger mb-3 ml-2" style="width: 13rem; height:13rem;">
         <div class="card-header text-center" style="font-weight: bold; color:black" id="venta_h"><strong> 0</strong></div>
         <div class="card-body">
            <h5 class="card-title">Venta huevos</h5>
            <button type="button" class="btn btn-outline-light"><i class="fas fa-egg" style="font-size:60px;" id="btn_ventah"></i></button>
           
         </div>
      </div>
   </div>
   </div>
  


<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="titlemodal"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="card mb-3">
               <div class="card-header">
                  <i class="fas fa-table"></i>
                   Órdenes
               </div>
               <div class="card-body">
                  <div class="table-responsive">
                     <table class="table table-bordered" id="table-cards" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                              <th>OT</th>
                              <th>Tipo servicio</th>
                              <th>Fecha ingreso</th>       
                            </tr>
                        </thead>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
         </div>
      </div>
   </div>
</div>

<script src="<?php echo base_url(); ?>assets/js_admin/cards.js"></script>