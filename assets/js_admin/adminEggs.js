$(() => {
	getEggs();
	get_field();
	
});

$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
	},
});

$("#tipoHuevo").change(() => { 
	let name = $("#tipoHuevo").val();
	if(name){
		$("#frm_tipoHuevo > input").removeClass("is-invalid");
	}else{
		$("#frm_tipoHuevo > input").addClass("is-invalid");
	}
});

$("#stock").change(() => { 
	let name = $("#stock").val();
	if(name){
		$("#frm_stock > input").removeClass("is-invalid");
	}else{
		$("#frm_stock > input").addClass("is-invalid");
	}
});

var edit = false;
var idEdit = 0;
let currentName= "_[[][ÑLLKLHHGHJKUUHYT%&%%$%//&%%$%%$$#"
;
let currentClient= "_[[][ÑLLKLHHGHJKUUHYT%&%%$%//&%%$%%$$#"
;

const tabla = $("#table-eggs").DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	"columnDefs": [
        {
            className: "text-center", "targets": [4] ,
        },
		{
            className: "text-center", "targets": [5] ,
        },
		{
            className: "text-center", "targets": [6] ,
        },
    ],
	columns: [
		{ data: "producto" },
        { data: "tipo" },
        { data: "stock" },
		{ data: "state" },
		{
			defaultContent: `<button type='button' name='editButton' class='btn btn-primary'>
                                  Editar
                                  <i class="fas fa-edit"></i>
                              </button>`,
		},
		{
			defaultContent: `<button type='button' name='editPrecio' class='btn btn-primary'>
			                    Precios 
			                   <i class="fas fa-edit"></i>
		                        </button>`,
		},
	
		{
			defaultContent: `<button type='button' name='deleteButton' class='btn btn-danger'>
                                    Bloquear/Desbloquear
                                  <i class="fas fa-times"></i>
                              </button>`,
		},
		
	],
});

const tabla2 = $("#table-eggs-client").DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},

	"columnDefs": [
        {
            className: "text-center", "targets": [2] ,
        },
    ],

	columns: [
		{ data: "id" },
		{ data: "nomCliente" },
        { data: "precioCliente" },
        
	
		
	],
});


$('#table-eggs-client').on('draw.dt', function(){
	$('#table-eggs-client').Tabledit({
	url:host_url + "api/editEggsClient",
	dataType:'json',
	columns:{
	identifier : [0, 'id'],
	editable:[ [2, 'precioCliente'], ]
	},
	
    saveButton: true,
    autoFocus: true,
    buttons: {
        edit: {
            class: 'btn btn-sm btn-primary',
            html: '<span class="glyphicon glyphicon-pencil"></span> &nbsp EDIT',
            action: 'edit'
        },
		save: {
			class: 'btn btn-sm btn-success',
			html: 'Save'
		},
		
    },
	
	onSuccess:function(result)
	{
		swal({
			title: "Éxito!",
			icon: "success",
			text: result.msg,
			button: "OK",
		}).then(() => {
			getEggClient();
			getEggs();
		});
	},
	onFail: function(result) {
		swal({
			title: "Error",
			icon: "error",
			text: result.responseJSON.msg,
		}).then(() => {
			getEggs();
			getEggClient();
		
			
		});
    },

	});
	});



addErrorStyle = (errores) => {
	let arrayErrores = Object.keys(errores);
	arrayErrores.map((err) => {
		$(`.${err}`).show();
	});
};

