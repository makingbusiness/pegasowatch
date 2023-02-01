						<div class="search-product pos-relative bo4 of-hidden m-b-20 m-t-5">
							<form id="form-filtro" method="post" action="<?php echo base_url(); ?>productos/tipo_f/f/1">
							<input class="s-text7 size6 p-l-23 p-r-50" type="text" name="search-product" id="search-product" placeholder="Buscar <?php echo $this->session->userdata('nombre_pagina'); ?>...">

							<button type="submit" class="flex-c-m size5 ab-r-m color2 color0-hov trans-0-4">
								<i class="fs-12 fa fa-search" aria-hidden="true"></i>
							</button>
							</form>
						</div>

						<div class="filter-type p-b-35">
							<h4 class="m-text14 p-b-7">
								Categor&iacute;as
							</h4>

							<!--ul>
								<li class="p-t-4">
									<a href="<?php echo base_url(); ?>productos/tipo/<?php echo $instancia; ?>/1" class="s-text13 active1">Todas</a>
								</li>

								<?php foreach(lista_categorias('1',$instancia) as $cat) : ?>
								<li class="p-t-4">
									<a href="<?php echo base_url(); ?>productos/tipo/<?php echo $cat->CodInst; ?>/1" class="s-text13"><?php echo $cat->Descrip; ?></a>
								</li>
								<?php endforeach; ?>
								<?php if ($this->session->userdata('nombre_pagina') == 'relojes') : ?>
									<li class="p-t-4">
										<a href="<?php echo base_url(); ?>productos/crea_tu_reloj" class="s-text13">Crea tu reloj</a>
									</li>
								<?php endif; ?>
							</ul-->
						</div>

						<!--
						<?php if ($this->session->has_userdata('instancia_n2')) : ?>
						<div class="filter-brand p-b-35">
							<h4 class="m-text14 p-b-7">
								Marcas
							</h4>
							
							<ul>
								<?php foreach(lista_categorias('1',$this->session->instancia_n2) as $marca) : ?>
									<li class="p-t-4">
										<a href="<?php echo base_url(); ?>productos/tipo/<?php echo urlencode($marca->CodInst); ?>/1" class="s-text13 active1"><?php echo $marca->Descrip; ?></a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
						<?php endif; ?>
						
						<?php if ($this->session->has_userdata('instancia_n3')) : ?>
						<div class="filter-brand p-b-35">
							<h4 class="m-text14 p-b-7">
								Tipo
							</h4>
							
							<ul>
								<?php foreach(lista_categorias('1',$this->session->instancia_n3) as $marca) : ?>
									<li class="p-t-4">
										<a href="<?php echo base_url(); ?>productos/tipo/<?php echo urlencode($marca->CodInst); ?>/1" class="s-text13 active1"><?php echo $marca->Descrip; ?></a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
						<?php endif; ?>

						<?php if ($this->session->has_userdata('instancia_n4')) : ?>
						<div class="filter-brand p-b-35">
							<h4 class="m-text14 p-b-7">
								Subtipo
							</h4>
							
							<ul>
								<?php foreach(lista_categorias('1',$this->session->instancia_n4) as $marca) : ?>
									<li class="p-t-4">
										<a href="<?php echo base_url(); ?>productos/tipo/<?php echo urlencode($marca->CodInst); ?>/1" class="s-text13 active1"><?php echo $marca->Descrip; ?></a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
						<?php endif; ?>
						-->

						<ul id="myUL">

							<?php foreach(lista_categorias('1',$instancia) as $cat) : ?>
								<li class="p-t-4">
									<span>
										<a href="<?php echo base_url(); ?>productos/tipo/<?php echo urlencode($cat->CodInst); ?>/1" class="s-text13 active1"><?php echo $cat->Descrip; ?></a>
									</span>
									<ul class="nested">
										<?php foreach(lista_categorias('1', $cat->CodInst) as $cat2) : ?>
											<li class="p-t-4">
												<span>
													<a href="<?php echo base_url(); ?>productos/tipo/<?php echo urlencode($cat2->CodInst); ?>/1" class="s-text13 active1">&nbsp;&nbsp;<?php echo $cat2->Descrip; ?></a>
												</span>
												<?php if ($this->session->nombre_pagina != 'pulsos'): ?>
													<ul class="nested">
														<?php foreach(lista_categorias('1', $cat2->CodInst) as $cat3) : ?>
															<li class="p-t-4">
																<a href="<?php echo base_url(); ?>productos/tipo/<?php echo urlencode($cat3->CodInst); ?>/1" class="s-text13 active1">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo '    '.$cat3->Descrip; ?></a>
															</li>
														<?php endforeach; ?>
														<li>&nbsp;</li>
													</ul>
												<?php endif; ?>
											</li>
										<?php endforeach; ?>
										<li>&nbsp;</li>
									</ul>
								</li>
							<?php endforeach; ?>


							<!--li><span class="caret">Beverages</span>
								<ul class="nested">
								<li>Water</li>
								<li>Coffee</li>
								<li><span class="caret">Tea</span>
									<ul class="nested">
									<li>Black Tea</li>
									<li>White Tea</li>
									<li><span class="caret">Green Tea</span>
										<ul class="nested">
										<li>Sencha</li>
										<li>Gyokuro</li>
										<li>Matcha</li>
										<li>Pi Lo Chun</li>
										</ul>
									</li>
									</ul>
								</li>
								</ul>
							</li-->
						</ul>

						<!--div class="filter-color p-t-25 p-b-35 bo3">
							<div class="m-text15 p-b-12">
								Color
							</div>

							<ul class="flex-w">
								<li class="m-r-10">
									<input class="checkbox-color-filter" id="color-filter1" type="checkbox" name="color-filter1">
									<label class="color-filter color-filter1" for="color-filter1"></label>
								</li>

								<li class="m-r-10">
									<input class="checkbox-color-filter" id="color-filter2" type="checkbox" name="color-filter2">
									<label class="color-filter color-filter2" for="color-filter2"></label>
								</li>

								<li class="m-r-10">
									<input class="checkbox-color-filter" id="color-filter3" type="checkbox" name="color-filter3">
									<label class="color-filter color-filter3" for="color-filter3"></label>
								</li>

								<li class="m-r-10">
									<input class="checkbox-color-filter" id="color-filter4" type="checkbox" name="color-filter4">
									<label class="color-filter color-filter4" for="color-filter4"></label>
								</li>

								<li class="m-r-10">
									<input class="checkbox-color-filter" id="color-filter5" type="checkbox" name="color-filter5">
									<label class="color-filter color-filter5" for="color-filter5"></label>
								</li>

								<li class="m-r-10">
									<input class="checkbox-color-filter" id="color-filter6" type="checkbox" name="color-filter6">
									<label class="color-filter color-filter6" for="color-filter6"></label>
								</li>

								<li class="m-r-10">
									<input class="checkbox-color-filter" id="color-filter7" type="checkbox" name="color-filter7">
									<label class="color-filter color-filter7" for="color-filter7"></label>
								</li>
							</ul>
						</div-->

						<!--div class="filter-price p-t-25 p-b-50 bo3">
							<div class="m-text15 p-b-17">
								Valor
							</div>

							<div class="wra-filter-bar">
								<div id="filter-bar"></div>
							</div>

							<div class="flex-sb-m flex-w p-t-16">
								<form id="form-filtro" method="post" action="<?php echo base_url(); ?>productos/<?php echo $this->session->userdata('nombre_pagina'); ?>_f/f/1">
								<div class="w-size11">
									<button id="rango-precios" class="flex-c-m size4 bg7 bo-rad-15 hov1 s-text14 trans-0-4" type="submit">
										Filtrar
									</button>
								</div>

								<div class="s-text3 p-t-10 p-b-10">
									Rango: $<span id="value-lower" name="value-lower"><?php echo $this->session->userdata('value-lower'); ?></span> - 
									       $<span id="value-upper" name="value-upper"><?php echo $this->session->userdata('value-upper'); ?></span>
								</div>
								</form>
							</div>
						</div-->