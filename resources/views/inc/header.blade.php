<header class="header-style1 menu_area-light scrollHeader" style="background:#FFF; z-index:999;">
    <div class="navbar-default" style="height:90px;">
        <div class="container">
            <div class="row align-items-center" style="height:90px;">
                <div class="col-12 col-lg-12">
                    <div class="menu_area">
                        <nav class="navbar navbar-expand-lg navbar-light p-0">
                            <div class="container-fluid">
                                <div class="navbar-header navbar-header-custom">
                                    <a href="{{ route( 'home' ) }}" class="navbar-brand">
                                        <img src="{{ URL::asset( 'images/logo.png' ) }}" title="{{ __( 'parameters.title' ) }}" alt="{{ __( 'parameters.title' ) }}" style="max-height:50px;">
                                    </a>
                                </div>

                                <div class="navbar-toggler"></div>

                                <ul class="navbar-nav" id="nav" >
                                    <li>
                                        <a href="{{ route( 'home' ) }}">{{ __( 'menu.Home' ) }}</a>
                                    </li>
                                    <li>
                                        <a href="#About">{{ __( 'menu.About' ) }}</a>
                                    </li>
                                    <li>
                                        <a href="#OccupationArea">{{ __( 'menu.OccupationArea' ) }}</a>
                                    </li>
                                    <li>
                                        <a href="#Contact">{{ __( 'menu.Contact' ) }}</a>
                                    </li>
                                </ul>

                                <div class="d-flex">
                                    <div>
                                        <div class="me-4 p-2 ps-4 pe-4 text-center" style="max-width:160px; border-radius:5px; background:#000; color:#fff; font-size:11px;">
                                            {!! $data[ 'home' ][ 0 ][ 'text1' ] !!}
                                        </div>
                                    </div>
                                    <div>
                                        <!-- FLAGS -->
                                        <div class="col-lg-12 text-right pr-4" style="font-size:23px; line-height:70px;">

                                            <!-- BRAZIL -->
                                            <a href="{{ route('locale', ['locale' => 'pt-br']) }}" title="{{ __( 'menu.Brazil' ) }}" style="display:unset; font-size:23px;">
                                                <i class="flag-icon flag-icon-br"></i>
                                            </a>
                                            <!-- /BRAZIL -->

                                            <!-- USA -->
                                            <a href="{{ route('locale', ['locale' => 'en']) }}" title="{{ __( 'menu.USA' ) }}" style="display:unset; font-size:23px;">
                                                <i class="flag-icon flag-icon-us"></i>
                                            </a>
                                            <!-- /USA -->

                                            <!-- SPAIN -->
                                            <a href="{{ route('locale', ['locale' => 'es']) }}" title="{{ __( 'menu.Spain' ) }}" style="display:unset; font-size:23px;">
                                                <i class="flag-icon flag-icon-es"></i>
                                            </a>
                                            <!-- /SPAIN -->
                                        </div>
                                        <!-- /FLAGS -->
                                    </div>
                                </div>
                            </div>

                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
