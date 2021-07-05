$(() => {
    $("#graphic-content").hide();
    $("#alert").hide();
    $("#frm_year").hide();
    $("#frm_month").hide();
    $("#frm_date1").hide();
    $("#frm_date2").hide();
    $("#frm_date3").hide();
    $("#btn_periodo1").hide();
    $("#btn_periodo2").hide();
    $("#btn_periodo3").hide();
    $("#frm_month2").hide();
    $("#frm_year2").hide();
});

//global variable 

let selector_product = false;
let year2 = "";
let option="";
let table_1 ="";
 
const tabla = $("#table-utilidades").DataTable({

	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columns: [
        { data: "fecha" },
		{ data: "codigo" },
        { data: "utilidades" },
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


    $("#modal_chartBuys").modal("show");
    $("#modal_fecha").val(data.fecha);
    $("#modal_codigo").val(data.codigo);
    $("#modal_precio").val(data.utilidades);
    $("#modal_proveedor").val(data.proveedor);
     if(data.producto == 1){
        $("#modal_tipo").val("Huevos");
     }else{
        $("#modal_tipo").val("Cigarros");
     }
   
    
}

close_modal_proveedorCigarro=()=>{
    $("#modal_chartBuys").modal("hide");
}




// seleccion de periodos
$("#periodo").on('change',()=> { 

	let periodo = $("#periodo").val();
    console.log(periodo);
    if(periodo==""){
        limpiarTabla();
        inputPeriodo3();
        $("#graphic-content").hide();
		$("#frm_year").hide();  $("#btn_periodo1").hide();  $("#frm_month").hide(); $("#frm_month2").hide();$("#frm_year2").hide();
        $("#frm_date1").hide();  $("#frm_date2").hide();$("#frm_date3").hide();
        $("#btn_periodo2").hide();  $("#btn_periodo3").hide();
    }

	if(periodo=="1"){

        limpiarTabla();
        inputPeriodo3();
        $("#graphic-content").hide();
		$("#frm_year").show();  $("#btn_periodo1").show();  $("#frm_month").hide(); $("#frm_month2").hide();$("#frm_year2").hide();
        $("#frm_date1").hide();  $("#frm_date2").hide();$("#frm_date3").hide();
        $("#btn_periodo2").hide();  $("#btn_periodo3").hide();
       
	}

   
    if(periodo=="2"){
        limpiarTabla();
        inputPeriodo3();
        $("#graphic-content").hide();
        $("#frm_year").show();$("#frm_year2").hide();
        $("#frm_month").show();   $("#frm_month2").hide();
        $("#btn_periodo2").show();  
        $("#frm_date1").hide();$("#frm_date2").hide();$("#frm_date3").hide();
        $("#btn_periodo1").hide();   $("#btn_periodo3").hide();
        $("#btn_compare2").show(); $("#btn_exit2").hide();
    
    }

    if(periodo=="3"){
        limpiarTabla();
        $("#graphic-content").hide();
        $("#btn_compare").show();
        $("#frm_year2").hide();
        $("#frm_month2").hide();
       $("#frm_year").hide();
       $("#frm_month").hide();
       $("#btn_periodo3").show()
       $("#frm_date3").show();$("#frm_date2").hide(); $("#frm_date1").hide();
       $("#btn_periodo1").hide();  $("#btn_periodo2").hide();
       $("#btn_exit").hide();

   }
});

inputPeriodo3=()=>{
    $("#date1").val("");
    $("#date2").val("");
    $("#date3").val("");
    $("#year2").val("");
    $("#month2").val("");

}
limpiarTabla=()=>{
    tabla.clear();
    tabla.draw();
    $("#alert").hide();
}

//botones de configuracion 

$("#btn_compare").on('click',()=> {
     let valor = $("#date3").val();
    $("#btn_compare").hide();
    $("#frm_date3").hide(); $("#frm_date1").show(); $("#frm_date2").show();
    $("#date1").val(valor);
    $("#btn_exit").show();
    $("#date3").val("");
    

});
$("#btn_exit").on('click',()=> {
    
    $("#btn_exit").hide();
    $("#btn_compare").show();
    $("#frm_date3").show(); $("#frm_date2").hide(); $("#frm_date1").hide();
    $("#date1").val("");
    $("#date2").val("");

});


$("#btn_exit2").on('click',()=> {
    
    $("#btn_exit2").hide();
    $("#btn_compare2").show();
    $("#frm_month2").hide();$("#frm_year2").hide();
    $("#year2").val("");$("#month2").val("");
   

});

$("#btn_compare2").on('click',()=> {

   $("#btn_compare2").hide();
   $("#frm_month2").show();$("#frm_year2").show();
   $("#btn_exit2").show();


});


$("#product").on('change', ()=>{

    let valor = $("#product").val();
    if(valor ===""){
    
        selector_product = false;
    }else{
        selector_product =true;
        if(valor ==="1"){ table_1 = "compra_huevo ch";}else{table_1 = "compra_cigarro cc";}
        console.log("entre 2 ");
    }
});




$("#btn_utilidades").on("click", () => {
    let url = 'charts/utils';
    window.location.assign(host_url+url);
});
$("#btn_ventas").on("click", () => {
	let url = 'charts/sale';
		window.location.assign(host_url+url);
});

$("#btn_credito").on("click", () => {
    let url = 'charts/credit';
    window.location.assign(host_url+url);
});

$("#btn_stock").on("click", () => {
    let url = 'charts/stock';
    window.location.assign(host_url+url);
});

$("#btn_gastos").on("click", () => {
    let url = 'charts/expensive';
    window.location.assign(host_url+url);
});

$("#btn_compras").on("click", () => {
    let url = 'charts/buys';
    window.location.assign(host_url+url);
});

$("table-charts").on("click", "button", function () {
	let data = tabla.row($(this).parents("tr")).data();
	if ($(this)[0].name == "btn_admin") {
		let ot = data.id;
		let url = 'stagesOrder'+'?ot='+ot;
		window.location.assign(host_url+url);
	}
});

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



getSaleByPeriod = () => { 
    let data;
    let ok =false;
    let ok_product =false;
    let periodo= $("#periodo").val();
    let year = $("#year").val();
    let month= $("#month").val();
    let year_2 = $("#year2").val();
    let month_2= $("#month2").val();
    let date1 = $("#date1").val();
    let date2 = $("#date2").val();
    let date3 = $("#date3").val();


   
    
    if(periodo){
        if(periodo =="1"){ 
         if(year!=""){  data = {periodo: periodo, year: year }; ok=true;   year2 = year;} // kpi de venta por año 
         
        }
        if(periodo =="2"){ 
            if(month !="" && year !="" && year_2 =="" && month_2=="" ){ 
                 data = { periodo: periodo, year:year, month:month ,option:"1"  }; ok=true;   year2 = year;  option="1"; }
             
        
             if(month =="" && year =="" && year_2 !="" && month_2!="" ){ 
                    data = { periodo: periodo, year:year_2, month:month_2 ,option:"1" }; ok=true;  year2 = year_2; option="1"; }
                    
                 
            
             if(month !="" && year !="" && year_2 !="" && month_2!="" ){ 
                    data = { periodo: periodo, year:year, month:month ,year2:year_2, month2:month_2 , option:"2" }; ok=true; option="2"; }

            }  
        if(periodo =="3"){ 

            if(date3 !=""){ 
                data = { periodo: periodo, date1 : date3 ,option:"1"}
                option="1";
                ok = true;
            }

            if(date1 !="" && date2 !="" ){  
                option="2";
                data = { periodo: periodo, date1 : date1, date2 : date2 ,option:"2"}; 
                ok = true; }} 
            } 
           console.log(data);
      
    if(ok){
     url= "api/chart/buys";

     	$.ajax({
		data: { data },
		type: "POST",
		url: host_url + url,
		crossOrigin: false,
		dataType: "json",
		success: (result) => {
		       data = result.res;
               
               periodo = result.periodo;
            
               if(periodo =="1"){
               
               tiempo=data[0][0]; //tiempo puede ser : años o meses 
               allTimes=data[1]; // todas utlidades por meses o en años .
               register= data[2];
               
             
              if(tiempo.utilidades){
                
                showCharts();

                 if(periodo == "1"){
                     $("#alert").hide();
                     $("#graphic-bar").show();
                     $("#graphic-pie").show(); 
                     graficoVertical(tiempo,periodo);
                     graficoPie(allTimes,'año',periodo);
                     datatable(register);
                 }

            }else{

                tabla.clear();
                tabla.draw();
                $("#graphic-content").hide();
                $("#alert").show();
            }

            }else if (periodo =="2"){

                showCharts();

                if(option == "1" ){
                
                tiempo=data[0][0]; //tiempo puede ser : años o meses 
                allTimes=data[1]; // todas utlidades por meses o en años .
                console.log(allTimes);
                register= data[2];
                     

                    if(tiempo.utilidades){
                      $("#alert").hide();
                      $("#graphic-bar").show();
                      $("#graphic-pie").show(); 
                      graficoVertical(tiempo,periodo);
                      graficoPie(allTimes,'mes',periodo);
                      datatable(register);
                     }else{

                        tabla.clear();
                        tabla.draw();
                        $("#graphic-content").hide();
                        $("#alert").show();
                    }
                }else{ 

                    $("#alert").hide();
                    $("#graphic-pie").show(); 
                    graficoEntreMeses(data[0][0],data[1][0]);
                    tabla.clear();
                    tabla.draw();
                }

            } else{
                showCharts();
                if(option == "1" ){
                    
                    table=data[0]; // registro de utilidades de el dia seleccionado
                    json = data[1][0]; // total de utilidades al dia 
                    if(table.lenght!= 0){
                        $("#graphic-bar").show();
                        $("#alert").hide();
                        graficoVerticalDia(json);
                        $("#alert").hide();
                        datatable(table);
                    }else{
                        $("#alert").show();
                        $("#graphic-content").hide();
                        tabla.clear();
                        tabla.draw();
                    }
                }else{
                    $("#graphic-pie").show();
                    $("#alert").hide();
                     data1=data[0][0];
                     data2= data[1][0];
                    graficoEntreDias(data1,data2);
                    tabla.clear();
                    tabla.draw();

                }
            }  
            },
            error: ()=>{
                swal({
                    title: "Error",
                    icon: "error",
                    text: "Error al recuperar información.",
                });
            }
         });//fin de ajax

    }else{
      	swal({
				title: "Error",
				icon: "error",
				text: "Complete todos los campos para continuar.",
			});

    }
}


showCharts =()=> { 
    $("#graphic-content").show();
    $("#graphic-bar").hide();
    $("#graphic-pie").hide();

}

datatable = (data)=>{ 

    tabla.clear();
	tabla.rows.add(data);
	tabla.draw();
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


graficoVertical=(json,periodo)=>{
    
    drawChart=()=> {

        if(periodo == "1" ){

        var data = google.visualization.arrayToDataTable([
          ['hola', 'utilidad',{ role: 'style' }],
          [json.tiempo,parseInt(json.utilidades),'color: #0275d8'],
          ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);
            
        var options = {
          title: 'Total de compras del año '+json.tiempo+' ( pesos chilenos)',
          is3D: true,
          vAxis: {
            minValue: 0,
            maxValue: parseInt(json.years),
            
          },
           bar: {groupWidth: "25%"},  
        }; 
    }

        if(periodo == "2" ){
            
            var data = google.visualization.arrayToDataTable([
                ['hola', 'utilidad',{ role: 'style' }],
                [convertirMes(json.tiempo),parseInt(json.utilidades),'color: #0275d8'],
               
              ]);
      

            var view = new google.visualization.DataView(data);

             view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);
           
            var options = {
              title: 'Ventas del mes de '+ convertirMes(json.tiempo)+' del '+ year2 +'( pesos chilenos)',
              is3D: true,
              vAxis: {
                minValue: 0,
                maxValue: (parseInt(json.years)*1.20),
                
              },
               bar: {groupWidth: "25%"},  
            }; 
        }//fin if periodo 2 

        var chart = new google.visualization.ColumnChart(document.getElementById('barcolumn'));
        chart.draw(view, options);
      }
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);

}

graficoPie=(json,tiempo,periodo)=> { 
    if(periodo=="1"){
    let graphic =[[tiempo, 'Ventas']];// toma el arreglo objeto y lo convierte en un arreglo de arrays 
    
     json.forEach((item,index)=>{
         let data=[];
         data = [item.tiempo,parseInt(item.utilidades)];
         graphic.push(data);
     })

    drawChart=()=>{
    var data = google.visualization.arrayToDataTable(graphic); // se entre el array con los datos 
      var options = {
        title: 'Gráfico comparativo de compras por '+ tiempo,
        is3D:true
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }
    }

    if(periodo=="2"){
        let graphic =[[tiempo, 'Ventas']];// toma el arreglo objeto y lo convierte en un arreglo de arrays 
        
         json.forEach((item,index)=>{
             let data=[];
             data = [convertirMes(item.tiempo),parseInt(item.utilidades)];
             graphic.push(data);
         })
    
        drawChart=()=>{
        var data = google.visualization.arrayToDataTable(graphic); // se entre el array con los datos 
    
          var options = {
            title: 'Gráfico comparativo de ventas por '+ tiempo,
            is3D:true
          };
          var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
         
        }
        }

    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
}


graficoEntreDias=(periodo1,periodo2)=> { 
    
    if(periodo1.fecha && periodo2.fecha){
         if(periodo1.fecha == periodo2.fecha ){
            $("#graphic-content").hide();
            swal({
                title: "Atención",
                icon: "warning",
                text: "No es posible comparar dos fechas iguales.Reintente de nuevo.",
                 });
            
         }else{
            array1= [periodo1.fecha , parseInt(periodo1.utilidades)]; 
            array2= [periodo2.fecha , parseInt(periodo2.utilidades) ];
   
            let graphic =[['Período', 'Utilidades'], array1, array2];// toma el arreglo objeto y lo convierte en un arreglo de arrays 

            drawChart=()=>{
               var data = google.visualization.arrayToDataTable(graphic); // se entre el array con los datos 
    
               var options = {
                      title: 'Gráfico comparativo de compras por períodos(diarios)',
                      is3D:true
                        };
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                chart.draw(data, options);  
                }
    
            google.charts.load("current", {packages:["corechart"]});
            google.charts.setOnLoadCallback(drawChart);


         }
}else{
    $("#graphic-content").hide();
    let msg="No hay registro en las fechas seleccionadas. Intente nuevamente."

    if(!periodo1.fecha && periodo2.fecha){
        $("#date1").val("");
        msg ="La primera fecha  no tiene registros. Intente nuevamente. ";
    }else if (periodo1.fecha && !periodo2.fecha){
  
        $("#date2").val("");
        msg= "La segunda fecha no tiene registros.Intente nuevamente. ";
    }
    swal({
        title: "Atención",
        icon: "warning",
        text: msg,
    }).then( ()=>{
       swal.close();
    });
    
}

}

graficoEntreMeses=(periodo1,periodo2)=> { 
    
    if(periodo1.tiempo1 && periodo2.tiempo1){
        if(periodo1.tiempo1 == periodo2.tiempo1 && periodo1.tiempo2 == periodo2.tiempo2 ){
            $("#graphic-content").hide();
            swal({
                title: "Resultado",
                icon: "info",
                text: "No es posible comparar dos periodos iguales.Reintente de nuevo.",
                 });
                
     }else{  
             string1 = convertirMes(periodo1.tiempo1) + " / "+periodo1.tiempo2 ; 
             string2 = convertirMes(periodo2.tiempo1) + " / "+periodo2.tiempo2 ; 
             array1= [string1, parseInt(periodo1.utilidades)]; 
             array2= [string2, parseInt(periodo2.utilidades) ];
  
             let graphic =[['Período', 'Utilidades'], array1, array2];// toma el arreglo objeto y lo convierte en un arreglo de arrays 

             drawChart=()=>{
                  var data = google.visualization.arrayToDataTable(graphic); // se entre el array con los datos 
                  var options = {  title: 'Gráfico comparativo de compras: '+ string1 +" vs "+string2, is3D:true };
                  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                  chart.draw(data, options);  
             }
   
             google.charts.load("current", {packages:["corechart"]});
             google.charts.setOnLoadCallback(drawChart); 
    }
}else{

    $("#graphic-content").hide();
    let msg="No hay registro de los periodos seleccionados. Intente nuevamente."

    if(!periodo1.tiempo1 && periodo2.tiempo1){
        msg ="El primer periodo no tiene registros. Intente nuevamente. ";
    }else if (periodo1.tiempo1 && !periodo2.tiempo1){
        msg= "El segundo periodo no tiene registros.Intente nuevamente. ";
    }
    swal({
        title: "Atención",
        icon: "warning",
        text: msg,
    });
}
}


graficoVerticalDia=(json)=>{
  
    drawChart=()=> {
        var data = google.visualization.arrayToDataTable([
            ['hola', 'utilidad',{ role: 'style' }],
            [json.fecha,parseInt(json.utilidades),'color: #0275d8'],
            ]);
  
          var view = new google.visualization.DataView(data);
          view.setColumns([0, 1,
                         { calc: "stringify",
                           sourceColumn: 1,
                           type: "string",
                           role: "annotation" },
                         2]);
              
          var options = {
            title: 'Compras correspondientes al '+json.fecha+' ( pesos chilenos)',
            is3D: true,
            vAxis: {
              minValue: 0,
              maxValue: parseInt(json.utilidades),
              
            },
             bar: {groupWidth: "25%"},  
          }; 
          var chart = new google.visualization.ColumnChart(document.getElementById('barcolumn'));
          chart.draw(view, options);

    }
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);

}




getSaleByProduct = () => { 
    let data;
    let ok =false;
    let ok_product =false;
    let periodo= $("#periodo").val();
    let year = $("#year").val();
    let month= $("#month").val();
    let year_2 = $("#year2").val();
    let month_2= $("#month2").val();
    let date1 = $("#date1").val();
    let date2 = $("#date2").val();
    let date3 = $("#date3").val();
    let product= $("#product").val();
    

    
    if(periodo){
        if(periodo =="1"){ //Anual

         if(year!="" ){  data = {periodo: periodo, year: year , product:product ,table:table_1}; ok=true;   year2 = year;} // kpi de venta por año 
        }
        if(periodo =="2"){ //mensual
            if(month !="" && year !="" && year_2 =="" && month_2=="" ){ 
                 data = { periodo: periodo, year:year, month:month , product:product , table:table_1 ,option:"1"  }; ok=true;   year2 = year;  option="1"; }
        
             if(month =="" && year =="" && year_2 !="" && month_2!="" ){ 
                    data = { periodo: periodo, year:year_2, month:month_2 ,product:product,table:table_1 ,optiosn:"1" }; ok=true;  year2 = year_2; option="1"; }
                    
             if(month !="" && year !="" && year_2 !="" && month_2!="" ){ 
                    data = { periodo: periodo, year:year, month:month ,year2:year_2, month2:month_2 , table:table_1 , product:product, option:"2" }; ok=true; option="2"; }
              }  
        if(periodo =="3"){ // diario

            if(date3 !=""){ 
                data = { periodo: periodo, date1 : date3 , table:table_1 ,product:product,option:"1"}
                option="1";
                ok = true;
            }
            if(date1 !="" && date2 !="" ){  
                option="2";
                data = { periodo: periodo, date1 : date1, date2 : date2 , table:table_1 ,product:product,option:"2"}; 
                ok = true; }} 
            } 
           console.log(data);
      
    if(ok){
     url= "api/chart/buys/product";

     	$.ajax({
		data: { data },
		type: "POST",
		url: host_url + url,
		crossOrigin: false,
		dataType: "json",
		success: (result) => {
		       data = result.res;
               
               periodo = result.periodo;
            
               if(periodo =="1"){
               
               tiempo=data[0][0]; //tiempo puede ser : años o meses 
               allTimes=data[1]; // todas utlidades por meses o en años .
               register= data[2];
             
              if(tiempo.utilidades){
                
                showCharts();

                 if(periodo == "1"){
                     $("#alert").hide();
                     $("#graphic-bar").show();
                     $("#graphic-pie").show(); 
                     graficoVertical(tiempo,periodo);
                     graficoPie(allTimes,'año',periodo);
                     datatable(register);
                 }

            }else{

                tabla.clear();
                tabla.draw();
                $("#graphic-content").hide();
                $("#alert").show();
            }}

            else if (periodo =="2"){

                showCharts();

                if(option == "1" ){
                    console.log("entre perido dos producto");
                tiempo=data[0][0]; //tiempo puede ser : años o meses 
                allTimes=data[1]; // todas utlidades por meses o en años .
                console.log(allTimes);
                register= data[2];
                     

                    if(tiempo.utilidades){
                      $("#alert").hide();
                      $("#graphic-bar").show();
                      $("#graphic-pie").show(); 
                      graficoVertical(tiempo,periodo);
                      graficoPie(allTimes,'mes',periodo);
                      datatable(register);
                     }else{

                        tabla.clear();
                        tabla.draw();
                        $("#graphic-content").hide();
                        swal({
                            title: "Resultado",
                            icon: "info",
                            text: "No se han encontrado registros en el período consultado. Reintente nuevamente.",
                        });
                    }
                } else{ 

                    $("#alert").hide();
                    $("#graphic-pie").show(); 
                    graficoEntreMeses(data[0][0],data[1][0]);
                    tabla.clear();
                    tabla.draw();
                }

            } else{
                showCharts();
                if(option == "1" ){
              
                    table=data[0]; // registro de utilidades de el dia seleccionado
                    json = data[1][0]; // total de utilidades al dia 
                    if(table.lenght!= 0){
                        $("#graphic-bar").show();
                        $("#alert").hide();
                        graficoVerticalDia(json);
                        $("#alert").hide();
                        datatable(table);
                    }else{
                        $("#alert").show();
                        $("#graphic-content").hide();
                        tabla.clear();
                        tabla.draw();
                    }
                }else{
                    $("#graphic-pie").show();
                    $("#alert").hide();
                     data1=data[0][0];
                     data2= data[1][0];
                    graficoEntreDias(data1,data2);
                    tabla.clear();
                    tabla.draw();

                }
            }
            }, 
            error: ()=>{
                swal({
                    title: "Error",
                    icon: "error",
                    text: "Error al recuperar información.",
                });
            }
         });//fin de ajax

    }else{
      	swal({
				title: "Error",
				icon: "error",
				text: "Complete todos los campos para continuar.",
			});
    }
}

$("#btn_generate").on("click",()=>{
if(selector_product){   getSaleByProduct();}else{ getSaleByPeriod();  }
});
$("#btn_generate2").on("click",()=>{
    if(selector_product){ getSaleByProduct();}else{ getSaleByPeriod();  }
});
$("#btn_generate3").on("click",()=>{
    if(selector_product){  getSaleByProduct();}else{getSaleByPeriod();  }
});

$("#date1").datepicker({
	showOn: "button",
	buttonText: "Calendario",
	changeMonth: true,
	changeYear: true,
	dateFormat: 'yy-mm-dd',
	buttonImage: host_url + 'assets/img/about/calendario2.png',
});

$("#date2").datepicker({
	showOn: "button",
	buttonText: "Calendario",
	changeMonth: true,
	changeYear: true,
	dateFormat: 'yy-mm-dd',
	buttonImage: host_url + 'assets/img/about/calendario2.png',
});

$("#date3").datepicker({
	showOn: "button",
	buttonText: "Calendario",
	changeMonth: true,
	changeYear: true,
	dateFormat: 'yy-mm-dd',
	buttonImage: host_url + 'assets/img/about/calendario2.png',
});














