$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
    },
});

$(() => {
   
	
    get_proveedorHuevo();
});
get_proveedorHuevo = () => {
    
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/get_proveedorHuevo`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            
            let data = xhr.response;
			
			tablaProveedorHuevo.clear();
			tablaProveedorHuevo.rows.add(data);
			tablaProveedorHuevo.draw();
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener los proveedores de huevo",
			});
		}
	});
	xhr.send();
};


/*Constante para rellenar las filas de la tabla: lista de Gastos*/
const tablaProveedorHuevo = $('#list_proveedorHuevo').DataTable({
	searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columns: [
		{ data: "id" },
        { data: "nomProveedor" },
        { data: "codProducto" },
      
       
        	
	],
});
