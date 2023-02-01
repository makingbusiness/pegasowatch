<?php
   $rutaFondos = scandir("imagenes/makeClock/fondos");
   $rutaCat = "imagenes/makeClock/fondos/";
   $rutaMarcos = "imagenes/makeClock/marcos/";
   $rutaDiales = "imagenes/makeClock/numeros/";
   
   $marcos = glob($rutaMarcos."*.{png,jpg,gif}", GLOB_BRACE);
   $numeros = glob($rutaDiales."*.{png,jpg,gif}", GLOB_BRACE); 
?>	
	<!-- Slide -->
	<section id="clockMaker">
		<div class="container-fluid">
			<div class="row bg-row">
				<div class="col-md-8 col-sm-6 col-12" id="clock">
					<img id="background" src="<?php echo base_url(); ?>imagenes/makeClock/fondos/01.png">
					<img id="numbers" src="<?php echo base_url(); ?>imagenes/makeClock/numeros/B.png">
					<img id="mark" src="<?php echo base_url(); ?>imagenes/makeClock/marcos/1.png">
					<form>
						<input type="text" id="imgBg" name="background" value="<?php echo base_url(); ?>imagenes/makeClock/fondos/01.png" hidden>
						<input type="text" id="imgNum" name="numbers" value="<?php echo base_url(); ?>imagenes/makeClock/numeros/B.png" hidden>
						<input type="text" id="imgMk" name="mark" value="<?php echo base_url(); ?>imagenes/makeClock/marcos/1.png" hidden>
						<button type="submit" class="flex-c-m bg4 bo-rad-23 hov1 s-text14 trans-0-4 add-cart">Agregar al carrito</button>
					</form>
				</div>

				<!-- ======================= FILTERS ======================= -->
				<div class="col-md-4 col-sm-6 col-12" id="clockFilters">

					<!-- ======================= TABS ======================= -->
					<ul class="nav nav-tabs nav-fill" id="filtersTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link hov1 s-text14 active" id="bgFilter-tab" data-toggle="tab" href="#bgFilter" role="tab" aria-controls="bgFilter" aria-selected="true">Fondos</a>
						</li>
						<li class="nav-item">
							<a class="nav-link hov1 s-text14" id="markFilter-tab" data-toggle="tab" href="#markFilter" role="tab" aria-controls="markFilter" aria-selected="false">Marcos</a>
						</li>
						<li class="nav-item">
							<a class="nav-link hov1 s-text14" id="numbersFilter-tab" data-toggle="tab" href="#numbersFilter" role="tab" aria-controls="numbersFilter" aria-selected="false">Números</a>
						</li>
					</ul>

					<!-- ======================= TAB CONTENT ======================= -->
					<div class="tab-content" id="filtersTabContent">

						<!-- ======================= BACKGROUNDS ======================= -->
						<div class="tab-pane fade show active" id="bgFilter" role="tabpanel" aria-labelledby="bgFilter-tab">
							<div class="accordion" id="bg-accordeon">

								<!-- ------------ CATEGORY ------------ -->
								<?php $idFondo = 1; ?>
								<?php foreach($rutaFondos as $fondo) : ?>
								<?php if ($fondo !='.' && $fondo!='..') : ?>
								<div class="card">
									<div class="card-header" id="heading-animals">
										<h5 class="mb-0">
											<button class="btn btn-link collapsed s-text14" type="button" data-toggle="collapse" data-target="#collapse-<?php echo $idFondo; ?>" aria-expanded="<?php if ($idFondo == 1) : ?>true<?php else : ?>false<?php endif; ?>" aria-controls="collapse-<?php echo $idFondo; ?>"><?php echo $fondo; ?></button>
										</h5>
									</div>
									<div id="collapse-<?php echo $idFondo; ?>" class="collapse <?php if ($idFondo == 1) : ?>show<?php endif;?>" aria-labelledby="heading-<?php echo $idFondo; ?>" data-parent="#bg-accordeon">
										<div class="card-body row">

											<!-- ------------ SUBCATEGORIES ------------ -->
											<?php $rutaSub = scandir("imagenes/makeClock/fondos/".$fondo); ?>
											<div class="accordion subcategories" id="animals-accordeon">

												<!-- ------------ Subcategory ------------ -->
												<?php $idSub = 1; ?>
												<?php foreach($rutaSub as $sub) : ?>
												<?php if ($sub !='.' && $sub!='..') : ?>
												<div class="card">
													<div class="card-header" id="heading-birds">
														<h5 class="mb-0">
															<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse-<?php echo $sub; ?>" aria-expanded="<?php if ($idSub == 1) : ?>true<?php else : ?>false<?php endif; ?>" aria-controls="collapse-<?php echo $sub; ?>"><?php echo $sub; ?></button>
														</h5>
													</div>
													<div id="collapse-<?php echo $sub; ?>" class="collapse <?php if ($idSub == 1) : ?>show<?php endif; ?>" aria-labelledby="heading-<?php echo $sub; ?>" data-parent="#animals-accordeon">
														<div class="card-body row">
																<div class="col-6 col-md-4">
																	<img src="<?php echo base_url(); ?>imagenes/makeClock/fondos/<?php echo $fondo; ?>/<?php echo $sub; ?>/01.png">
																</div>
															<div class="col-6 col-md-4">
																<img src="<?php echo base_url(); ?>imagenes/icons/add-bg.png" alt="Añade tu propia imagen" style="opacity: 0.8;">
															</div>
														</div>
													</div>
												</div>
												<?php $idSub++; ?>
												<?php endif; ?>
												<?php endforeach; ?>
											</div>
											<!-- End Accordion -->
										</div>
									</div>
								</div>
								<?php $idFondo++; ?>
								<?php endif; ?>
								<?php endforeach; ?>
							</div>
							<!-- End Accordion -->
						</div>

						<!-- ======================= MARKS ======================= -->
						<div class="tab-pane fade" id="markFilter" role="tabpanel" aria-labelledby="markFilter-tab">
							<div class="row">
								<?php foreach($marcos as $marco) : ?>
								<div class="col-6 col-md-4">
									<img src="<?php echo base_url(); ?><?php echo $marco; ?>">
								</div>
								<?php endforeach; ?>
							</div>
						</div>

						<!-- ======================= NUMBERS ======================= -->
						<div class="tab-pane fade" id="numbersFilter" role="tabpanel" aria-labelledby="numbersFilter-tab">
							<div class="row">
							<?php foreach($numeros as $numero) : ?>					
								<div class="col-6 col-md-4">
									<img src="<?php echo base_url(); ?><?php echo $numero; ?>">
								</div>
							<?php endforeach; ?>								
							</div>
						</div>
					</div>


				</div>
			</div>
		</div>
	</section>