getEggs = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getEggs`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
			console.log(xhr.response);
			let data = xhr.response.map((u) => {
				if (u.state == 1) {
					u.state = "En utilización";
				} else {
					u.state = "Suspendido";
				}
				return u;
			});
			tabla.clear();
			tabla.rows.add(data);
			tabla.draw();
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener los componentes",
			});
		}
	});
	xhr.send();
};

$("#table-eggs").on("click", "button", function () {
	let data = tabla.row($(this).parents("tr")).data();
	if ($(this)[0].name == "deleteButton") {
		swal({
			title: `Bloquear/Desbloquear producto`,
			icon: "warning",
			text: `¿Está seguro/a de Bloquear/Desbloquear el producto de tipo : "${data.tipo}"?`,
			buttons: {
				confirm: {
					text: "Bloquear/Desbloquear",
					value: "exec",
				},
				cancel: {
					text: "Cancelar",
					value: "cancelar",
					visible: true,
				},
			},
		}).then((action) => {
			if (action == "exec") {
				bloquearDesbloquearEgg(data.id, data.state);
			} else {
				swal.close();
			}
		});
	}else{ 
	
	if($(this)[0].name == "editPrecio"){
		
		$("#id2").val(data.id);
		$("#title2").text("Precios producto " + '"' +data.tipo+'"');
		$("#modal_eggs_client").modal("show");
		getEggClient();
	
	}else {
		edit = true;
		idEdit = data.id;
		currentName = data.tipo;
		cleanInput();
        $("#title").text("Modificar producto");
        $("#tipoHuevo").val(data.tipo);
		$("#stock").val(data.stock);
		$("#id").val(data.id);
		$("#modal_eggs").modal("show");
	}}
});

bloquearDesbloquearEgg = (id, state) => {
	let data = {
		state: state == "En utilización" ? 0 : 1,
		id: id,
    };
    console.log(data);
	$.ajax({
		data: { data },
		type: "POST",
		url: host_url + "api/changeStateEgg",
		crossOrigin: false,
		dataType: "json",
		success: (result) => {
			swal({
				title: "Éxito!",
				icon: "success",
				text: result.msg,
				button: "OK",
			}).then(() => {
				tabla.rows().remove().draw();
				getEggs();
			});
		},
		error: (result) => {
			swal({
				title: "Error",
				icon: "error",
				text: result.responseJSON.msg,
			});
		},
	});
};

registerEgg = () => {
	let data = {
		tipoHuevo: $("#tipoHuevo").val(),
		stock: $("#stock").val(),
		id:$('#id').val(),
    };
 
	if(currentName != data.tipoHuevo){

	let url = "";
	if (edit) url = "api/editEgg";
	else url = "api/createEgg";
	Object.keys(data).map((d) => $(`.${d}`).hide());
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
				$("#modal_eggs").modal("hide");
				tabla.rows().remove().draw();
				getEggs();
				edit = false;
				idEdit = 0;
			});
		},
		error: (result) => {
		
			swal({
				title: "Error",
				icon: "error",
				text: result.responseJSON.msg,
			}).then(() => {
				if(result.responseJSON.err.name){$("#frm_tipoHuevo > div").html(result.responseJSON.err.name); $("#frm_tipoHuevo > input").addClass("is-invalid");}
				if(result.responseJSON.err.stock){$("#frm_stock > div").html(result.responseJSON.err.stock); $("#frm_stock > input").addClass("is-invalid");}
			});
		},
	});
}else{
	swal({
		title: "Error",
		icon: "error",
		text: "Ingrese un nombre diferente al actual",
	});
}
};


registerEggClient = () => {
	let data = {
		precio: $("#precio").val(),
		client: $("#client").val(),
		id:$('#id2').val(),
    };
    console.log(data);

	url = "api/createEggClient";
	Object.keys(data).map((d) => $(`.${d}`).hide());
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
			
				getEggClient();
				
			});
		},
		error: (result) => {
		
			swal({
				title: "Error",
				icon: "error",
				text: result.responseJSON.msg,
			}).then(() => {
				if(result.responseJSON.err.client){$("#frm_client > div").html(result.responseJSON.err.name); $("#frm_client > input").addClass("is-invalid");}
				if(result.responseJSON.err.precio){$("#frm_precio > div").html(result.responseJSON.err.stock); $("#frm_precio > input").addClass("is-invalid");}
			});
		},
	});

};

getEggClient=()=>{
    id = $("#id2").val();
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getEggClient/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
			let data = xhr.response;
			tabla2.clear();
			tabla2.rows.add(data);
			tabla2.draw();
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



let client = [];

get_field = () => {

	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getFields`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
			if(client.length == 0){
                let rol = xhr.response.map((u) => {
                    let option = document.createElement("option"); 
                    $(option).val(u.id); 
                    $(option).attr('name', u.nomCliente);
                    $(option).html(u.nomCliente); 
                    $(option).appendTo("#client");
                    client.push(u.nomCliente);
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

cleanInput = () => {
    $("#title").text("Registrar producto");
    $("#id").val("");
	$("#tipoHuevo").val("");
	$("#stock").val("");
	$(`.stock`).hide();
	$(`.tipoHuevo`).hide();
    $(`.id`).hide();
	$("#frm_stock > input").removeClass("is-invalid");
	$("#frm_tipoHuevo > input").removeClass("is-invalid");

};

$("#register_eggs").on("click", () => {
	cleanInput();
	edit = false;
	idEdit = 0;
	$("#modal_eggs").modal("show");
});

$("#createEgg").on("click", () => {
	registerEgg();
});

$("#createEggClient").on("click", () => {
	registerEggClient();
});





