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
	get_field();
	get_cigars();
});

let proveedor =[];
let cigars = [];
let edit=false;
let idCurrent =0;



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
	"columnDefs": [
        {
            className: "text-center", "targets": [3] ,
        },
    ],
	columns: [
        { data: "proveedor" },
        { data: "cigarro" },
		{ "render": function (data, type, row){            
			return totalFormat(row.precio)
	   	}},	
		{
            defaultContent: `<button type='button' name='btn_update' class='btn btn-primary'>
                                  Editar
                                  <i class="fas fa-edit"></i>
                              </button>`,
		},
	],
});

$("#list_proveedorCigarro").on("click", "button", function () {
    let data = tablaProveedorCigarro.row($(this).parents("tr")).data();
    if ($(this)[0].name == "btn_update") {
		show_data_edit(data);
}});

show_data_edit =(data)=> { 

	$("#modal_proveedorCigarro").modal("show");
     
	edit=true;
	idCurrent = data.id;
	$("#precio").val(data.precio);

	let b = $(`option[name ="${data.proveedor}"]`).val();
    $("#proveedor").val(b);

	let a = $(`option[name ="${data.cigarro}"]`).val();
    $("#producto").val(a);


}

close_modal_proveedorCigarro = () => { $("#modal_proveedorCigarro").modal('hide');}


$("#btn_modal").on("click",() => {
	$("#proveedor").val("");
	$("#precio").val("");
	$("#producto").val("");
	edit = false;
	console.log("entre");
	$("#modal_proveedorCigarro").modal("show");
})



totalFormat = (total) => {
    const formatterPeso = new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 0
      })
    return formatterPeso.format(total);
}

get_field = () => {

	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/proveedor_cigar/getFields`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
			if(proveedor.length == 0){
                let rol = xhr.response.map((u) => {
                    let option = document.createElement("option"); 
                    $(option).val(u.id); 
                    $(option).attr('name', u.nombre);
                    $(option).html(u.nombre); 
                    $(option).appendTo("#proveedor");
                    proveedor.push(u.nombre);
                });
            }
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener los componentes",
			});
		}
	});
	xhr.send();

}

get_cigars = () => {

	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/cigars/getFields`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
			if(cigars.length == 0){
                let rol = xhr.response.map((u) => {
                    let option = document.createElement("option"); 
                    $(option).val(u.id); 
                    $(option).attr('name', u.nombre);
                    $(option).html(u.nombre); 
                    $(option).appendTo("#producto");
                     cigars.push(u.nombre);
                });
            }
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener los componentes",
			});
		}
	});
	xhr.send();

}

create_edit = () => {
      
	 $("#producto").val();
	 $("#proveedor").val();
	 $("#precio").val();
     let url ="";
	 let data;
	 if(edit) {
     url = "api/edit_precio";
	 data = { precio: $("#precio").val(), producto: $("#producto").val(), proveedor: $("#proveedor").val(), id:idCurrent  };
	}else{
	url ="api/create_precio";
	data = { precio: $("#precio").val(), producto: $("#producto").val(), proveedor: $("#proveedor").val() };
    } 
    
	 $.ajax({
		data: { data },
		type: "POST",
		url: host_url + url,
		crossOrigin: false,
		dataType: "json",
		success: (result) => {
			console.log(result);
			swal({
				title: "Éxito!",
				icon: "success",
				text: result.msg,
				button: "OK",
			}).then(() => {
			    $("#modal_proveedorCigarro").modal("hide");
				swal.close();
				get_proveedorCigarro();
				
			});
		},
		error: (result) => {
		
			swal({
				title: "Error",
				icon: "error",
				text: result.responseJSON.msg,
			}).then(() => {
				$("#modal_proveedorCigarro").modal("hide");
				swal.close();
				get_proveedorCigarro();
			});
		},
	});
		

}

$("#btn_ok").on("click",()=>{
	create_edit();
})





