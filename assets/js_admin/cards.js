$(() => {
	get_data();
	mesActual();
	
});

const tabla = $("#table-cards").DataTable({
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columns: [
		{ data: "id" },
		{ data: "type_service" },
		{ data: "date_admission" },
	],
});

let fecha = "";

let utilidades;

mesActual = ()=>{
	const fecha = new Date();
	const mesActual = fecha.getMonth() + 1;
	const yearActual = fecha.getFullYear(); 
    let mes = convertirMes(mesActual);
	
	text =" Cómputo general ( "+mes+"-"+ yearActual+" )";
	$("#title_counter").text(text);

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

get_data= () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}api/cards`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            
            data = xhr.response;
            console.log(data);
           
           obj_utilidades = data.utilidades;
           obj_ventas = data.ventas;
		   obj_compras = data.compras; 
		   obj_gastos = data.gastos; 
		   obj_credito = data.credito; 
            $("#utilidades").html(number_format( obj_utilidades[0].utilidades));
	        $("#gastos").html(number_format( obj_gastos[0].gastos));
		    $("#ventas").html( number_format(obj_ventas[0].ventas));
			
	        $("#credito").html( number_format(obj_credito[0].credito));
		    $("#compras").html(number_format(obj_compras[0].compras));
		  //  $("#stock").html(stock);	
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al cargar los datos.",
			});
		}
	});
	xhr.send();
};

loadDataModal = (title, data) => {
	$("#titlemodal").html(title);
	tabla.clear();
	tabla.rows.add(data);
	tabla.draw();
};



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
$("#table-orders").on("click", "button", function () {
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