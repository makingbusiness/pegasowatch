(function ($) {

	/*window.addEventListener('resize', function() {
		console.log('Imagen en pantalla ',$('#hidBanner').val());
		alert($('#hidBanner').val());
	});*/

	$(".owl-carousel").owlCarousel({
		autoWidth: true,
		items: 5,
		loop: false,
		dots: true
	});

	// Formulario de contacto

	$('#form_contacto').submit(function (e) {
		e.preventDefault();

		console.log('Cargando formulario de contacto', CLAVE_SITIO_RECAPTCHA);

		grecaptcha.ready(function () {
			grecaptcha.execute(CLAVE_SITIO_RECAPTCHA, { action: 'registro' }).then(function (token) {
				console.log('El token es: ', token);
				$('#form_contacto').prepend('<input type="hidden" name="token" value="' + token + '">');
				$('#form_contacto').prepend('<input type="hidden" name="action" value="registro">');
				$('#form_contacto').unbind('submit').submit();
			});
		});

		/*$.ajax({
			data: $(this).serialize(),
			url: $(this).attr('action'),
			type: $(this).attr('method')
		}).done(function (data) {
			swal($('#name_contact').val(), "Recibimos su mensaje", "success");
		});
*/
		e.stopPropagation();
	});

	// Realiza suscripcion a boletines
	$('#form_suscripcion').submit(function (e) {
		e.preventDefault();

		$.ajax({
			data: $(this).serialize(),
			url: $(this).attr('action'),
			type: $(this).attr('method')
		}).done(function (data) {
			swal($('#nombre_suscrip').val(), "Gracias por suscribirse", "success");
		});
		e.stopPropagation();
	});

	//  Formulario de actualización de datos del usuario
	$('#edit-profile').submit(function (e) {
		e.preventDefault();

		$.ajax({
			data: $(this).serialize(),
			url: $(this).attr('action'),
			type: $(this).attr('method')
		}).done(function (data) {
			swal("Gracias", "Sus datos fueron actualizados", "success");
		});
		e.stopPropagation();
	});

	// Recuperación de clave de ingreso del usuario
	$('#form_recuperar').submit(function (e) {
		e.preventDefault();

		$.ajax({
			data: $(this).serialize(),
			url: $(this).attr('action'),
			type: $(this).attr('method')
		}).done(function (data) {
			swal("Gracias", "Enviamos los datos de ingreso a su correo", "success");
		});
		e.stopPropagation();
	});

	// Añadir items del carro
	$('.block2-btn').each(function () {
		console.log('Guardando');
		$(this).on('click', function (e) {
			e.preventDefault();
			var cantidad = parseInt($('.header-icons-noti').html());
			var codigo = $(this).parent().parent().parent().parent().parent().find('.block2-item').html();

			$.ajax({
				data: $(this).parent().parent().parent().parent().serialize(),
				url: $(this).parent().parent().parent().parent().attr('action'),
				type: $(this).parent().parent().parent().parent().attr('method'),
				success: function (response) {
					$('.header-cart-total').html('Total: $' + response.split('___')[1]);
					$('.header-cart-wrapitem').html(response.split('___')[0]);
					$('.header-cart-wrapbtn').html('<a href="' + BASE_URL + 'cart" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text14 trans-0-4">Ir al carrito</a>');
				}
			}).done(function (data) {
				console.log(data);
				$('.header-icons-noti').html(cantidad + 1);
				swal(codigo, "fue añadido al carrito", "success");
			});
			e.stopPropagation();
		});
	});

	// Añadir item al carro (detalle del producto)
	$('.btn-addcart').click(function (e) {
		e.preventDefault();
		console.log('Solo para verificar....' + $('.ref-item').html());
		var cantidad = parseInt($('.header-icons-noti').html());
		var codigo = $('.ref-item').html();
		var adicionar = 0;//parseInt($(this).parent().parent().find('.num-product').val());
		let precio = parseInt($('#frmPrecioItem').val());
		let impuesto = parseInt($('#frmImpuestoItem').val());

		console.log('Recibiendo: ' + $('#hid-producto').val());
		console.log('Antes de entrar ' + adicionar);
		if ($('#hid-producto').val() === 'pulsos') {
			let listaAgregar = codigo.trim();

			let totalCalibres = $('#totalListaCalibres').val();

			if (totalCalibres > 0) {
				listaAgregar += '_';
				adicionar = 0;
				for (let i = 0; i < totalCalibres; i++) {
					if ($('#cantidades' + i).val()) {
						if ($('#cantidades' + i).val() != '0') {
							listaAgregar += $('#calibres' + i).html() + '.' + $('#cantidades' + i).val() + ';';
							adicionar += parseInt($('#cantidades' + i).val());
						}
					}
				}
			}

			$('#frmCodItem').val(listaAgregar.trim());
		}
		else {
			adicionar = parseInt($(this).parent().parent().find('.num-product').val());
		}

		console.log('El valor a adicionar es ' + adicionar);

		$.ajax({
			data: $('#form-detalle').serialize(),
			url: $('#form-detalle').attr('action'),
			type: $('#form-detalle').attr('method'),
			success: function (response) {
				//console.log(response);
				$('.header-cart-total').html('Total: $' + response.split('___')[1]);
				$('.header-cart-wrapitem').html(response.split('___')[0]);
				$('.header-cart-wrapbtn').html('<a href="' + BASE_URL + 'cart" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text14 trans-0-4">Ir al carrito</a>');
			},
			error: function (error) {
				console.log('Se presentó el siguiente error: ' + error);
			}
		}).done(function (data) {
			if (adicionar > 0) {
				$('.header-icons-noti').html(cantidad + adicionar);
				//console.log('El pedido es: ' + listaAgregar);
				swal(codigo, "fue añadido al carrito", "success");
			}
			else {
				swal(codigo, 'Ingrese la cantidad a pedir', "error");
			}
		});
		e.stopPropagation();
	});

	// Actualizar cantidad de un item en el carrito (-)
	$('.btn-num-product-down').each(function () {
		$(this).on('click', function (e) {
			e.preventDefault();
			var cantidad = parseInt($(this).parent().find('.num-product').val()) - 1;

			if (cantidad < 0) return;

			var precio = parseInt($(this).parent().parent().parent().find('.precio-unit').html().replace('$', ''));
			var impuesto = parseInt($(this).closest('td').find('input:hidden:first').val());

			var totalItems = parseInt($('.header-icons-noti:first').text());
			var totalValor = parseInt($('#sub-carrito').text().replace('$', ''));
			var totalImp = parseInt($('#imp-carrito').text().replace('$', ''));

			var total = precio * cantidad;

			var totalNuevo = totalValor - precio + impuesto;
			var impNuevo = totalImp - impuesto;

			if (totalNuevo < 0) {
				totalNuevo = 0;
				impNuevo = 0;
			}

			if (totalNuevo == 0 && impNuevo > 0) {
				impNuevo = 0;
			}

			$('.header-icons-noti').text(totalItems - 1);
			$('#sub-carrito').text('$' + totalNuevo);
			$('#imp-carrito').text('$' + impNuevo);
			$('#total-carrito').text('$' + (totalNuevo + impNuevo));

			$(this).parent().parent().parent().find('.subtotal-unit').html(total);

			var numProduct = Number($(this).next().val());
			if (numProduct > 0) $(this).next().val(numProduct - 1);

			var info = {
				'rowid': $(this).parent().parent().find('.row-cart').val(),
				'qty': cantidad
			};

			$.ajax({
				data: info,//.serialize(),
				url: $('#forma_carro').attr('action'),
				type: $('#forma_carro').attr('method'),
				success: function (response) {
					$(this).parent().parent().parent().parent().parent().parent().parent().parent().find('.header-wrapicon2').html(response);
				}
			});

			e.stopPropagation();
		});
	});

	$('.btn-num-product-up').each(function () {
		$(this).on('click', function (e) {
			e.preventDefault();

			var cantidad = parseInt($(this).parent().find('.num-product').val()) + 1;

			var precio = parseInt($(this).parent().parent().parent().find('.precio-unit').html().replace('$', ''));
			var impuesto = parseInt($(this).closest('td').find('input:hidden:first').val());

			var totalItems = parseInt($('.header-icons-noti:first').text());
			var totalValor = parseInt($('#sub-carrito').text().replace('$', ''));
			var totalImp = parseInt($('#imp-carrito').text().replace('$', ''));

			var total = precio * cantidad;

			var totalNuevo = totalValor + precio - impuesto;
			var impNuevo = totalImp + impuesto;

			$('.header-icons-noti').text(totalItems + 1);
			$('#sub-carrito').text('$' + totalNuevo);
			$('#imp-carrito').text('$' + impNuevo);
			$('#total-carrito').text('$' + (totalNuevo + impNuevo));

			$(this).parent().parent().parent().find('.subtotal-unit').html(total);

			var numProduct = Number($(this).prev().val());
			if (numProduct >= 0) $(this).prev().val(numProduct + 1);

			var info = {
				'rowid': $(this).parent().parent().find('.row-cart').val(),
				'qty': cantidad
			};

			$.ajax({
				data: info,//.serialize(),
				url: $('#forma_carro').attr('action'),
				type: $('#forma_carro').attr('method'),
				success: function (response) {
					$(this).parent().parent().parent().parent().parent().parent().parent().parent().find('.header-wrapicon2').html(response);
				}
			});

			e.stopPropagation();
		});
	});

	$('.btn-registro-compra').click(function (e) {
		e.preventDefault();
		var url = "./login";
		$(location).attr('href', url);
		e.stopPropagation();
	});

	$('#btn-pago').click(function (e) {
		//e.preventDefault();
		var info = {
			'rowid': "Prueba de pedido temporal",
			'qty': "100"
		};

		$.ajax({
			data: info,
			type: $('#form-pago').attr('method'),
			url: $('#form-pago').attr('action')
		});

		e.stopPropagation();
	});

	$('#btnFinCompra').click(function (e) {
		//e.preventDefault();
		var info = { tipo: 0, observaciones: 'PAGO POR EL SITIO.' };
		console.log('Cargar opciones de pago ' + info);

		$.ajax({
			data: info,
			type: $('#frmFinPedido').attr('method'),
			url: $('#frmFinPedido').attr('action'),
			success: function (result) {
				console.log(result);
			}
		});
	});

	$('#btnEnviarPedido').click(function (e) {
		//e.preventDefault();
		var info = { tipo: 1, observaciones: 'PEDIDO DESDE EL SITIO.' };
		console.log('Enviar pedido tipo ' + $('#frmEnvioPedido').attr('action'));

		$.ajax({
			data: info,
			type: 'POST',
			url: BASE_URL + 'pedidos/guardar_pedido/1',
			success: function (result) {
				console.log(result + ' para el tipo ' + info);
				swal('Recibimos su pedido', 'Para ciudades principales, el pedido se entrega en 2 días hábiles. Para ciudades intermedias, el pedido se entrega máximo en 5 díaas hábiles');
				setTimeout(function () {
					$('#btnActualizarCarro').trigger('click')
				}, 5000);
			},
			error: function (error) {
				console.log('Pues había un error ' + error);
			}
		});
	});

	$("#frm-cambioClave").submit(function (e) {
		e.preventDefault();
		var clave = $('#claveNueva').val();
		var clave2 = $('#verificarClave').val();

		if (clave != clave2) {
			swal("Las claves ingresadas no coinciden");
		}
		else {
			$.ajax({
				data: $(this).serialize(),
				url: $(this).attr('action'),
				type: $(this).attr('method'),
				success: function (response) {
					if (response == 'N') swal('La clave anterior no coincide con la registrada');
					else swal('Datos actualizados');
				}
			});
		}
		e.stopPropagation();
	});

	$('.slick3').on('afterChange', function (event, slick, currentSlide, nextSlide) {
		var partes = $(slick.$slides[currentSlide]).data('thumb').split('/');
		var imagen = partes[partes.length - 1];
		//var parte = imagen.split('.')[0];

		$('.ref-item').html(imagen.substring(0, imagen.length - 4));
		$('.product-detail-name').html(imagen.substring(0, imagen.length - 4));
		//$('.det-item').html('');

		var info = {
			'parte': imagen.substring(0, imagen.length - 4)
		};

		$.ajax({
			data: info,
			type: 'POST',
			url: BASE_URL + 'productos/mostrar_tabla_calibres',
			success: function (r) {
				console.log(r);
				if (r.includes('___')) {
					partes = r.split('___');

					$('#frmCodItem').val(partes[0]);
					$('#descripcion').val(partes[1]);
					$('#frmPreciotem').val(partes[4]);
					$('#frmImpuestotem').val(partes[5]);

					$('.det-item').text(partes[1]);
					//$('.det-item').text(partes[2]);
					$('.ampl-item').html(partes[3]);
					precio = Math.round(parseFloat(partes[4]) * (1 + parseFloat(partes[5]) / 100));
					formateado = new Intl.NumberFormat('en-US');
					$('.precio-unit').html('$' + formateado.format(precio) + ' COP');
				}
				else {
					$('#item-calibre').html(r);
					$('#coditem').val(imagen.substring(0, imagen.length - 4));
					$('#tabla_calibres').html(r);

					$('#hid-producto').val('pulsos');
				}
			}
		});

		event.stopPropagation();
	});

	$('#btn-solicitar').click(function (e) {
		e.preventDefault();

		if (!$('#datos_codigo').val()) {
			swal('Ingrese el dato para búsqueda');
			return;
		}
		var info = { 'dato': $('#datos_codigo').val() };

		$.ajax({
			data: info,
			type: 'POST',
			url: BASE_URL + 'login/consulta_cliente',
			success: function (r) {
				r = r.split('.')[0];
				console.log(r);
				//if (!r.includes('_'))
				{
					swal(r);//'En un momento recibirá un código de ingreso al correo y celular que tenemos registrado.');
				}
				/*else
				{
					console.log(r);
					swal(r.split('_')[0],r.split('_')[1],'success');
				}*/
			}
		});
	});

	$('#btn-enviar').on('click', function (e) {
		e.preventDefault();
		//			console.log('Enviando pedido');
		swal('Su pedido ha sido enviado', 'Pronto estaremos enviándolo', 'success');
	});

	//$('.img-adicional').on('click', function () {
	// Se deefine el evento clic de los elementos del panel lateral a un nivel superior, para luego delegarlo en los elementos derivados
	$('.caja-izq').on('click', '.img-adicional', function () {
		//console.log('La nueva imagen a mostrar es ', $(this).attr('src'));
		nuevaImg = $(this).attr('src');
		$('.img-ampliada').replaceWith(`<img class="img-ampliada" src="${nuevaImg}" alt="'img'">`);
	});

	$('.img-carousel').on('click', function () {
		//console.log('src=',$(this).attr('src'));
		nuevaImg = $(this).attr('src');

		const partes = nuevaImg.split('/');
		const partesRef = partes[partes.length - 1].split('.');
		let codigo = partesRef[0];

		const extension = partesRef[partesRef.length-1];

		const adicional = nuevaImg.includes('texturas') ? nuevaImg.replace('texturas','adicionales').replace('.' + extension, '-A.png') : nuevaImg;
		const principal = nuevaImg.includes('texturas') ? nuevaImg.replace('texturas/','').replace( extension, 'png') : nuevaImg;

		//console.log(adicional,' !!! ',principal);
		$('.img-ampliada').replaceWith(`<img class="img-ampliada" src="${adicional}" alt="'img'">`);

		for (let y = 1; y < partesRef.length - 1; y++) {
			codigo += '.' + partesRef[y];
		}

		console.log('El código final es ', codigo);

		$.ajax({
			url: BASE_URL + `productos/imagen_adicional/${codigo}`,
			success: function (imagenes) {
				//console.log('Resultado consulta: ', imagenes);
				defProducto = imagenes.split('__');

				lista = defProducto[0].split(';');
				infoProducto = defProducto[1].split(';');

				adicionales = '';
				if (lista.length > 1) {
					for (let i = 0; i < lista.length; i++) {
						adicionales += `<img class="img-owl img-adicional" src="${lista[i]}" alt="'img'">`;
					}

					if (!nuevaImg.includes('texturas'))
					{
						adicionales += `<img class="img-owl img-adicional" src="${principal}" alt="'img'">`;
					}

							//console.log('<br>Adicional: ',adicionales);
				}

				precio = Math.round(parseFloat(infoProducto[2]) * (1 + parseFloat(infoProducto[3]) / 100));
				impuesto = Math.round(parseFloat(infoProducto[2]) * parseFloat(infoProducto[3]) / 100);
				formateado = new Intl.NumberFormat('en-US');

				ampliada = infoProducto[4];

				if (ampliada.length < 50) {
					for (let x = 0; x < 10; x++) {
						ampliada += ' '.repeat(50) + '<br>';
					}
				}

				$('.caja-izq').html(adicionales);

				$('.product-detail-name').html(infoProducto[0]);
				$('.det-item').html(infoProducto[1]);
				$('.precio-unit').html('$' + formateado.format(precio) + ' COP');
				$('.ampl-item').html(ampliada);
				$('.ref-item').html(infoProducto[0]);

				$('#tabla_calibres').html(defProducto[2]);

				// Datos para el formulario de adición al carrito
				$('#frmCodItem').val(infoProducto[0]);
				$('#descripcion').val(infoProducto[1]);
				$('#frmPrecioItem').val(infoProducto[2]);
				$('#frmImpuestoItem').val(impuesto);

				
				if (($(`#h_${codigo}`).val()).length == 0)
				{
					$('#span-tachado').removeClass('precio-unit-tachado');
					$('#span-promo').removeClass('precio-unit-promo-visible');
					$('#span-promo').addClass('precio-unit-promo');
					$('#foto-ampliada').removeClass('block2-labelsale');
				}
				else
				{
					$('#span-tachado').addClass('precio-unit-tachado');
					$('#span-promo').removeClass('precio-unit-promo');
					$('#span-promo').addClass('precio-unit-promo-visible');
					$('#foto-ampliada').addClass('block2-labelsale');
					
					const precioCarro = parseInt($(`#h_${codigo}`).val());
					$('#span-promo').html('$' + parseInt(precioCarro).toLocaleString('es-COL'));
					$('#frmPrecioItem').val(precioCarro / 1.19);
					$('#frmImpuestoItem').val((precioCarro * 0.19 / 1.19));
				}
			}
		});
	});

	/*$('.caja-izq').on('click', function () {
		console.log('Soy la caja lateral ', $(this).html());
	});*/
	//=================================================================
	// 							CLOCK MAKER
	//=================================================================

	var widthBG = $('#background').width();
	var withNum = $('#numbers').width();
	var marginTop = (widthBG - withNum) / 2;
	$('#numbers').css('margin-top', marginTop);
	$('#clockMaker button.add-cart').css('top', 'calc(' + widthBG + 'px + 17vh)');
	if ($(window).width() < 576) {
		$('#clockMaker button.add-cart').css('top', 'calc(' + widthBG + 'px + 10vh)');
	}

	$(window).resize(function () {
		widthBG = $('#background').width();
		withNum = $('#numbers').width();
		marginTop = (widthBG - withNum) / 2;
		$('#numbers').css('margin-top', marginTop);
		$('#clockMaker button.add-cart').css('top', 'calc(' + widthBG + 'px + 17vh)');
		if ($(window).width() < 576) {
			$('#clockMaker button.add-cart').css('top', 'calc(' + widthBG + 'px + 10vh)');
		}
	});

	$('#bgFilter img').on('click', function () {
		var backgroundSrc = $(this).attr('src');
		$("#background").attr('src', backgroundSrc);
	});

	$('#markFilter img').on('click', function () {
		var markSrc = $(this).attr('src');
		$("#mark").attr('src', markSrc);
	});

	$('#numbersFilter img').on('click', function () {
		var numbersSrc = $(this).attr('src');
		$("#numbers").attr('src', numbersSrc);
	});

	$('.block2-btn-addcart').each(function () {
		var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
		$(this).on('click', function () {
			swal(nameProduct, "fue añadido al carrito!", "success");
		});
	});

	$('.block2-btn-addwishlist').each(function () {
		var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
		$(this).on('click', function () {
			swal(nameProduct, "fue añadido a su lista de deseos!", "success");
		});
	});

	// Click en la imagen lleva  al detalle del producto
	$('.block2-overlay').on('click', function () {
		var href = $(this).parents('.block2').find('a.block2-name').attr('href');
		window.location.href = href;
	});

	// Envia el producto a favoritos o al carrito si redireccionar
	$('.block2-overlay').on('click', 'a, button', function (event) {
		event.stopPropagation();
	});

	$('.parallax100').parallax100();

	$(".selection-1").select2({
		minimumResultsForSearch: 20,
		dropdownParent: $('#dropDownSelect1')
	});

	$(".selection-2").select2({
		minimumResultsForSearch: 20,
		dropdownParent: $('#dropDownSelect2')
	});

	$('#paisUsuario').on('change', function (e) {
		var paisID = $(this).val();

		var info = { 'pais': paisID };

		console.log('El país seleccionado es: ' + paisID);

		$.ajax({
			type: 'POST',
			url: BASE_URL + 'usuarios/lista_estados',
			data: info,
			success: function (html) {
				$('#estadoUsuario').html(html)
				$('#estadoUsuario').trigger('change');
			}
		});

		e.stopPropagation();
	});

	$('#paisEnvio').on('change', function (e) {
		var paisID = $(this).val();

		var info = { 'pais': paisID };

		$.ajax({
			type: 'POST',
			url: BASE_URL + 'usuarios/lista_estados',
			data: info,
			success: function (html) {
				$('#estadoEnvio').html(html)
				$('#estadoEnvio').trigger('change');
			}
		});

		e.stopPropagation();
	});

	$('#estadoUsuario').on('change', function (e) {
		var estadoID = $(this).val();

		var info = { 'estado': estadoID };

		$.ajax({
			type: 'POST',
			url: BASE_URL + 'usuarios/lista_ciudades',
			data: info,
			success: function (html) {
				$('#ciudadUsuario').html(html)
			}
		});

		e.stopPropagation();
	});

	$('#estadoEnvio').on('change', function (e) {
		var estadoID = $(this).val();

		var info = { 'estado': estadoID };

		$.ajax({
			type: 'POST',
			url: BASE_URL + 'usuarios/lista_ciudades',
			data: info,
			success: function (html) {
				$('#ciudadEnvio').html(html)
			}
		});

		e.stopPropagation();
	});
})(jQuery);