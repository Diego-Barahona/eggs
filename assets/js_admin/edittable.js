$(() => {
	getEggs();

	
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
	columns: [
		{ data: "id" },
		{ data: "producto" },
        { data: "tipo" },
        { data: "stock" },
		{
			defaultContent: `<button type='button' name='editPrecio' class='btn btn-primary'>
								  Editar
								  <i class="fas fa-edit"></i>
							  </button>`,
		},
		{
			defaultContent: `<button type='button' name='deleteButton' class='btn btn-primary'>
								  Editar
								  <i class="fas fa-edit"></i>
							  </button>`,
		},
	
		
	],
	
	

});


$('#table-eggs').on('draw.dt', function(){
	$('#table-eggs').Tabledit({
	url:host_url + "api/editEggsTest",
	dataType:'json',
	columns:{
	identifier : [0, 'id'],
	editable:[ [2, 'tipo'], [3, 'stock']]
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
			tabla.rows().remove().draw();
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
	if($(this)[0].name == "editPrecio"){
		
	
	
	}
});


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







