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
            <div id="banner" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">

                    @for( $i=0; $i < count( $data[ 'banner' ] ); $i++ )
                        <div class="carousel-item <?php echo ( $i == 0 ) ? 'active' : '' ?>" style="height:750px; background:url('storage{{ json_decode( $data[ 'banner' ][ $i ][ 'image' ] )[ 0 ] }}') center no-repeat;">
                            <div class="container d-flex flex-column">
                                <div class="row align-items-center min-lg-vh-100">
                                    <div class="col-lg-12 mb-5 mb-lg-0">
                                        <h1 class="text-white display-16 display-md-9 display-lg-7 display-xl-4 mb-1-6 text-shadow font-weight-800 text-center">{!! $data[ 'banner' ][ 0 ][ 'text2' ] !!}</h1>
                                        <p class="mb-2-2 display-29 display-md-28 text-white text-center">{!! $data[ 'banner' ][ 0 ][ 'text3' ] !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor

                </div>
                <a class="carousel-control-prev" href="#banner" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#banner" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <!-- /BANNER -->


            <!-- IQ LAW -->
            <div id="About"></div>
            <section class="container-fluid p-0 mt-5 mb-5">
                <div class="container text-center font-weight-400" style="font-size:13px;">
                    <img class="mb-5" src="{{ URL::asset( 'images/logo.png' ) }}" title="{{ __( 'parameters.title' ) }}" alt="{{ __( 'parameters.title' ) }}">

                    <?php echo html_entity_decode( $data[ 'home' ][ 0 ][ 'text2' ] ); ?>

                    <div class="row mt-5">
                        <div class="col-lg-6">
                            <img class="img-responsive" src="{{ URL::asset( 'images/iara-quadros.jpg' ) }}" title="Iara Quadros" alt="Iara Quadros">
                        </div>
                        <div class="col-lg-6 ps-8">
                            <h3 class="text-black mb-2" style="text-align:left; font-family:Raleway; font-weight:bold;">IARA QUADROS.</h3>
                            <h5 class="text-black" style="text-align:left; font-family:Raleway; font-weight:normal;"><?php echo html_entity_decode( $data[ 'home' ][ 0 ][ 'text3' ] ); ?></h5>
                            <div class="mt-4 mb-5" style="width:50px; height:3px; background:#000;"></div>
                            <div style="color:#666; text-align:justify;">
                                <?php echo html_entity_decode( $data[ 'home' ][ 0 ][ 'text4' ] ); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /IQ LAW -->


            <!-- RANGE -->
            <section class="container-fluid p-0" style="background:#333333;">
                <div class="container text-center text-white" style="line-height:80px; font-size:23px;">
                    <?php echo html_entity_decode( $data[ 'home' ][ 0 ][ 'text5' ] ); ?>
                </div>
            </section>
            <!-- /RANGE -->

            <!-- OCCUPATION AREA -->
            <div id="OccupationArea"></div>
            <section class="mt-5 mb-5 p-0">
                <h3 class="text-center mb-5">
                    <?php echo html_entity_decode( $data[ 'home' ][ 0 ][ 'text6' ] ); ?>
                </h3>

                <div class="container">
                    <div class="row">

                        @for( $i=0; $i < count( $data[ 'occupationArea' ] ); $i++ )
                            <div class="col-lg-4">
                                <img class="img-responsive" src="{{ asset( 'storage'.json_decode( $data[ 'occupationArea' ][ $i ][ 'image' ] )[ 0 ] ) }}" alt="{{ $data[ 'occupationArea' ][ $i ][ 'title' ] }}" title="{{ $data[ 'occupationArea' ][ $i ][ 'title' ] }}" data-bs-toggle="modal" data-bs-target="#a1" style="cursor:pointer;">

                                <!-- Modal -->
                                <div class="modal fade" id="a1" tabindex="-1" aria-labelledby="1Label" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="1Label">{{ $data[ 'occupationArea' ][ $i ][ 'title' ] }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                {{ $data[ 'occupationArea' ][ $i ][ 'text' ] }}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __( 'parameters.Close' ) }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor

                    </div>
                </div>
            </section>
            <!-- /OCCUPATION AREA -->


            <!-- WHY CHOOSE US -->
            <section class="container-fluid p-0" style="background:#686868;">
                <div class="container p-5">
                    <h5 class="text-white"><?php echo html_entity_decode( $data[ 'home' ][ 0 ][ 'text7' ] ); ?></h5>
                    <div style="width:50px; height:3px; background:#fff;"></div>
                    <div class="mt-4 text-left text-white" style="font-size:13px; line-height:25px;">
                        <?php echo html_entity_decode( $data[ 'home' ][ 0 ][ 'text8' ] ); ?>
                    </div>
                </div>
            </section>
            <!-- /WHY CHOOSE US -->

            <!-- CONTACT -->
            <div id="Contact"></div>
            <section class="p-0 mt-5">
                <div class="container">

                    <form id="quform" class="quform" action="contact" method="post">
                        @csrf

                        <div class="quform-elements">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="quform-element">
                                        <label for="name">{{ __( 'parameters.Name' ) }} <span class="quform-required">*</span></label>
                                        <div class="quform-input">
                                            <input class="form-control" id="name" type="text" name="name" placeholder="" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="quform-element">
                                        <label for="email">{{ __( 'parameters.Email' ) }} <span class="quform-required">*</span></label>
                                        <div class="quform-input">
                                            <input class="form-control" id="email" type="text" name="email" placeholder="" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="quform-element">
                                        <label for="subject">{{ __( 'parameters.Subject' ) }} <span class="quform-required">*</span></label>
                                        <div class="quform-input">
                                            <input class="form-control" id="subject" type="text" name="subject" placeholder="" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="quform-element">
                                        <label for="phone">{{ __( 'parameters.Number' ) }}</label>
                                        <div class="quform-input">
                                            <input class="form-control" id="phone" type="text" name="phone" placeholder="" />
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="quform-element">
                                        <label for="message">{{ __( 'parameters.Message' ) }} <span class="quform-required">*</span></label>
                                        <div class="quform-input">
                                            <textarea class="form-control" id="message" name="message" rows="3" placeholder=""></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-2">
                                    <div class="quform-submit-inner">
                                        <button class="butn theme butn-md g-recaptcha" type="submit" style="background:#a68956;" data-sitekey="6LeXcqoeAAAAAPJipp0MdKvsymvjfFqo9SwlEApC" data-callback='onSubmit' data-action='submit'><span>{{ __( 'parameters.Send' ) }}</span></button>
                                    </div>
                                    <div class="quform-loading-wrap text-start"><span class="quform-loading"></span></div>
                                </div>
                                <div class="col-md-12 col-lg-8" style="line-height:50px;">
                                    {{ __( 'parameters.WorkingHours' ) }}
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
                <div class="row mt-5">
                    <div class="col-lg-9" id="map" style="height:450px;"></div>
                    <div class="col-lg-3 ps-5" style="background:#f5f5f5;">
                        <h4 class="mt-5 mb-5"><?php echo html_entity_decode( $data[ 'home' ][ 0 ][ 'text9' ] ); ?></h4>

                        <?php echo html_entity_decode( $data[ 'home' ][ 0 ][ 'text10' ] ); ?>

                    </div>
                </div>
            </section>
            <!-- /CONTACT -->


            @include( 'inc.footer' )

        </div>

        <a href="#" class="scroll-to-top"><i class="fas fa-angle-up" aria-hidden="true"></i></a>

        @include( 'inc.javascripts' )

        <script src="https://www.google.com/recaptcha/api.js"></script>
        <script src="{{ URL::asset( 'slick-carousel/slick/slick.js' ) }}"></script>
        <script async
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkwN3u-vtNIR33vowiLE0yCfpyVHj2iAU&callback=initMap">
        </script>

        <script>
            function onSubmit(token) {
                document.getElementById("quform").submit();
            }

            const autoplay = () => {
                if( $( window ).width() >= 992 ){
                    $( '.autoplay' ).slick(
                        {
                            slidesToShow:   4,
                            slidesToScroll: 1,
                            autoplay:       true,
                            autoplaySpeed:  5000
                        }
                    );
                }else{
                    $( '.autoplay' ).slick(
                        {
                            slidesToShow:   1,
                            slidesToScroll: 1,
                            autoplay:       true,
                            autoplaySpeed:  5000
                        }
                    );
                }
            };

            $( document ).ready( function() {
                $('#banner').carousel({
                    interval: 7000
                });

                autoplay();
            });

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
