$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
    },
});

$(() => {
   
	
    get_proveedorCigarro();
});
get_proveedorCigarro = () => {
    
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/get_proveedorCigarro`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            
            let data = xhr.response;
			
			tablaProveedorCigarro.clear();
			tablaProveedorCigarro.rows.add(data);
			tablaProveedorCigarro.draw();
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener los proveedores de cigarros",
			});
		}
	});
	xhr.send();
};


/*Constante para rellenar las filas de la tabla: lista de Gastos*/
const tablaProveedorCigarro = $('#list_proveedorCigarro').DataTable({
	searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columns: [
		{ data: "id" },
        { data: "nombre" },
        { data: "codProducto" },
      
       
        	
	],
});
