$(() => {
    getOptionsCharts();
});

getOptionsCharts=()=> {

let data = [

   { parametro :"Utilidades",tipo:1 },
   { parametro :"Ventas",tipo:2},
   { parametro :"Gastos",tipo:3},
   { parametro :"Compras",tipo:4},
 
 
];

tabla.clear();
tabla.rows.add(data);
tabla.draw();

}

          
const tabla = $("#table-charts").DataTable({

	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columns: [
        { data: "tipo" },
		{ data: "parametro" },
        {
			defaultContent: `<button type='button' name='show_charts' class='btn btn-success'>
                                  Visualizar 
                                  <i class="fas fa-edit"></i>
                              </button>`,
		}
		
	],
});


$("#table-charts").on("click", "button", function () {
	let data = tabla.row($(this).parents("tr")).data();
	if ($(this)[0].name == "show_charts") {
      console.log("hola");
	
        if(data.tipo == 1){
            let url = 'charts/utils';
            window.location.assign(host_url+url);

        }
        if(data.tipo == 2){
            let url = 'charts/sale';
            window.location.assign(host_url+url);

        }
        if(data.tipo == 3){
            let url = 'charts/expensive';
            window.location.assign(host_url+url);

        }
        if(data.tipo == 4){
            let url = 'charts/buys';
            window.location.assign(host_url+url);

        }
     
     
	
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