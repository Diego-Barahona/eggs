$(() => {
 getCost();
 getSupplier();

});

$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
	},
});

$("#name_cost").change(() => { 
	let name = $("#name_cost").val();
	if(name){
		$("#frm_name_cost > input").removeClass("is-invalid");
	}else{
		$("#frm_name_cost  > input").addClass("is-invalid");
	}
});
let select_product = [];
let idSelectCosto= 1;
let tipoProveedor = 0;
let edit = false;
var idEdit = 0;
let currentName= "_[[][ÑLLKLHHGHJKUUHYT%&%%$%//&%%$%%$$#"
;
let currentClient= "_[[][ÑLLKLHHGHJKUUHYT%&%%$%//&%%$%%$$#"
;

const tabla = $("#table-cost").DataTable({
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
    ],
	columns: [
        { data: "id" },
		{ data: "nombre_proveedor" },
        { data: "fecha" },
		{ "render": function (data, type, row){            
			return totalFormat(row.costo_total)
	   	}},
		{
			defaultContent: `<button type='button' name='editButton' class='btn btn-primary'>
                                  Editar
                                  <i class="fas fa-edit"></i>
                              </button>`,
		},
		{
			defaultContent: `<button type='button' name='show_buys' class='btn btn-primary'>
			                    Ver compra
			                   <i class="fas fa-edit"></i>
		                        </button>`,
		},
		
	],
});

$("#table-cost").on("click", "button", function () {
    let data = tabla.row($(this).parents("tr")).data();
    if ($(this)[0].name == "show_buys") {
	    $("#modalShowCost").modal("show");
        showBuys(data.id);
    } else{
        
		$(`.rowCostoEdit`).remove();
		$("#codeCost_edit").val(data.id);
		$("#dateCost_edit").val(data.fecha);
		$("#proveedor_edit").val(data.proveedor);
		$("#costEdit").modal("show");
		getCompras(data.proveedor);
		idSelectCosto_edit= 1;
		console.log(data.tipoProducto);
		tipoProveedor=data.tipoProducto;
	   
	}
});


const tabla_compras = $("#table-compras").DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columns: [
        { data: "tipoProducto" },
		{ data: "producto" },
        { data: "valor" },
        { data: "cantidad" },

		
		
	],
});


let supplier =[];



getSupplier = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}api/getSupplier`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
			let data = xhr.response;
			supplier= data;
			console.log(supplier);
			supplier.map((p) => {
				$(`#proveedor`).append(
					`<option value=${p.id}>${p.nombre}</option>`
				);
			})
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener los insumos",
			});
		}
	});
	xhr.send();
};





    
 $("#proveedor").change(function(){
	   
	    $(`.rowCosto`).remove();
		valor = $("#proveedor").val();
		let xhr = new XMLHttpRequest();
	    xhr.open("get", `${host_url}api/getProductSupplier/${valor}`);
	    xhr.responseType = "json";
	    xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
			$("#producto_1").empty();
			let data = xhr.response;
		
		     select_product=data;
			$(`#producto_1`).append(`<option value=""></option>`);
		    select_product.map((p) => {
				$(`#producto_1`).append(
					`<option value=${p.id}>${p.name}</option>`
				);
			})

			idSelectCosto= 1;
		    $("#valorinsumos_1").val("");
			$("#categoria_1").val("");
			
		} 
	});
	xhr.send();

   });

   $("#producto_1").change(function(){
	      
              valor = $("#producto_1").val();
			  if(valor ==""){
				$("#valorinsumos_1").val(""); 
			  }else{
			  select_product.forEach((item)=>{
                 if(item.id == valor ) 
				 $("#valorinsumos_1").val(item.precioVenta);
				 $(`#categoria_1`).val(item.idType);  
				
			  });
			}
    });

showBuys = (code) => {
	console.log(code);
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getBuys/${code}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
			
		    compras =xhr.response[0].compras;
            data = JSON.parse(compras);
            aux= data.insumos;
			aux.map((p)=>{
                if(p.tipoProducto == '1'){
                      p.tipoProducto= "Huevos";
				}else{
					p.tipoProducto= "Cigarros"
				}
			});
			tabla_compras.clear();
			tabla_compras.rows.add(aux);
			tabla_compras.draw();
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener costos ",
			});
		}
	});
	xhr.send();
};

