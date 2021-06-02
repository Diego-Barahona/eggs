$(() => {

    getSupplier_edit();
    
    
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
   let select_product_edit = [];
   let idSelectCosto_edit= 1;
   let idProveedor = 0;

   
   
   
  

   getCompras = (idPRoveedor) => { 
	idProveedor = idPRoveedor;
	getProductBySup(idPRoveedor);
	let id = $("#codeCost_edit").val();
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}api/getBuys/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            compras =xhr.response[0].compras;
            data = JSON.parse(compras);
            aux= data.insumos;
           
		    rellenarCampos(aux, idPRoveedor);
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


rellenarCampos=(compras, idProveedor)=> { 
    
    
	for (let i = 0; i < compras.length; i++) {
		let currentCosto = compras[i];
        $(`#categoriaEdit_${idSelectCosto_edit}`).val(currentCosto.tipoProducto)
		$(`#valorinsumosEdit_${idSelectCosto_edit}`).val(currentCosto.valor)
		$(`#cantinsumosEdit_${idSelectCosto_edit}`).val(currentCosto.cantidad)
		$(`#totalinsumosEdit_${idSelectCosto_edit}`).val(currentCosto.valor * currentCosto.cantidad)
		$(`#productoEdit_${idSelectCosto_edit}`).val(currentCosto.producto)
		if ((i+1) < compras.length) {
			addRowCostosEdit(idProveedor);
		}
	
        
	}
	total = 0;
	for (let i = 1; i <= idSelectCosto_edit ; i++) {
		let valor = parseInt($(`#totalinsumosEdit_${i}`).val());
		if (isNaN(valor)) valor = 0;
		total += valor;
	}
	$(`#costoTotal_Edit`).val(total); 

}
   
   
   let supplier_edit =[];
   
   getSupplier_edit = () => { // carga de proveedores 
       let xhr = new XMLHttpRequest();
       xhr.open("get", `${host_url}api/getSupplier`);
       xhr.responseType = "json";
       xhr.addEventListener("load", () => {
           if (xhr.status === 200) {
               let data = xhr.response;
               supplier_edit= data;
               console.log(supplier_edit);
               supplier_edit.map((p) => {
                   $(`#proveedor_edit`).append(
                       `<option value=${p.id}>${p.nombre}</option>`
                   );
               })
           } else {
               swal({
                   title: "Error",
                   icon: "error",
                   text: "Error al obtener los insums",
               });
           }
       });
       xhr.send();
   };



   getProductBySup=(valor)=>{ // productos proveedor
	console.log(valor);
	console.log(select_product_edit);

	$.ajax({
        type: "GET",
        url: `${host_url}api/getProductSupplier/${valor}`,
        dataType: "json",
        success: (xhr) => {
            let data = xhr;
			
        	$("#productoEdit_1").find('option').remove();
         	select_product_edit=data;
			 
         	select_product_edit.map((p) => {
            $(`#productoEdit_1`).append(
                `<option value=${p.id}>${p.name}</option>`
            );
         	});
		}
    }); 
	console.log(select_product_edit); 
}







   $("#proveedor_edit").change(function(){
	select_product_edit = [];  
    $(`.rowCostoEdit`).remove();
    valor = $("#proveedor_edit").val();
	idProveedor = valor;
    let xhr = new XMLHttpRequest();
    xhr.open("get", `${host_url}api/getProductSupplier/${valor}`);
    xhr.responseType = "json";
    xhr.addEventListener("load", () => {
    if (xhr.status === 200) {
        $("#productoEdit_1").empty();
        let data = xhr.response;
    
         select_product_edit=data;
        
        
        $(`#productoEdit_1`).append(`<option value=""></option>`);
        select_product_edit.map((p) => {
            $(`#productoEdit_1`).append(
                `<option value=${p.id}>${p.name}</option>`
            );
        })

        idSelectCosto_edit= 1;
        $("#valorinsumosEdit_1").val("");
        $("#cantinsumosEdit_1").val("");
        $("#categoriaEdit_1").val("");
        
    } 
});
xhr.send();

});

$("#productoEdit_1").change(function(){
      
          valor = $("#productoEdit_1").val();
          if(valor ==""){
            $("#valorinsumosEdit_1").val(""); 
          }else{
          select_product_edit.forEach((item)=>{
             if(item.id == valor ) 
             $("#valorinsumosEdit_1").val(item.precioVenta);
             $(`#categoriaEdit_1`).val(item.idType);  
            
          });
        }
});


let cont = 0;
   loadSelectProductoEdit= (idProveedor) => {
	console.log(cont+1);
	console.log(idSelectCosto_edit);
	$.ajax({
		type: "GET",
		url: `${host_url}api/getProductSupplier/${idProveedor}`,
		dataType: "json",
		async: false,
		success: (xhr) => {
			xhr.map((p) => {
				console.log(idSelectCosto_edit);
				$(`#productoEdit_${idSelectCosto_edit}`).append(
					`<option value=${p.id}>${p.name}</option>`
				);
			});
		
		}
	}); 
  }



   addRowCostosEdit = (idProveedor) => {
	console.log(idProveedor);
	idSelectCosto_edit++;
	console.log(idSelectCosto_edit);
	$("#contCostoEdit").append(`<div class="row mb-3 rowCostoEdit" id="rowCostoEdit_${idSelectCosto_edit}">

	                             <input type="hidden" class="form-control" id="categoriaEdit_${idSelectCosto_edit}">

								 <div class="col-md-3">
                                    <select class="custom-select d-block w-100 "  id='productoEdit_${idSelectCosto_edit}'>
                                        <option value=""></option>
                                    </select>
                                 </div>
                                
                                <div class="col-md-3">
                                    <input type="number" class="form-control"  min="1" pattern="^[0-9]+"  style="background:white" id="valorinsumosEdit_${idSelectCosto_edit}" placeholder="valor" aria-describedby="inputGroupPrepend3" disabled>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="number" min="0" class="form-control"   min="1" pattern="^[0-9]+" id="cantinsumosEdit_${idSelectCosto_edit}" placeholder="cantidad" aria-describedby="inputGroupPrepend3" onchange="changeTotalCostosEdit(this)">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="totalinsumosEdit_${idSelectCosto_edit}" placeholder="Total" aria-describedby="inputGroupPrepend3" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>`);

loadSelectProductoEdit(idProveedor);


	
$(`#productoEdit_${idSelectCosto_edit}`).change(function(){
	valor = $(`#productoEdit_${idSelectCosto_edit}`).val();
	if(valor==""){  $(`#valorinsumosEdit_${idSelectCosto_edit}`).val(""); }else{
	select_product_edit.forEach((item)=>{
	   if(item.id == valor ) 
	   $(`#valorinsumosEdit_${idSelectCosto_edit}`).val(item.precioVenta); 
	   $(`#categoriaEdit_${idSelectCosto_edit}`).val(item.idType);  
	    });
     }
});

};


changeTotalCostosEdit = (element) => {

	let fila = element.id.split('_')[1];
	let value = element.value;
	if (value <= 0) {
		$(`#totalinsumosEdit_${fila}`).val("0");
	} else {
		let valor = $(`#valorinsumosEdit_${fila}`).val();
		$(`#totalinsumosEdit_${fila}`).val(valor * value);
	}
	let total = 0;
	for (let i = 1; i <= idSelectCosto_edit; i++) {
		let valor = parseInt($(`#totalinsumosEdit_${i}`).val());
		if (isNaN(valor)) valor = 0;
		total += valor;
	}
	$(`#costoTotal_Edit`).val(total);

}


$("#removerCosto_Edit").on('click', () => {
	if (idSelectCosto_edit == 1) {
		swal({
			title: "Error",
			icon: "error",
			text: "No se pueden eliminar todas las filas, el minimo es 1",
		});
	} else {
		$(`#rowCostoEdit_${idSelectCosto_edit}`).remove();
		idSelectCosto_edit--;
		let total = 0;
		for (let i = 1; i <= idSelectCosto_edit; i++) {
			let valor = parseInt($(`#totalinsumosEdit_${i}`).val());
			if (isNaN(valor)) valor = 0;
			total += valor;
            console.log(total);
		}

		$(`#costoTotal_Edit`).val(total);
	     
	}
});


save_cost = () => { 

	let counterError =0;
	let cigarProduct =[];
	let eggsProduct=[];
	let insumosArray = [];
	repeat_eggs=false;
	repeat_cigar=false;
	if($(`#codeCost_edit`).val()==""){counterError++ ; }
	if($(`#dateCost_edit`).val()==""){counterError++ ; }
	if($(`#proveedor_edit`).val()==""){counterError++ ; }

	for (let i = 1; i <= idSelectCosto_edit; i++) {
		
        id_product=$(`#productoEdit_${i} option:selected`).val();
        ip= parseInt(id_product);
		id_type=$(`#categoriaEdit_${i}`).val();
		it=parseInt(id_type);
	
		if($(`#productoEdit_${i} option:selected`).val()==""){counterError++ ; }
		if($(`#valorinsumosEdit_${i}`).val()==""){counterError++ ; }
		if($(`#cantinsumosEdit_${i}`).val()==""){counterError++ ; }

		if(it === 2 ){ cigarProduct.push(ip); id_product=0; id_type=0; }else{
           if(it === 1){
			eggsProduct.push(ip); id_product=0; id_type=0;
		   }
		}
	
		let obj = {
			tipoProducto: $(`#categoriaEdit_${i}`).val(),
			producto: $(`#productoEdit_${i} option:selected`).val(),
			valor: $(`#valorinsumosEdit_${i}`).val(),
			cantidad: $(`#cantinsumosEdit_${i}`).val(),
			total: $(`#totalinsumosEdit_${i}`).val(),
			codigo:$(`#codeCost_edit`).val(),
	
		};
		
		insumosArray.push(obj);
		
		console.log(insumosArray);
	
	} 

	if(counterError === 0){   
      
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
		proveedor: $("#proveedor_edit").val(),
		codigo: $(`#codeCost_edit`).val(),
		tipoProveedor: tipoProveedor,
		tipoProveedorNuevo: $("#categoriaEdit_1").val(),
		total_costos: $("#costoTotal_Edit").val(),
		fecha: $("#dateCost_edit").val(),
	};

    console.log(data.compras);

    $.ajax({
		data: {
			data 
		},
		type: "POST",
		url: host_url + "api/editCost",
		
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
                $("#costEdit").modal("hide");

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




$("#tr_btn_add_Edit").on("click", () => {addRowCostosEdit(idProveedor)});
$("#btn_Edit_cost").on("click", save_cost);
   
   
   
   $("#dateCost_edit").datepicker({
       showOn: "button",
       buttonText: "Calendario",
       changeMonth: true,
       changeYear: true,
       dateFormat: 'yy-mm-dd',
       buttonImage: host_url + 'assets/img/about/calendario2.png',
   });
   
   