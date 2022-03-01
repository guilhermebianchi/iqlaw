<!DOCTYPE html>

<html lang="{{ App::getlocale() }}">
    <head>

        <!-- metas -->
        @include( 'inc.metas' )

        <!-- title  -->
        <title>{{ __( 'parameters.title' ) }}</title>

        @include( 'inc.favicon' )

        <!-- stylesheets -->
        @include( 'inc.stylesheets' )

    </head>

    <body>
        <div id="preloader"></div>

        <div class="main-wrapper">

            @include( 'inc.header' )

            <!-- BANNER -->
            <section class="bg-img cover-background full-screen pt-16 pb-8 p-lg-0 min-md-height-auto" data-overlay-dark="0" data-background="{{ asset( 'storage'.json_decode( $data[ 'banner' ][ 0 ][ 'image' ] )[ 0 ] ) }}">
                <div class="container d-flex flex-column">
                    <div class="row align-items-center min-lg-vh-100">
                        <div class="col-lg-12 mb-5 mb-lg-0">
                            <h1 class="text-white display-16 display-md-9 display-lg-7 display-xl-4 mb-1-6 text-shadow font-weight-800 text-center">{!! $data[ 'banner' ][ 0 ][ 'text2' ] !!}</h1>
                            <p class="mb-2-2 display-29 display-md-28 text-white text-center">{!! $data[ 'banner' ][ 0 ][ 'text3' ] !!}</p>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /BANNER -->


            <!-- IQ LAW -->
            <section class="container-fluid p-0 mt-5 mb-5">
                <div class="container text-center font-weight-400" style="font-size:13px;">
                    <img class="mb-5" src="{{ URL::asset( 'images/logo.png' ) }}" title="{{ __( 'parameters.title' ) }}" alt="{{ __( 'parameters.title' ) }}">
                    <p>Proteja seu bem estar com a tranquilidade de ter seus assuntos legais resolvidos e entregues em boas mãos.</p>

                    <p>Proteja sua herança e seus entes queridos com um advogado competente na área de planejamento patrimonial e legalize seu testamento a tempo.</p>

                    <p>A falta de preparação para que os seus desejos finais sejam atendidos, coloca em suas realizações ao longo da vida um risco incomensurável. Sem documentação clara, você força seus entes queridos a arcarem com a tarefa estressante de gerenciar seus ativos e pagar taxas desnecessárias e taxas de sucessão. Se você preparar um testamento no exterior, sem a devida ajuda de um advogado de planejamento patrimonial qualificado, é possível que não haja meios de garantir que seus desejos finais sejam atendidos e seus beneficiários sejam devidamente protegidos.</p>

                    <p>No escritorio de advocacia Paula Montoya, somos especialistas nas complexidades singulares do planejamento patrimonial. Tanto a área local como a internacional podem apresentar inúmeros aspectos de alta complexidade, difíceis de gerir. No entanto, com a assistência de um advogado qualificado no planejamento da patrimonial, você pode proteger o seu legado e eliminar a confusão e os custos que sempre acompanham um planejamento desorganizado.</p>

                    <div class="row mt-5">
                        <div class="col-lg-6">
                            <img class="img-responsive" src="{{ URL::asset( 'images/iara-quadros.jpg' ) }}" title="Iara Quadros" alt="Iara Quadros">
                        </div>
                        <div class="col-lg-6 ps-8">
                            <h3 class="text-black mb-2" style="text-align:left; font-family:Raleway; font-weight:bold;">IARA QUADROS.</h3>
                            <h5 class="text-black" style="text-align:left; font-family:Raleway; font-weight:normal;">Follower of Christ, attorney, real estate developer, proud mommy, visionary, curitibana</h5>
                            <div class="mt-4 mb-5" style="width:50px; height:3px; background:#000;"></div>
                            <div style="color:#666; text-align:justify;">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero quod consequuntur quibusdam, enim expedita sed quia nesciunt incidunt accusamus necessitatibus modi adipisci officia libero accusantium esse hic,.
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /IQ LAW -->


            <!-- RANGE -->
            <section class="container-fluid p-0" style="background:#333333;">
                <div class="container text-center text-white" style="line-height:80px; font-size:23px;">
                    SEU ADVOGADO NA ÁREA DE NEGÓCIOS E O SEU MELHOR PARCEIRO
                </div>
            </section>
            <!-- /RANGE -->

            <!-- OCCUPATION AREA -->
            <section class="mt-5 mb-5 p-0">
                <h3 class="text-center mb-5">
                    ÁREA DE ATUAÇÃO
                </h3>

                <div class="container">
                    <div class="row">
                        <div class="col-lg-4">
                            <img class="img-responsive" src="{{ URL::asset( 'storage/temp1.png' ) }}" alt="Insurance dispute" title="Insurance dispute" data-bs-toggle="modal" data-bs-target="#a1" style="cursor:pointer;">

                            <!-- Modal -->
                            <div class="modal fade" id="a1" tabindex="-1" aria-labelledby="1Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="1Label">Insurance dispute</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero quod consequuntur quibusdam, enim expedita sed quia nesciunt incidunt accusamus necessitatibus modi adipisci officia libero accusantium esse hic,.
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __( 'parameters.Close' ) }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /OCCUPATION AREA -->


            <!-- WHY CHOOSE US -->
            <section class="container-fluid p-0" style="background:#686868;">
                <div class="container p-5">
                    <h5 class="text-white">POR QUE ESCOLHER A GENTE?</h5>
                    <div style="width:50px; height:3px; background:#fff;"></div>
                    <div class="mt-4 text-left text-white" style="font-size:13px; line-height:25px;">
                        Para novas empresas apenas decolando ou para aquelas já estabelecidas mas que almejam  horizontes mais amplos, a orientação correta de um advogado experiente pode fazer uma diferença substancial. Abertura de empresas, acordos de investimento, contratos de trabalho e marcas registradas são apenas alguns dos detalhes importantes  que irão proteger os seus esforços de negócios e assegurar um futuro rentável. Com mais de 10 anos de experiência jurídica abrangente, Iara Quadros é capaz de atuar com dedicação e habilidade  para criar um ambiente bem sucedido. Nosso escritório de advocacia tem-se desenvolvido, com o comprometimento de  abordagens honestas, com estratégias claras e conselhos inteligentes.
                    </div>
                </div>
            </section>
            <!-- /WHY CHOOSE US -->

            <!-- CONTACT -->
            <section class="p-0 mt-5">
                <div class="container">

                    <form class="quform" action="contact" method="post" onclick="">
                        @csrf

                        <div class="quform-elements">

                            <div class="row">

                                <!-- Begin Text input element -->
                                <div class="col-md-6">
                                    <div class="quform-element">
                                        <label for="name">Name <span class="quform-required">*</span></label>
                                        <div class="quform-input">
                                            <input class="form-control" id="name" type="text" name="name" placeholder="" />
                                        </div>
                                    </div>

                                </div>
                                <!-- End Text input element -->

                                <!-- Begin Text input element -->
                                <div class="col-md-6">
                                    <div class="quform-element">
                                        <label for="email">Email <span class="quform-required">*</span></label>
                                        <div class="quform-input">
                                            <input class="form-control" id="email" type="text" name="email" placeholder="" />
                                        </div>
                                    </div>
                                </div>
                                <!-- End Text input element -->

                                <!-- Begin Text input element -->
                                <div class="col-md-6">
                                    <div class="quform-element">
                                        <label for="subject">Subject <span class="quform-required">*</span></label>
                                        <div class="quform-input">
                                            <input class="form-control" id="subject" type="text" name="subject" placeholder="" />
                                        </div>
                                    </div>

                                </div>
                                <!-- End Text input element -->

                                <!-- Begin Text input element -->
                                <div class="col-md-6">
                                    <div class="quform-element">
                                        <label for="phone">Contact Number</label>
                                        <div class="quform-input">
                                            <input class="form-control" id="phone" type="text" name="phone" placeholder="" />
                                        </div>
                                    </div>

                                </div>
                                <!-- End Text input element -->

                                <!-- Begin Textarea element -->
                                <div class="col-md-12">
                                    <div class="quform-element">
                                        <label for="message">Message <span class="quform-required">*</span></label>
                                        <div class="quform-input">
                                            <textarea class="form-control" id="message" name="message" rows="3" placeholder=""></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Textarea element -->

                                <!-- Begin Submit button -->
                                <div class="col-md-12 col-lg-2">
                                    <div class="quform-submit-inner">
                                        <button class="butn theme butn-md" type="submit" style="background:#a68956;"><span>Send</span></button>
                                    </div>
                                    <div class="quform-loading-wrap text-start"><span class="quform-loading"></span></div>
                                </div>
                                <div class="col-md-12 col-lg-8" style="line-height:50px;">
                                    We'll do our best to get back to you within 6-8 working hours.
                                </div>
                                <!-- End Submit button -->

                            </div>

                        </div>

                    </form>
                </div>
                <div class="row mt-5">
                    <div class="col-lg-9" id="map" style="height:450px;"></div>
                    <div class="col-lg-3 ps-5" style="background:#f5f5f5;">
                        <h4 class="mt-5 mb-5">Our Headquarters</h4>
                        <p>
                            <span style="font-weight:bold;">North America:</span><br>
                            795 Folsom Ave, Suite 600<br>
                            San Francisco, CA 94107<br><br>

                            <span style="font-weight:bold;">Europe:</span><br>
                            795 Folsom Ave, Suite 600<br>
                            San Francisco, CA 94107<br><br>

                            <span style="font-weight:bold;">Phone:</span> (91) 8547 632521<br>
                            <span style="font-weight:bold;">Fax:</span> (91) 11 4752 1433<br>
                            <span style="font-weight:bold;">Email:</span> info@canvas.com<br>
                        </p>
                    </div>
                </div>
            </section>
            <!-- /CONTACT -->


            @include( 'inc.footer' )

        </div>

        <a href="#" class="scroll-to-top"><i class="fas fa-angle-up" aria-hidden="true"></i></a>

        @include( 'inc.javascripts' )


        <script async
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkwN3u-vtNIR33vowiLE0yCfpyVHj2iAU&callback=initMap">
        </script>

        <script>
            let map;

            function initMap() {
                map = new google.maps.Map(document.getElementById("map"), {
                    center: { lat: 28.5407256, lng: -81.3591545 },
                    zoom: 12,
                });
            }
        </script>

    </body>
</html>