getCost = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getCost`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
		    data =xhr.response;
			tabla.clear();
			tabla.rows.add(data);
			tabla.draw();
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener costos ",
			});
		}
	});
	xhr.send();
};

loadSelectProducto= () => {
	select_product.map((p) => {
		$(`#producto_${idSelectCosto}`).append(
			`<option value=${p.id}>${p.name}</option>`
		);
});

}
/*
<div class="col-md-3">
<select class="custom-select d-block w-100" name="select" id='insumos_${idSelectCosto}'>
  <option value="">Opciones...</option>
  <option value="1">Huevos</option>
   <option value="2">Cigarros</option>
  </select>
</div>*/


addRowCostos = () => {
	idSelectCosto++;
	$("#contCosto").append(`<div class="row mb-3 rowCosto" id="rowCosto_${idSelectCosto}">

	                             <input type="hidden" class="form-control" id="categoria_${idSelectCosto}">

								 <div class="col-md-3">
                                    <select class="custom-select d-block w-100 "  id='producto_${idSelectCosto}'>
                                        <option value=""></option>
                                    </select>
                                 </div>
                                
                                <div class="col-md-3">
                                    <input type="number" class="form-control"  min="1" pattern="^[0-9]+"  style="background:white" id="valorinsumos_${idSelectCosto}" placeholder="valor" aria-describedby="inputGroupPrepend3" disabled>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="number" min="0" class="form-control"   min="1" pattern="^[0-9]+" id="cantinsumos_${idSelectCosto}" placeholder="cantidad" aria-describedby="inputGroupPrepend3" onchange="changeTotalCostos(this)">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="totalinsumos_${idSelectCosto}" placeholder="Total" aria-describedby="inputGroupPrepend3" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>`);

loadSelectProducto();
	
$(`#producto_${idSelectCosto}`).change(function(){
	valor = $(`#producto_${idSelectCosto}`).val();
	if(valor==""){  $(`#valorinsumos_${idSelectCosto}`).val(""); }else{
	select_product.forEach((item)=>{
	   if(item.id == valor ) 
	   $(`#valorinsumos_${idSelectCosto}`).val(item.precioVenta); 
	   $(`#categoria_${idSelectCosto}`).val(item.idType);  
	    });
     }
});

};





changeTotalCostos = (element) => {

	let fila = element.id.split('_')[1];
	let value = element.value;
	if (value <= 0) {
		$(`#totalinsumos_${fila}`).val("0");
	} else {
		let valor = $(`#valorinsumos_${fila}`).val();
		$(`#totalinsumos_${fila}`).val(valor * value);
	}
	let total = 0;
	for (let i = 1; i <= idSelectCosto; i++) {
		let valor = parseInt($(`#totalinsumos_${i}`).val());
		if (isNaN(valor)) valor = 0;
		total += valor;
	}
	$(`#costoTotal`).val(total);

}


$("#removerCosto").on('click', () => {
	if (idSelectCosto == 1) {
		swal({
			title: "Error",
			icon: "error",
			text: "No se pueden eliminar todas las filas, el minimo es 1",
		});
	} else {
		$(`#rowCosto_${idSelectCosto}`).remove();
		idSelectCosto--;
		let total = 0;
		for (let i = 1; i <= idSelectCosto; i++) {
			let valor = parseInt($(`#totalinsumos_${i}`).val());
			if (isNaN(valor)) valor = 0;
			total += valor;
		}
		$(`#costoTotal`).val(total);
	     
	}
});



