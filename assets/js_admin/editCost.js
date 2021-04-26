




getCompras = () => {
	let id = $("#invisible").val();
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}api/getCotizacionById/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
			let data = xhr.response;
			rellenarCampos(data[0])
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


rellenarCampos=(data)=> { 
    let utili = JSON.parse(data);
    $(`#totalfinalmaterial`).val(total);
	for (let i = 0; i < utili.insumos.length; i++) {
		let currentUtili = utili.insumos[i];
		$(`#insumos_${idSelectInsumos}`).val(currentUtili.id)
		$(`#unidadinsumos_${idSelectInsumos}`).val(currentUtili.unidad)
		$(`#valorinsumos_${idSelectInsumos}`).val(currentUtili.valor)
		$(`#cantinsumos_${idSelectInsumos}`).val(currentUtili.cantidad)
		$(`#totalinsumos_${idSelectInsumos}`).val(currentUtili.valor * currentUtili.cantidad)
		if ((i + 1) < utili.insumos.length) {
			addRowInsumos();
		}
	}
	total = 0;
	for (let i = 1; i <= idSelectInsumos; i++) {
		let valor = parseInt($(`#totalinsumos_${i}`).val());
		if (isNaN(valor)) valor = 0;
		total += valor;
	}
	$(`#totalfinalinsumos`).val(total);

}
