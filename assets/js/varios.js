(function ($) {
	$("#paisEnvio").on("change", function (e) {
		var paisID = $(this).val();

		var info = { pais: paisID };

		$.ajax({
			type: "POST",
			url: BASE_URL + "usuarios/lista_estados",
			data: info,
			success: function (html) {
				$("#estadoEnvio").html(html);
				$("#estadoEnvio").trigger("change");
			},
		});

		e.stopPropagation();
	});

	$("#paisCheck").on("change", function (e) {
		var paisID = $(this).val();

		var info = { pais: paisID };

		$.ajax({
			type: "POST",
			url: BASE_URL + "usuarios/lista_estados",
			data: info,
			success: function (html) {
				$("#estadoCheck").html(html);
				$("#estadoCheck").trigger("change");
			},
		});

		e.stopPropagation();
	});

	$("#estadoEnvio").on("change", function (e) {
		var estadoID = $(this).val();

		var info = { estado: estadoID };

		$.ajax({
			type: "POST",
			url: BASE_URL + "usuarios/lista_ciudades",
			data: info,
			success: function (html) {
				log(html);
				$("#ciudadEnvio").html(html);
			},
		});

		e.stopPropagation();
	});

	$("#estadoCheck").on("change", function (e) {
		var estadoID = $(this).val();

		var info = { estado: estadoID };

		$.ajax({
			type: "POST",
			url: BASE_URL + "usuarios/lista_ciudades",
			data: info,
			success: function (html) {
				$("#ciudadCheck").html(html);
			},
		});

		e.stopPropagation();
	});

	$("#frmSuscripcion").submit(function (e) {
		e.preventDefault();

		$.ajax({
			data: $(this).serialize(),
			url: $(this).attr("action"),
			type: $(this).attr("method"),
		}).done(function (data) {
			$("#suscribeModal").modal();
		});
		e.stopPropagation();
	});

	$("#frmNovedades").submit(function (e) {
		e.preventDefault();

		$.ajax({
			data: $(this).serialize(),
			url: $(this).attr("action"),
			type: $(this).attr("method"),
		}).done(function (data) {
			$("#suscribeModal").modal();
		});

		e.stopPropagation();
	});

	// Formulario de contacto
	$("#frmContacto").submit(function (e) {
		e.preventDefault();

		$.ajax({
			data: $(this).serialize(),
			url: $(this).attr("action"),
			type: $(this).attr("method"),
		}).done(function (data) {
			$("#contactModal").modal();
		});
		e.stopPropagation();
	});

	$("#frmRegistro").submit(function (e) {
		var clave1 = $("[name=pwd_usuario]").val();
		var clave2 = $("[name=pwd2_usuario]").val();

		if (clave1 != clave2) {
			e.preventDefault();
			$("#tituloMsgError").html("Error en los datos");
			$("#msgError").html("Las contraseñas no coinciden");
			$("#errorIngresoModal").modal();
		} else {
			$.ajax({
				data: $(this).serialize(),
				url: $(this).attr("action"),
				type: $(this).att("method"),
			}).done(function (data) { });
		}
		e.stopPropagation();
	});

	$("#frmForgot").submit(function (e) {
		e.preventDefault();
		$.ajax({
			data: $(this).serialize(),
			url: $(this).attr("action"),
			type: $(this).attr("method"),
		}).done(function (response) {
			$("#tituloMsgError").html("Recuperaci&oacute;n de contrase&ntilde;a");
			$("#msgError").html(response);
			$("#errorIngresoModal").modal();
		});
		e.stopPropagation();
	});

	// Actualizar carrito de compras
	// Añadir item al carro (detalle del producto)
	$(".btn-addcart").click(function (e) {
		e.preventDefault();
		let cantidad = $(".cart-count").html();
		console.log(cantidad);

		if (!cantidad) {
			cantidad = 0;
		}
		//var codigo = $(".product-title").html().trim();
		const codigo = $(this).parent().parent().parent().find(".product-title").html().trim();
		const descripcion = $(this).parent().parent().parent().find(".product-descripcion").html().trim();

		var adicionar = 0;
		console.log("Precio: ", $(this).parent().parent().parent().find(".product-price").html().replace(",", "."));

		let precio = parseFloat($(this).parent().parent().parent().find(".product-price").html().trim().replace(",", "."));
		let impuesto = 0; //parseInt($("#frmImpuestoItem").val());

		console.log(codigo + " " + cantidad.toString() + " " + precio.toString());
		console.log("Recibiendo: " + $("#hid-producto").val());
		console.log("Antes de entrar " + adicionar);
		if ($("#hid-producto").val() === "pulsos") {
			let listaAgregar = codigo.trim();

			let totalCalibres = $("#totalListaCalibres").val();

			if (totalCalibres > 0) {
				listaAgregar += "_";
				adicionar = 0;
				for (let i = 0; i < totalCalibres; i++) {
					if ($("#cantidades" + i).val()) {
						if ($("#cantidades" + i).val() != "0") {
							listaAgregar +=
								$("#calibres" + i).html() +
								"." +
								$("#cantidades" + i).val() +
								";";
							adicionar += parseInt($("#cantidades" + i).val());
						}
					}
				}
			}

			$("#frmCodItem").val(listaAgregar.trim());
		} else {
			console.log("Como hay error se va por aquí");
			adicionar = parseInt($(this).parent().parent().find(".item-cart").val());
		}

		console.log("El valor a adicionar es " + adicionar);

		if (adicionar < 20) {
			swal.fire(codigo, "Ingrese la cantidad a pedir (mínimo 20 unidades)", "error");
			return;
		}

		let datos = {
			coditem: codigo,
			cantidad: adicionar,
			precio: precio,
			impuesto: 0,
			descripcion: descripcion,
		};

		$.ajax({
			data: datos, //$("#form-detalle").serialize(),
			url: $("#form-detalle").attr("action"),
			type: $("#form-detalle").attr("method"),
			success: function (response) {
				//console.log("Recibiendo... ", response);
				$(".cart-total-price").html("$" + response.split("___")[1]);
				$(".dropdown-cart-products").html(response.split("___")[0]);
			},
			error: function (error) {
				console.log("Se presentó el siguiente error: " + error);
			},
		}).done(function (data) {
			if (adicionar >= 20) {
				$(".cart-count").html(parseInt(cantidad) + parseInt(adicionar));
				//console.log('El pedido es: ' + listaAgregar);
				swal.fire(codigo, "fue añadido al carrito", "success");
			} else {
				swal.fire(codigo, "Ingrese la cantidad a pedir (mínimo 20 unidades)", "error");
			}
		});
		e.stopPropagation();
	});
})(jQuery);