save_cost = () => { 

	let counterError =0;
	let cigarProduct =[];
	let eggsProduct=[];
	let insumosArray = [];
	repeat_eggs=false;
	repeat_cigar=false;
	if($(`#codeCost`).val()==""){counterError++ ; }
	if($(`#dateCost`).val()==""){counterError++ ; }
	if($(`#proveedor`).val()==""){counterError++ ; }

	for (let i = 1; i <= idSelectCosto; i++) {
		
        id_product=$(`#producto_${i} option:selected`).val();
        ip= parseInt(id_product);
		id_type=$(`#categoria_${i}`).val();
		it=parseInt(id_type);
	
		if($(`#producto_${i} option:selected`).val()==""){counterError++ ; }
		if($(`#valorinsumos_${i}`).val()==""){counterError++ ; }
		if($(`#cantinsumos_${i}`).val()==""){counterError++ ; }

		if(it === 2 ){ cigarProduct.push(ip); id_product=0; id_type=0; }else{
           if(it === 1){
			eggsProduct.push(ip); id_product=0; id_type=0;
		   }
		}
	
		let obj = {
			tipoProducto: $(`#categoria_${i}`).val(),
			producto: $(`#producto_${i} option:selected`).val(),
			valor: $(`#valorinsumos_${i}`).val(),
			cantidad: $(`#cantinsumos_${i}`).val(),
			total: $(`#totalinsumos_${i}`).val(),
			codigo:$(`#codeCost`).val(),
	
		};
		
		insumosArray.push(obj);
		
		console.log(insumosArray);
	
	} 

	if(counterError === 0){   // if que comprueba si algun tipo de producto se repite 
 
		result = _.sortBy(eggsProduct);
		result2 = _.sortBy(cigarProduct);
		for (let i = 0; i < result.length; i++) {
			if (result[i + 1] === result[i]) {
				repeat_eggs=true;
			}
		  }
		  for (let i = 0; i < result2.length; i++) {
			if (result2[i + 1] === result2[i]) {
				repeat_cigar=true;
			}
		  }

    if(repeat_eggs == false && repeat_cigar == false ){ // si no se repite nada avanza al registro de compras
	
		//enviar(0,insumosArray);

	//registerBuys(insumosArray);

	let buys = {
		insumos: insumosArray,
	};

	

	
	let data = {
        productos: JSON.stringify(insumosArray),
		compras: JSON.stringify(buys),
		proveedor: $("#proveedor").val(),
		codigo: $(`#codeCost`).val(),
		total_costos: $("#costoTotal").val(),
		fecha: $("#dateCost").val(),
	};
    console.log(data);
    $.ajax({
		data: {
			data 
		},
		type: "POST",
		url: host_url + "api/createCost",
		
		crossOrigin: false,
		dataType: "json",
		success: result => {
			swal({
				title: "Éxito!",
				icon: "success",
				text: "Costo guardado con éxito",
				button: "OK"
			}).then(() => {
				getCost();

			});
		},
		error: (result) => {
			swal({
				title: "Error",
				icon: "error",
				text: result.responseJSON.msg,
			});
		}
	});

    }else{
	     swal({
	     title: "Error",
	     icon: "error",
	     text: "Hay productos repetidos. Verifique que solo haya un unico producto por tipo."
    });
    }

}else{

	swal({
		title: "Error",
		icon: "error",
		text: "Complete todos los campos vacios!."
	});  
}	
}



registerBuys= (buys) =>{

	for ( let i = 0; i < buys.length; i++){
      
	data =  { 
		    tipoProducto: buys[i].tipoProducto,   
		    producto: buys[i].producto,          //huevoid 
		    valor:buys[i].valor,                //premioCompra  
		    cantidad:buys[i].cantidad ,    // cantidad 
			total:buys[i].total,           //total
			codigo: $("#codeCost").val()   //costoId
			}

			console.log(data);
  
		$.ajax({
			data: {
				data
			},
			
			type: "POST",
			url: host_url + "api/insertBuy",
			crossOrigin: false,
			dataType: "json",
			success: result => {
				console.log("guardado");
			},
			error: (result) => {
				console.log("error");
			}
		}); 
	 }
};




enviar= (i ,buys) => { 
	// Es importante notar que estamos utilizando jQuery
	if(i < buys.length){ 
	
		data =  { 
		tipoProducto: buys[i].tipoProducto,   
		producto: buys[i].producto,          //huevoid 
		valor:buys[i].valor,                //premioCompra  
		cantidad:buys[i].cantidad ,    // cantidad 
		total:buys[i].total,           //total
		codigo: $("#codeCost").val()   //costoId
		}
		$.ajax({
			data: {
				data
			},
			
			type: "POST",
			url: host_url + "api/insertBuy",
			crossOrigin: false,
			dataType: "json",
       	}).done(function() {
			console.log("hecho");
			enviar(i + 1 , buys);
		});

			
		
  }
}

  


  



$("#btn_modal_register").on('click', ()=> { 
    $("#registerCost").modal("show");
});

$("#tr_btn_add").on("click", addRowCostos);

$("#btn_register_cost").on("click", save_cost);



$("#dateCost").datepicker({
	showOn: "button",
	buttonText: "Calendario",
	changeMonth: true,
	changeYear: true,
	dateFormat: 'yy-mm-dd',
	buttonImage: host_url + 'assets/img/about/calendario2.png',
});

/* Función que devuelve el total de la compra de un cliente en formato CLP*/
totalFormat = (total) => {
    const formatterPeso = new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 0
      })
    return formatterPeso.format(total);
}
