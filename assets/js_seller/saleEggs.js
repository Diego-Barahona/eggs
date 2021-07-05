$(() => {
    $("#content_info").hide();
    $("#alert").hide();
    $("#frm_year").hide();
    $("#frm_month").hide();
    $("#frm_date1").hide();
    $("#btn_periodo1").hide();
    hideTitles();
    
  
  
});




//global variable 

let selector_product = false;
let year2 = "";
let option="";
let table ="";
 
const tabla = $("#table-utilidades").DataTable({

	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columns: [
        { data: "fecha" },
		{ data: "codigo" },
        { data: "total_ventas" },
        {
			defaultContent: `<button type='button' name='details' class='btn btn-success'>
                                 
                                  <i class="fas fa-search"></i>
                              </button>`,
		}
        
		
	],
});


$("#table-utilidades").on("click", "button", function () {
	let data = tabla.row($(this).parents("tr")).data();
	if ($(this)[0].name == "details") {
        show_modal_details(data);
    }
     
	
	
});

show_modal_details=(data)=>{
    $("#modal_ventah").modal("show");
    $("#modal_fecha").val(data.fecha);
    $("#modal_codigo").val(data.codigo);
    $("#modal_cliente").val(data.cliente);
    $("#modal_venta").val(data.total_ventas);
    $("#modal_utilidad").val(data.utilidades);
   
    
}


close_modal_proveedorCigarro=()=>{
    $("#modal_ventah").modal("hide");
}

// seleccion de periodos
$("#periodo").on('change',()=> { 

	let periodo = $("#periodo").val();
    console.log(periodo);
    if(periodo===""){
        limpiarTabla();
        ClearData();
        hideTitles();
        $("#frm_year").hide();
        $("#frm_month").hide();
        $("#frm_date1").hide();
        $("#content_info").hide();
        $("#alert").hide();
        $("#btn_periodo1").hide();
    }
	if(periodo=="1"){

        limpiarTabla();
        ClearData();
        hideTitles();
        $("#frm_year").show();
        $("#frm_month").hide();
        $("#frm_date1").hide();
        $("#content_info").hide();
        $("#alert").hide();
        $("#btn_periodo1").show();
      
       
	}
   
    if(periodo=="2"){
        limpiarTabla();
        ClearData();
        hideTitles();
        $("#frm_year").show();
        $("#frm_month").show();
        $("#frm_date1").hide();
        $("#content_info").hide();
        $("#alert").hide();
        $("#btn_periodo1").show();
      
    }

    if(periodo=="3"){
        limpiarTabla();
        hideTitles();
        $("#frm_year").hide();
        $("#frm_month").hide();
        $("#frm_date1").show();
        $("#content_info").hide();
        $("#alert").hide();
        $("#btn_periodo1").show();

      
   }
});

ClearData=()=>{
    $("#date1").val("");
    $("#year").val("");
    $("#month").val("");
}


limpiarTabla=()=>{
    tabla.clear();
    tabla.draw();
   
}

hideTitles =()=>{
    $("#title_info1").hide();
    $("#title_info2").hide();
    $("#title_info3").hide();
    $("#info_dia").hide();
    $("#info_mes").hide();
    $("#info_ano").hide();
}

//botones de configuracion 

function number_format(amount, decimals) {

    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

    decimals = decimals || 0; // por si la variable no fue fue pasada

    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0) 
        return parseFloat(0).toFixed(decimals);

    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

    return amount_parts.join('.');
}

convertirMes = (valor )=>{ 

    let mes ="";
     
    let meses = [{ mes:'Enero'},{ mes:'Febrero'},{ mes:'Marzo'},{ mes:'Abril'}
    ,{ mes:'Mayo'},{ mes:'Junio'},{ mes:'Julio'},{ mes:'Agosto'}
    ,{ mes:'Septiembre'},{ mes:'Octubre'},{ mes:'Noviembre'},{ mes:'Diciembre'}];

    meses.forEach((item,index)=>{
        if(index == ((parseInt(valor)-1))){ mes = item.mes ;}
    });

    return mes;
}


