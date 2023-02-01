</div><!-- End .page-wrapper -->

<!-- Modal -->
<div class="modal fade" id="loginModalf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content ">
          <div class="modal-wrapper">
                  <div class="container pt-5 px-5 pb-1">
                      <div class="row">
                          <div class="col-md-6">
                              <h2 class="title mb-2">Acceder</h2>
                              <form id="frmAcceso" method="post" action="<?php echo base_url(); ?>usuariosf/login" class="mb-1">
                                  <label for="login-email">Correo Electrónico <span class="required">*</span></label>
                                  <input type="email" class="form-input form-wide mb-2" id="login-email" name="login-email" required>
                                  <label for="login-password">Contraseña <span class="required">*</span></label>
                                  <input type="password" class="form-input form-wide mb-2" id="login-password" name="login-password" required>
                                  <div class="form-footer">
                                      <button type="submit" class="btn btn-primary btn-md">Acceder</button>
                                      <!--div class="custom-control custom-checkbox form-footer-right">
                                          <input type="checkbox" class="custom-control-input" id="lost-password">
                                          <label class="custom-control-label form-footer-right" for="lost-password">Recuerdame</label>
                                      </div-->
                                  </div>
                                  <!-- End .form-footer -->
                                  <a href="<?php echo base_url(); ?>usuariosf/forgot" class="forget-password"> ¿Olvidaste tu contraseña?</a>
                              </form>
                          </div>
                          <!-- End .col-md-6 -->
                          <div class="col-md-6">
                              <h2 class="title mb-2">Registro</h2>
                              <form id="frmRegAcceso" method="post" action="<?php echo base_url(); ?>usuariosf/creaUsuario">
                                  <label for="register-name">Nombres <span class="required">*</span></label>
                                  <input type="text" class="form-input form-wide mb-2" id="register-name" name="nombre_usuario" required="">
                                  <label for="register-lastname">Apellidos <span class="required">*</span></label>
                                  <input type="text" class="form-input form-wide mb-2" id="register-lastname" name="apellido_usuario" required="">
                                  <label for="register-documento">Documento <span class="required">*</span></label>
                                  <input type="text" class="form-input form-wide mb-2" id="register-documento" name="documento_usuario" required="">
                                  <label for="register-email">Correo Electrónico <span class="required">*</span></label>
                                  <input type="email" class="form-input form-wide mb-2" id="register-email" name="correo_usuario" required="">
                                  <label for="register-password">Contraseña <span class="required">*</span></label>
                                  <input type="password" class="form-input form-wide mb-2" id="register-password" name="pwd_usuario" required="">
                                  <div class="form-footer">
                                      <button type="submit" class="btn btn-primary btn-md">Registrarse</button>
                                      <!--div class="custom-control custom-checkbox">
                                          <input type="checkbox" class="custom-control-input" id="newsletter-signup">
                                          <label class="custom-control-label" for="newsletter-signup">Registrarme al boletín</label>
                                      </div-->
                                      <!-- End .custom-checkbox -->
                                  </div>
                                  <!-- End .form-footer -->
                              </form>
                          </div>
                          <!-- End .col-md-6 -->
                      </div>
                      <!-- End .row -->
                  </div>
                  <!-- End .container -->
                  <div class="social-login-wrapper">

                  </div>


                  <button title="Close (Esc)" type="button" class="mfp-close" data-dismiss="modal" >×</button>
              </div>
    </div>
  </div>
</div>


  <!-- Modal -->
  <div class="modal fade" id="errorIngresoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content ">
                <div class="modal-wrapper">
                        <div class="container pt-5 px-5 pb-1">
                            <div class="row">
                                <div class="col-md-12 text-center">

                                    <h4 style='font-size:40px'><div id="tituloMsgError"></div></h4>
                                    <h2 class="title mb-2"><div id="msgError"></div></h2>
                                </div>
                                <!-- End .col-md-6 -->

                            </div>
                            <!-- End .row -->
                        </div>

                        <button title="Close (Esc)" type="button" class="mfp-close" data-dismiss="modal" >×</button>
                    </div>
            </div>
        </div>
    </div>


<!-- Plugins JS File -->
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins.min.js"></script>
<!--script src="<?php echo base_url(); ?>assets/js/plugins/sweetalert.min.js"></script-->
<script src="<?php echo base_url(); ?>assets/js/plugins/sweetalert2.min.js"></script>

<!-- Main JS File -->
<script src="<?php echo base_url(); ?>assets/js/main.js"></script>
<script src="<?php echo base_url(); ?>assets/js/varios.js"></script>

<script>
  var BASE_URL = "<?php echo base_url();?>";
</script>

<script>
    if ('loading' in HTMLImageElement.prototype) {
        // Si el navegador soporta lazy-load, tomamos todas las imágenes que tienen la clase
        // `lazyload`, obtenemos el valor de su atributo `data-src` y lo inyectamos en el `src`.
        const images = document.querySelectorAll("img.lazyload");
        images.forEach(img => {
            img.src = img.dataset.src;
        });
    } else {
        // Importamos dinámicamente la libreria `lazysizes`
        let script = document.createElement("script");
        script.async = true;
        //script.src = "https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.2.0/lazysizes.min.js";
        script.src = "<?php echo base_url(); ?>assets/js/plugins/lazysizes.5.2.0.min.js";
        document.body.appendChild(script);
    }
</script>
</body>
</html>
