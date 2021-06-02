$(() => {
    $("#content-graphic").hide();
    $("#alert").hide();
    $("#frm_year").hide();
    $("#frm_month").hide();
    
});
 
const tabla = $("#table-utilidades").DataTable({

	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columns: [
        { data: "fecha" },
		{ data: "codigo" },
        { data: "utilidades" },
        {
			defaultContent: `<button type='button' name='go_to' class='btn btn-success'>
                                 
                                  <i class="fas fa-search"></i>
                              </button>`,
		}
        
		
	],
});




$("#periodo").on('change',()=> { 

	let valor = $("#periodo").val();
    console.log(valor);
	if(valor=="1"){
   
		$("#frm_year").show();
        $("#frm_month").hide();
	}
   
    if(valor=="2"){
         console.log("entre compuesto");
         $("#frm_year").show();
        $("#frm_month").show();
    }

    if(valor=="3"){
        console.log("entre compuesto");
        $("#frm_year").show();
       $("#frm_month").show();
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



let year2 = "";


getUtilsByPeriod = () => { 
    let data;
    let ok =false;
    let periodo= $("#periodo").val();
    let year = $("#year").val();
    let month= $("#month").val();
     year2 = year;
    

    if(periodo){
        if(periodo =="1"){ if(year!=""){  data = {periodo: periodo, year: year }; ok=true;}}
        if(periodo =="3"){ if(month !=""){data = { periodo: periodo, month:month }; ok=true; }}
        if(periodo =="2"){ if(month !="" && year !="" ){  data = { periodo: periodo, year:year,month:month }; ok=true; }}   
    } 
   console.log(data);
    if(ok){
     url= "api/chart/utils";

     	$.ajax({
		data: { data },
		type: "POST",
		url: host_url + url,
		crossOrigin: false,
		dataType: "json",
		success: (result) => {
		       data = result.res;
               tiempo=data[0][0]; //tiempo puede ser : años o meses 
               allTimes=data[1]; // todas utlidades por meses o en años .
               register= data[2];
               periodo = result.periodo;
              if(tiempo.utilidades){
                $("#content-graphic").show();

              if(periodo == "1"){
                $("#alert").hide(); 
                 graficoVertical(tiempo,periodo);
                 graficoPie(allTimes,'año',periodo);
                 datatable(register);

              }
               
              if(periodo == "2"){
                $("#alert").hide();
                graficoVertical(tiempo,periodo);
                graficoPie(allTimes,'mes',periodo);
                datatable(register);

             }
            }else{
                tabla.clear();
                tabla.draw();
                $("#content-graphic").hide();
                $("#alert").show();
            }
            
            },
            error: ()=>{
                swal({
                    title: "Error",
                    icon: "error",
                    text: "Error al recuperar información.",
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
          title: 'Utilidades del año '+json.tiempo+' ( pesos chilenos)',
          is3D: true,
          vAxis: {
            minValue: 0,
            maxValue: parseInt(json.years),
            
          },
           bar: {groupWidth: "25%"},  
        }; }

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
              title: 'Utilidades del mes de '+ convertirMes(json.tiempo)+' del '+ year2 +'( pesos chilenos)',
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
    let graphic =[[tiempo, 'Utilidades']];// toma el arreglo objeto y lo convierte en un arreglo de arrays 
    
     json.forEach((item,index)=>{
         let data=[];
         data = [item.tiempo,parseInt(item.utilidades)];
         graphic.push(data);
     })

    drawChart=()=>{
    var data = google.visualization.arrayToDataTable(graphic); // se entre el array con los datos 

      var options = {
        title: 'Gráfico comparativo por '+ tiempo,
        is3D:true
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);


    }
    }

    if(periodo=="2"){
        let graphic =[[tiempo, 'Utilidades']];// toma el arreglo objeto y lo convierte en un arreglo de arrays 
        
         json.forEach((item,index)=>{
             let data=[];
             data = [convertirMes(item.tiempo),parseInt(item.utilidades)];
             graphic.push(data);
         })
    
        drawChart=()=>{
        var data = google.visualization.arrayToDataTable(graphic); // se entre el array con los datos 
    
          var options = {
            title: 'Gráfico comparativo por '+ tiempo,
            is3D:true
          };
          var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
         
        }
    
    
        }

    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
}



$("#btn_generate").on("click",getUtilsByPeriod);