getSaleByProduct = () => { 

    let data;
    let ok =false;
    let periodo= $("#periodo").val();
    let year = $("#year").val();
    
    let month= $("#month").val();
    let date = $("#date1").val();

    if(periodo){
        if(periodo =="1"){ if(year!=""){  data = {periodo: periodo, year: year }; ok=true;   year2 = year;}}

        if(periodo =="2"){ 
            if(month !="" && year !="" ){ 
                 data = { periodo: periodo, year:year, month:month  }; ok=true;   year2 = year; }
            }  
        
        
        if(periodo =="3"){ 

            if(date !=""){ 
                data = { periodo: periodo, date : date }
                ok = true;}
            } 
      
      }
      
      console.log(data);

      if(ok){
        
        url= "api/seller/saleEggs";
   
            $.ajax({
           data: { data },
           type: "POST",
           url: host_url + url,
           crossOrigin: false,
           dataType: "json",
           success: (result) => {

               data = result ;
               periodo = data.periodo;

               if(periodo =="1"){ 
                  $("#content_info").show();
                  response = data.res;
                  fieldPeriodo1(response,year);
                  datatable(response[0]);
               }

               if(periodo == "2"){
                $("#content_info").show();
                response = data.res;
                fieldPeriodo2(response,year,month);
                datatable(response[0]);
               }

               if(periodo == "3"){
                $("#content_info").show();
                response = data.res;
                fieldPeriodo3(response,date);
                datatable(response[0]);
               }

           },
           error: () => {
            $("#content_info").hide();
            swal({
				title: "Error",
				icon: "error",
				text: "No se ha cargar información.",
			});

           }
            });
    
        }else{
            swal({
				title: "Error",
				icon: "error",
				text: "Complete todos los campos para continuar.",
			});

        }



    
}



datatable = ( data )=>{ 

    tabla.clear();
	tabla.rows.add(data);
	tabla.draw();
}




fieldPeriodo1 = (data,year) => {
 
  let cantidad_ventas = data[0].length;
  let suma_total = data[1][0].sum_ventas;

  $("#title_info1").show();
  $("#info_mes").hide();
  $("#info_ano").show();
  $("#info_dia").hide();
  $("#tiempo_anual").val(year);
  $("#cantidad_total").val(cantidad_ventas);
  if(suma_total){
  $("#suma_total").val(suma_total);
  }else { 
    $("#suma_total").val(0);
  }
    
}

fieldPeriodo2 = (data,year,month) => {
 
    let cantidad_ventas = data[0].length;
    let suma_total = data[1][0].sum_ventas;

    $("#title_info2").show();
    $("#tiempo_mensual").val(convertirMes(month));
    $("#tiempo_anual").val(year);
    $("#info_dia").hide();
    $("#info_mes").show();
    $("#info_ano").show();
    $("#cantidad_total").val(cantidad_ventas);
    if(suma_total){
    $("#suma_total").val(suma_total);
    }else { 
      $("#suma_total").val(0);

    }
      
  
  }


  fieldPeriodo3 = (data,date) => {
 
    let cantidad_ventas = data[0].length;
    let suma_total = data[1][0].sum_ventas;

    $("#title_info3").show();
    $("#info_ano").hide();
    $("#info_mes").hide();
    $("#info_dia").show();
    $("#tiempo_dia").val(date);
    $("#cantidad_total").val(cantidad_ventas);
    if(suma_total){
    $("#suma_total").val(suma_total);
    }else { 
      $("#suma_total").val(0);

    }
  }




$("#btn_generate").on("click", getSaleByProduct);


$("#date1").datepicker({
	showOn: "button",
	buttonText: "Calendario",
	changeMonth: true,
	changeYear: true,
	dateFormat: 'yy-mm-dd',
	buttonImage: host_url + 'assets/img/about/calendario2.png',
});




