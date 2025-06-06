<!DOCTYPE html>
<html lang="en">

<head>

    <!-- META ============================================= -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />

    <!-- DESCRIPTION -->
    <meta name="description" content="{{ $setting->nama_aplikasi }}" />

    <!-- OG -->
    <meta property="og:title" content="{{ $setting->nama_aplikasi }}" />
    <meta property="og:description" content="{{ $setting->nama_aplikasi }}" />
    <meta property="og:image" content="" />
    <meta name="format-detection" content="telephone=no">

    <!-- FAVICONS ICON ============================================= -->
    <link rel="icon" href="{{ $setting->favicon }}" type="image/x-icon" />
    <link rel="icon" href="{{ Storage::url($setting->favicon ?? '') }}" type="image/*">

    <link rel="shortcut icon" type="image/x-icon" href="{{ $setting->favicon }}" />

    <!-- PAGE TITLE HERE ============================================= -->
    <title>{{ $setting->nama_aplikasi }} </title>

    <!-- MOBILE SPECIFIC ============================================= -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--[if lt IE 9]>
 <script src="{{ asset('template') }}/assets/js/html5shiv.min.js"></script>
 <script src="{{ asset('template') }}/assets/js/respond.min.js"></script>
 <![endif]-->

    <!-- All PLUGINS CSS ============================================= -->
    <link rel="stylesheet" type="text/css" href="{{ asset('template') }}/assets/css/assets.css">

    <!-- TYPOGRAPHY ============================================= -->
    <link rel="stylesheet" type="text/css" href="{{ asset('template') }}/assets/css/typography.css">

    <!-- SHORTCODES ============================================= -->
    <link rel="stylesheet" type="text/css" href="{{ asset('template') }}/assets/css/shortcodes/shortcodes.css">

    <!-- STYLESHEETS ============================================= -->
    <link rel="stylesheet" type="text/css" href="{{ asset('template') }}/assets/css/style.css">
    <link class="skin" rel="stylesheet" type="text/css" href="{{ asset('template') }}/assets/css/color/color-1.css">

    <!-- REVOLUTION SLIDER CSS ============================================= -->
    <link rel="stylesheet" type="text/css" href="{{ asset('template') }}/assets/vendors/revolution/css/layers.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('template') }}/assets/vendors/revolution/css/settings.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('template') }}/assets/vendors/revolution/css/navigation.css">
    <!-- REVOLUTION SLIDER END -->

    <style>
        /* Tambahkan background hitam transparan saat menu muncul di mobile */
        @media (max-width: 991.98px) {
            .header-transparent .sticky-header {
                background-color: rgba(0, 0, 0, 0.8);
                /* Tetap transparan */
            }

            .menu-links {
                background-color: rgba(0, 0, 0, 0.9);
                backdrop-filter: blur(4px);
            }

            .menu-links .nav>li>a {
                color: #fff;
            }

            /* Logo agar tetap terlihat */
            .menu-logo img {
                max-height: 50px;
                filter: drop-shadow(0 0 2px #000);
            }
        }

        .Newspaper-Button {
            display: none !important;
        }

        @media (min-width: 1024px) {
            .tp-caption.Newspaper-Title {
                font-size: 48px !important;
                /* font lebih besar untuk desktop */
                line-height: 50px !important;
                top: 5px !important;
                /* posisinya agak ke bawah */
                padding: 0px 10px !important;
                width: 60% !important;
                /* lebarnya lebih kecil dari mobile */
            }

            .tp-caption.Newspaper-Subtitle {
                font-size: 32px !important;
                line-height: 36px !important;
                top: 5px !important;
                /* posisinya di bawah title */
                padding: 10px 10px !important;
                width: 60% !important;
            }
        }

        /* VERSI MOBILE */
        @media (max-width: 480px) {
            .tp-caption.Newspaper-Title {
                font-size: 15px !important;
                line-height: 25px !important;
                top: 10px !important;
                /* dinaikkan dari 180px ke 120px */
                padding: 2px 4px !important;
                width: 90% !important;
            }

            .tp-caption.Newspaper-Subtitle {
                font-size: 16px !important;
                line-height: 20px !important;
                top: 10px !important;
                /* dinaikkan dari 180px ke 120px */
                padding: 0 4px !important;
                width: 90% !important;
            }
        }
    </style>
    @stack('css')


</head>

<body id="bg">
    <div class="page-wraper">
        <div id="loading-icon-bx"></div>
        <!-- Header Top ==== -->
        <header class="header rs-nav header-transparent">
            <div class="sticky-header navbar-expand-lg">
                <div class="menu-bar clearfix">
                    <div class="container clearfix">
                        <!-- Header Logo ==== -->
                        <div class="menu-logo">
                            <a href="{{ url('/') }}">
                                <img src="{{ Storage::url($setting->logo) }}" alt=""></a>
                            {{--  <img src="{{ asset('template') }}/assets/images/logo-white.png" alt=""></a>  --}}
                        </div>
                        <!-- Mobile Nav Button ==== -->
                        <button class="navbar-toggler collapsed menuicon justify-content-end" type="button"
                            data-toggle="collapse" data-target="#menuDropdown" aria-controls="menuDropdown"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>

                        <!-- Navigation Menu ==== -->
                        <div class="menu-links navbar-collapse collapse justify-content-start" id="menuDropdown">
                            <div class="menu-logo">
                                <a href="{{ url('/') }}"><img src="{{ Storage::url($setting->logo) }}"
                                        alt=""></a>
                            </div>

                            <ul class="nav navbar-nav">
                                @foreach ($menuParents as $parent)
                                    @php
                                        $children = $menuChildren->where('menu_parent_id', $parent->id);
                                    @endphp

                                    @if ($children->count() > 0)
                                        <li>
                                            <a href="javascript:;">{{ $parent->menu_title }} <i
                                                    class="fa fa-chevron-down"></i></a>
                                            <ul class="sub-menu">
                                                @foreach ($children as $child)
                                                    @php
                                                        $grandchildren = $menuChildren->where(
                                                            'menu_parent_id',
                                                            $child->id,
                                                        );
                                                    @endphp
                                                    @if ($grandchildren->count() > 0)
                                                        <li>
                                                            <a href="javascript:;">{{ $child->menu_title }}<i
                                                                    class="fa fa-angle-right"></i></a>
                                                            <ul class="sub-menu">
                                                                @foreach ($grandchildren as $grandchild)
                                                                    <li>
                                                                        <a href="{{ $grandchild->menu_url }}"
                                                                            target="{{ $grandchild->menu_target }}">{{ $grandchild->menu_title }}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @else
                                                        <li>
                                                            <a href="{{ $child->menu_url }}"
                                                                target="{{ $child->menu_target }}">{{ $child->menu_title }}</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                    @else
                                        <li>
                                            <a href="{{ $parent->menu_url }}"
                                                target="{{ $parent->menu_target }}">{{ $parent->menu_title }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>

                        <!-- Navigation Menu END ==== -->
                    </div>
                </div>
            </div>
        </header>
        <!-- Header Top END ==== -->

        <!-- Content -->
        @yield('content')
        {{--  <div class="page-content bg-white">
        </div>  --}}

    </div>
    <!-- Content END-->
    <!-- Footer ==== -->
    <footer>
        <div class="footer-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start mt-2">
                        <a target="_blank" href="#">Develop By Vikar Maulana</a>
                    </div>
                    <div class="col-md-6 text-center text-md-end mt-2">
                        <span>MTS Bustanul Huda Dawuhan</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/{{ $setting->nomorwa }}" class="whatsapp-float" target="_blank"
        title="Chat via WhatsApp">
        <i class="fa fa-whatsapp whatsapp-icon"></i>
    </a>

    <!-- Style WhatsApp Button -->
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .page-wraper {
            min-height: 90vh;
            /* full viewport height */
            display: flex;
            flex-direction: column;
        }

        .page-wraper>header,
        .page-wraper>footer {
            flex-shrink: 0;
            /* header dan footer jangan mengecil */
        }

        .page-wraper>.content,
        /* pastikan yield content dibungkus div .content */
        .page-wraper>main {
            flex: 1;
            /* content mengisi sisa space */
        }

        .whatsapp-float {
            position: fixed;
            bottom: 70px;
            right: 10px;
            background-color: #25d366;
            color: white;
            border-radius: 50px;
            padding: 12px 15px;
            font-size: 24px;
            z-index: 999;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
            text-decoration: none;
        }

        .whatsapp-float:hover {
            background-color: #1ebea5;
            color: white;
        }

        .whatsapp-icon {
            margin: 0;
        }

        /* Mobile: turun lebih dekat ke bawah */
        @media (max-width: 768px) {
            .whatsapp-float {
                bottom: 20px;
            }
        }
    </style>


    <!-- Footer END ==== -->
    <button class="back-to-top fa fa-chevron-up"></button>
    </div>

    <!-- External JavaScripts -->
    <script src="{{ asset('template') }}/assets/js/jquery.min.js"></script>
    <script src="{{ asset('template') }}/assets/vendors/bootstrap/js/popper.min.js"></script>
    <script src="{{ asset('template') }}/assets/vendors/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{ asset('template') }}/assets/vendors/bootstrap-select/bootstrap-select.min.js"></script>
    <script src="{{ asset('template') }}/assets/vendors/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
    <script src="{{ asset('template') }}/assets/vendors/magnific-popup/magnific-popup.js"></script>
    <script src="{{ asset('template') }}/assets/vendors/counter/waypoints-min.js"></script>
    <script src="{{ asset('template') }}/assets/vendors/counter/counterup.min.js"></script>
    <script src="{{ asset('template') }}/assets/vendors/imagesloaded/imagesloaded.js"></script>
    <script src="{{ asset('template') }}/assets/vendors/masonry/masonry.js"></script>
    <script src="{{ asset('template') }}/assets/vendors/masonry/filter.js"></script>
    <script src="{{ asset('template') }}/assets/vendors/owl-carousel/owl.carousel.js"></script>
    <script src="{{ asset('template') }}/assets/js/functions.js"></script>
    <script src="{{ asset('template') }}/assets/js/contact.js"></script>
    <script src="{{ asset('template') }}/assets/vendors/switcher/switcher.js"></script>
    <!-- Revolution JavaScripts Files -->
    <script src="{{ asset('template') }}/assets/vendors/revolution/js/jquery.themepunch.tools.min.js"></script>
    <script src="{{ asset('template') }}/assets/vendors/revolution/js/jquery.themepunch.revolution.min.js"></script>
    <script src="{{ asset('template') }}/assets/vendors/revolution/js/extensions/revolution.extension.actions.min.js">
    </script>
    <script src="{{ asset('template') }}/assets/vendors/revolution/js/extensions/revolution.extension.carousel.min.js">
    </script>
    <script src="{{ asset('template') }}/assets/vendors/revolution/js/extensions/revolution.extension.kenburn.min.js">
    </script>
    <script
        src="{{ asset('template') }}/assets/vendors/revolution/js/extensions/revolution.extension.layeranimation.min.js">
    </script>
    <script src="{{ asset('template') }}/assets/vendors/revolution/js/extensions/revolution.extension.migration.min.js">
    </script>
    <script src="{{ asset('template') }}/assets/vendors/revolution/js/extensions/revolution.extension.navigation.min.js">
    </script>
    <script src="{{ asset('template') }}/assets/vendors/revolution/js/extensions/revolution.extension.parallax.min.js">
    </script>
    <script src="{{ asset('template') }}/assets/vendors/revolution/js/extensions/revolution.extension.slideanims.min.js">
    </script>
    <script src="{{ asset('template') }}/assets/vendors/revolution/js/extensions/revolution.extension.video.min.js">
    </script>
    <script>
        jQuery(document).ready(function() {
            var ttrevapi;
            var tpj = jQuery;
            if (tpj("#rev_slider_486_1").revolution == undefined) {
                revslider_showDoubleJqueryError("#rev_slider_486_1");
            } else {
                ttrevapi = tpj("#rev_slider_486_1").show().revolution({
                    sliderType: "standard",
                    jsFileLocation: "assets/vendors/revolution/js/",
                    sliderLayout: "fullwidth",
                    dottedOverlay: "none",
                    delay: 3000,
                    navigation: {
                        keyboardNavigation: "on",
                        keyboard_direction: "horizontal",
                        mouseScrollNavigation: "off",
                        mouseScrollReverse: "default",
                        onHoverStop: "on",
                        touch: {
                            touchenabled: "on",
                            swipe_threshold: 75,
                            swipe_min_touches: 1,
                            swipe_direction: "horizontal",
                            drag_block_vertical: false
                        },
                        arrows: {
                            style: "uranus",
                            enable: true,
                            hide_onmobile: false,
                            hide_onleave: false,
                            tmp: '',
                            left: {
                                h_align: "left",
                                v_align: "center",
                                h_offset: 10,
                                v_offset: 0
                            },
                            right: {
                                h_align: "right",
                                v_align: "center",
                                h_offset: 10,
                                v_offset: 0
                            }
                        },

                    },
                    viewPort: {
                        enable: true,
                        outof: "pause",
                        visible_area: "80%",
                        presize: false
                    },
                    responsiveLevels: [1240, 1024, 778, 480],
                    visibilityLevels: [1240, 1024, 778, 480],
                    gridwidth: [1240, 1024, 778, 480],
                    gridheight: [768, 600, 600, 600],
                    lazyType: "none",
                    parallax: {
                        type: "scroll",
                        origo: "enterpoint",
                        speed: 400,
                        levels: [5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 46, 47, 48, 49, 50, 55],
                        type: "scroll",
                    },
                    shadow: 0,
                    spinner: "off",
                    stopLoop: "off",
                    stopAfterLoops: -1,
                    stopAtSlide: -1,
                    shuffle: "off",
                    autoHeight: "off",
                    hideThumbsOnMobile: "off",
                    hideSliderAtLimit: 0,
                    hideCaptionAtLimit: 0,
                    hideAllCaptionAtLilmit: 0,
                    debugMode: false,
                    fallbacks: {
                        simplifyAll: "off",
                        nextSlideOnWindowFocus: "off",
                        disableFocusListener: false,
                    }
                });
            }
        });
    </script>

    <script src="{{ asset('/sw.js') }}"></script>
    <script>
        if ("serviceWorker" in navigator) {
            // Register a service worker hosted at the root of the
            // site using the default scope.
            navigator.serviceWorker.register("/sw.js").then(
                (registration) => {
                    //console.log("Service worker registration succeeded:", registration);
                },
                (error) => {
                    console.error(`Service worker registration failed: ${error}`);
                },
            );
        } else {
            console.error("Service workers are not supported.");
        }
    </script>
    <script>
        // Show password
        $('#customCheck1').on('click', function() {
            if ($(this).is(':checked')) {
                $('.password').attr('type', 'text');
            } else {
                $('.password').attr('type', 'password');
            }
        })
    </script>

    <script>
        window.addEventListener("scroll", function() {
            const header = document.querySelector(".sticky-header");
            if (window.scrollY > 50) {
                header.classList.add("scrolled");
            } else {
                header.classList.remove("scrolled");
            }
        });
    </script>

</body>

</html>
