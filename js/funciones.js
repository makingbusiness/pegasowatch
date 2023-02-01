(function($){	
		/*$('.block2-btn-addcart').each(function(e){
			e.preventDefault();		
			var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
		
			$.ajax({
				url: $(this).attr('action'),
				type: $(this).attr('method'),
				data: $(this).serialize()
			}).done(function(data){
				$(this).on('click', function(){
					swal(nameProduct, "fue añadido al carrito!", "success");
				});					
			});
			e.stopPropagation();
		});
		
		$('.flex-c-m').click(function(e){
			$.ajax({
				url: $(this).attr('action'),
				type: $(this).attr('method'),
				data: $(this).serialize()
			}).done(function(data){
				$(this).on('click', function(){
					swal("", "Carrito actualizado!", "success");
				});					
			})
			e.preventDefault();
			e.stopPropagation();
		});

		$('.block2-btn-addwishlist').each(function(e){
			var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
			$(this).on('click', function(){
				swal(nameProduct, "fue añadido a su lista de deseos!", "success");
			});
			
			e.stopPropagation();
		});
		
		$('.btn-addcart-product-detail').each(function(e){
			var nameProduct = $('.product-detail-name').html();
			$(this).on('click', function(){
				swal(nameProduct, "su producto fue añadido al carrito!", "success");
			});
			
			e.stopPropagation();
		});
		
		// Click en la imagen lleva  al detalle del producto
		$('.block2-overlay').on('click', function(e) {
			var href = $(this).parents('.block2').find('a.block2-name').attr('href');
			window.location.href = href;
			e.stopPropagation();
		});

		// Envia el producto a favoritos o al carrito si redireccionar
		$('.block2-overlay').on('click', 'a, button',function(event) {
			event.stopPropagation();
		});	
		
		//=================================================================
		// 							CLOCK MAKER
		//=================================================================

		var widthBG = $('#background').width();
		var withNum = $('#numbers').width();
		var marginTop = (widthBG - withNum) / 2;
		$('#numbers').css('margin-top', marginTop);
		$('#clockMaker button.add-cart').css('top', 'calc(' + widthBG + 'px + 20vh)');
		if ($(window).width() < 576) {
			$('#clockMaker button.add-cart').css('top', 'calc(' + widthBG + 'px + 10vh)');
		}

		$( window ).resize(function() {
			widthBG = $('#background').width();
			withNum = $('#numbers').width();
			marginTop = (widthBG - withNum) / 2;
			$('#numbers').css('margin-top', marginTop);
			$('#clockMaker button.add-cart').css('top', 'calc(' + widthBG + 'px + 20vh)');
			if ($(window).width() < 576) {
				$('#clockMaker button.add-cart').css('top', 'calc(' + widthBG + 'px + 10vh)');
			}
		});

		$('#backgroundFilter img').on('click', function() {
			var backgroundSrc = $(this).attr('src');
			$("#background").attr('src', backgroundSrc);
		});

		$('#markFilter img').on('click', function() {
			var markSrc = $(this).attr('src');
			$("#mark").attr('src', markSrc);
		});

		$('#numbersFilter img').on('click', function() {
			var numbersSrc = $(this).attr('src');
			$("#numbers").attr('src', numbersSrc);
		});

*/
		/*------------------------------------------------------------------*/

})(jQuery);