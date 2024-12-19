@include('sweetalert::alert')
@php
    $config = DB::table('configs')->first();
    $service = DB::table('services')->get();
    $produit = DB::table('produits')->get();
@endphp

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>KONICA</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ Storage::url($config->icon ?? ' ') }}">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/assets/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/vendor/font-awesome.css">
    <link rel="stylesheet" href="/assets/css/vendor/flaticon/flaticon.css">
    <link rel="stylesheet" href="/assets/css/vendor/slick.css">
    <link rel="stylesheet" href="/assets/css/vendor/slick-theme.css">
    <link rel="stylesheet" href="/assets/css/vendor/jquery-ui.min.css">
    <link rel="stylesheet" href="/assets/css/vendor/sal.css">
    <link rel="stylesheet" href="/assets/css/vendor/magnific-popup.css">
    <link rel="stylesheet" href="/assets/css/vendor/base.css">
    <link rel="stylesheet" href="/assets/css/style.min.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/Script.js"></script>
    @yield('header')

</head>


<style>
    .btn-bg-primary2 {
        background-color: #0162b1;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
    }

    .btn-bg-secondary2 {
        background-color: #EFB121;
        
        color: #ffffff;
        
        border: none;
        padding: 10px 20px;
        
        border-radius: 5px;
        
        text-decoration: none;
        
    }
</style>


<body class="sticky-header overflow-md-visible">
 
    <a href="#top" class="back-to-top" id="backto-top"><i class="fal fa-arrow-up"></i></a>
    <!-- Start Header -->
    <header class="header axil-header header-style-7">
        <div class="axil-header-top">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="header-top-text">
                            <p><i class="fas fa-star"></i>
                                {{ \App\Helpers\TranslationHelper::TranslateText('Livraison gratuite pour les commandes de plus de 1000 DT') }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="header-top-link">
                            <ul class="quick-link">
                                <div class="header-top-dropdown">
                                    <div class="dropdown">
                                     

                                        <form action="{{ route('locale.change') }}" method="POST">
                                            @csrf
                                            <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                {{ app()->getLocale() == 'fr' ? 'Français' : (app()->getLocale() == 'en' ? 'English' : 'العربية') }}
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <button type="submit" name="locale" value="fr"
                                                        class="dropdown-item">
                                                        <img src="https://img.icons8.com/color/20/france-circular.png"
                                                            alt="fr">
                                                        Français
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="submit" name="locale" value="en"
                                                        class="dropdown-item">
                                                        <img src="https://img.icons8.com/color/20/great-britain-circular.png"
                                                            alt="en">
                                                        English
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="submit" name="locale" value="ar"
                                                        class="dropdown-item">
                                                        <img src="https://img.icons8.com/color/20/saudi-arabia-circular.png"
                                                            alt="ar">
                                                        العربية
                                                    </button>
                                                </li>
                                            </ul>
                                        </form>

                                    </div>
                                    <div class="dropdown">

                                    </div>
                                </div>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     
        <div id="axil-sticky-placeholder"></div>
        <div class="axil-mainmenu">
            <div class="container-fluid">
                <div class="header-navbar">

                    <div class="header-brands">
                        <a href="{{ route('home') }}" class="logo logo-dark site-logo">
                            <img src="{{ Storage::url($config->logo ?? ' ') }}" alt="Site Logo">
                        </a>
                        <a href="{{ route('home') }}" class="logo logo-light site-logo">
                            <img src="{{ Storage::url($config->logo ?? ' ') }}" alt="Site Logo">
                        </a>

                        <style>

.site-logo {
                            display: flex;
                            align-items: center;
                            text-decoration: none;
                            padding: 0px;
                        }


                        .top-bar__logo {
                            position: relative;
                            margin-left: 2px;
                            z-index: 6
                        }

                        .top-bar__logo img {
                            height: 90px
                        }


                        .site-logo img {
                            height: 250px;
                            width: 150px;
                            object-fit: contain;
                            transition: transform 0.3s ease;
                            margin-top: -21px;
                        }

                        @media (max-width: 768px) {
                            .site-logo img {
                                height: 200px;
                                width: 200px;
                                margin-top: 30;
                                padding: 10;
                                margin-left: 20px;



                            }
                        }

                     

                        .site-logo {
                            padding: 5px;
                        }

                        .site-logo img {
                            max-height: 60px;
                            width: 250px;
                        }

                            .header-brands img {

                                object-fit: contain;
                                transition: transform 0.3s ease;
                                margin-top: 50px;
                            }


                        </style>
                    </div>
                 
                    <div class=" header-main-nav">
                        <nav class="mainmenu-nav">
                            <button class="mobile-close-btn mobile-nav-toggler"><i class="fas fa-times"></i></button>


                            <div class="mobile-nav-brand header-brands">
                                <a href="{{ route('home') }}" class="logo logo-dark">
                                    <img src="{{ Storage::url($config->logo ?? ' ') }}" alt="Site Logo">
                                </a>
                                <a href="{{ route('home') }}" class="logo logo-light">
                                    <img src="{{ Storage::url($config->logo ?? ' ') }}" alt="Site Logo">
                                </a>
                            </div>

                            <ul class="mainmenu">

                                <style>
                                    #dropdown-header-menu {
                                        color: #ffffff;
                                      
                                        background-color: #0162b1;
                                       
                                        border: 1px solid #0162b1;
                                    
                                        padding: 8px 12px;
                                      
                                        border-radius: 4px;
                                      
                                    }

                             
                                    #dropdown-header-menu[aria-expanded="true"] {
                                        background-color: #0162b1;
                                        
                                        color: #ffffff;
                                        
                                        border-color: #EFB121;
                                       
                                    }

                                 
                                    #dropdown-header-menu .fa-th-large {
                                        font-size: 20px;
                                    
                                        margin-right: 5px;
                                        
                                    }

                                 
                                    #dropdown-header-menu:hover {
                                        background-color: #0162b1;
                                    
                                        color: #ffffff;
                                      
                                        border-color: #0162b1;
                                      
                                    }
                                </style>

                                <li class="dropdown">
                                    <a class="dropdown-toggle" href="#" role="button"
                                        id="dropdown-header-menu" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="far fa-th-large"></i>
                                        {{ \App\Helpers\TranslationHelper::TranslateText('Categories') }}
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdown-header-menu">
                                        @foreach ($categories as $category)
                                            <li>

                                                <a class="dropdown-item1 @class([
                                                    'selected' =>
                                                        isset($current_category) && $current_category->id === $category->id,
                                                ])"
                                                    href="/category/{{ $category->id }}"
                                                    style="color: {{ isset($current_category) && $current_category->id === $category->id ? '#EFB121' : '#000000' }};">
                                                    {{ $category->nom ?? ' ' }}
                                                </a>

                                            </li>
                                        @endforeach
                                    </ul>
                                </li>



                                <li class="menu-item"><a href="{{ route('home') }}">{{ __('accueil') }}</a>

                                </li>


                                </li class="menu-item">
                                <a href="{{ route('about') }}">
                                    {{ \App\Helpers\TranslationHelper::TranslateText('A propos') }}</a>
                                </li>



                                <li class="menu-item">
                                    <a href="{{ route('shop') }}">{{ __('boutique') }}</a>
                                </li>


                                <li class="menu-item"><a href="{{ route('contact') }}">
                                        {{ \App\Helpers\TranslationHelper::TranslateText('Contact') }}</a></li>

                            </ul>
                        </nav>
                    </div>
                    <div class="header-action">
                        <ul class="action-list">

                            <li class="axil-search d-xl-block d-none w-4">
                                <input type="search" class="placeholder product-search-input small-input"
                                    name="search2" id="search2" maxlength="128"
                                    placeholder="  {{ \App\Helpers\TranslationHelper::TranslateText('Rechercher un produit') }}"
                                    autocomplete="off" style="width: 250px;">
                                <button type="submit" class="icon wooc-btn-search">
                                    <i class="flaticon-magnifying-glass"></i>
                                </button>
                            </li>


                            <li class="axil-search d-md-none w-4" style="transition: background-color 0.3s;">
                                <a href="javascript:void(0)" class="header-search-icon" title="Search">
                                    <i class="far fa-search"></i>
                                </a>
                            </li>

                            <style>
                                .axil-search:hover {
                                    background-color: #f0f0f0;

                                }
                            </style>


                            <li class="shopping-cart">
                                <a href="#" class="cart-dropdown-btn">
                                    <span class="cart-count" id="count-panier-span">00</span>
                                    <i class="far fa-shopping-cart"></i>
                                </a>
                            </li>
                            <li class="wishlist">
                                <a href="{{ route('favories') }}">
                                    <i class="far fa-heart"></i>
                                </a>
                            </li>
                            <li class="my-account">
                                <a href="javascript:void(0)">
                                    <i class="far fa-user"></i>
                                </a>
                                <div class="my-account-dropdown">

                                    @if (Auth()->user())
                                        <ul>
                                            @if (auth()->user()->role != 'client')
                                                <li><a href="{{ url('dashboard') }}">Dashboard</a>
                                                </li>
                                            @endif
                                            <li>
                                                <a href="{{ route('account') }}">
                                                    {{ \App\Helpers\TranslationHelper::TranslateText('Mon compte') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('favories') }}">
                                                    {{ \App\Helpers\TranslationHelper::TranslateText('Mes favoris') }}</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('cart') }}">
                                                    {{ \App\Helpers\TranslationHelper::TranslateText('Mon panier') }}</a>
                                            </li>
                                            <li>

                                                <a class="dropdown-item" href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();   document.getElementById('logout-form').submit();">
                                                    {{ \App\Helpers\TranslationHelper::TranslateText('Déconnexion') }}
                                                </a>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                    class="d-none">
                                                    @csrf
                                                </form>
                                            </li>




                                        </ul>
                                    @else
                                        <div class="login-btn">
                                            <a href="{{ url('login') }}" class="axil-btn btn-bg-primary2">
                                                {{ \App\Helpers\TranslationHelper::TranslateText('Connexion') }}</a>
                                        </div>

                                        <div class="reg-footer text-center">
                                            {{ \App\Helpers\TranslationHelper::TranslateText('Pas de compte') }}? <a
                                                href="{{ url('register') }}" class="btn-link">
                                                {{ \App\Helpers\TranslationHelper::TranslateText('Inscrivez vous ici') }}.</a>
                                        </div>
                                    @endif

                                </div>


                                <style>
                                    .dropbtn img {
                                        margin-right: 8px;
                                    }

                                    .dropdown-content {
                                        display: none;
                                        position: absolute;
                                        background-color: #ffffff;
                                        min-width: 150px;
                                        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
                                        z-index: 1;
                                        border: 1px solid #ccc;
                                        border-radius: 5px;
                                    }

                                    .dropdown-content .dropdown-item {
                                        display: flex;
                                        align-items: center;
                                        padding: 10px 15px;
                                        background-color: transparent;
                                        border: none;
                                        width: 100%;
                                        text-align: left;
                                        cursor: pointer;
                                        margin: 2px 0;
                                    }


                                    .dropdown-content .dropdown-item img {
                                        margin-right: 8px;
                                    }

                                    .dropdown-content .dropdown-item:hover {
                                        background-color: #f0f0f0;
                                    }

                                    .dropdown:hover .dropdown-content {
                                        display: block;
                                    }

                                    .top-bar__navigation .active {
                                        font-weight: bold;
                                    }

                                    .large-text {
                                        font-size: 24px;
                                       
                                    }
                                </style>


                            </li>
                    
                            <li class="axil-mobile-toggle">
                                <button class="menu-btn mobile-nav-toggler">
                                    <i class="flaticon-menu-2"></i>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Mainmenu Area -->
    </header>
    <!-- End Header -->



    <main>



        @yield('body')




    </main>

    <footer class="axil-footer-area footer-style-2">
        <!-- Start Footer Top Area  -->
        <div class="footer-top separator-top">
            <div class="container">
                <div class="row">
                    <!-- Start Single Widget  -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="axil-footer-widget">
                            <h5 class="widget-title"></h5>
                            <style>
                                .logo {
                                    position: relative;
                                    top: -30px;
                                    
                                }
                            </style>
                            <div class="logo mb--30">
                                <a href="{{ route('home') }}">
                                    <img class="light-logo" src="{{ Storage::url($config->logofooter ?? ' ') }}"
                                        alt="Logo" height="200" width="200">
                                </a>
                            </div>

                            <p class="logo" style="font-size: 18px; line-height: 1.6; text-align: justify;">

                                {!! \App\Helpers\TranslationHelper::TranslateText($config->description) !!}
                            </p>


                        </div>
                    </div>
                
                    <div class="col-lg-3 col-sm-6">
                        <div class="axil-footer-widget">
                            <h5 class="widget-title">
                                {{ \App\Helpers\TranslationHelper::TranslateText('Mon compte') }}</h5>
                            <div class="inner">
                                <ul>
                                    @if (Auth()->user())
                                        <li><a href="{{ route('profile') }}">
                                                {{ \App\Helpers\TranslationHelper::TranslateText('Paramètres') }}</a>
                                        </li>
                                        <li><a href="{{ route('favories') }}">
                                                {{ \App\Helpers\TranslationHelper::TranslateText('Mes favoris') }}</a>
                                        </li>
                                        <li><a href="{{ route('cart') }}">
                                                {{ \App\Helpers\TranslationHelper::TranslateText('Mon panier') }}</a>
                                        </li>
                                        @else
                                        <li><a href="{{ route('login') }}">
                                            {{ \App\Helpers\TranslationHelper::TranslateText('Se connecter') }}</a></li>
                                        <li><a href="{{ route('register') }}">
                                            {{ \App\Helpers\TranslationHelper::TranslateText('S\'  inscrire' ) }}</a></li>

                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                 
                    <div class="col-lg-3 col-sm-6">
                        <div class="axil-footer-widget">
                            <h5 class="widget-title"> {{ \App\Helpers\TranslationHelper::TranslateText(' Pages') }}
                            </h5>
                            <div class="inner">
                                <ul>
                                    <li><a href="{{ route('home') }}">
                                            {{ \App\Helpers\TranslationHelper::TranslateText('Accueil') }}</a></li>
                                    <li><a href="{{ route('about') }}">
                                            {{ \App\Helpers\TranslationHelper::TranslateText('A propos de nous') }}</a>
                                    </li>

                                    <li><a href="{{ route('shop') }}">
                                            {{ \App\Helpers\TranslationHelper::TranslateText('Produits') }}</a></li>
                                    <li><a href="{{ route('contact') }}">
                                            {{ \App\Helpers\TranslationHelper::TranslateText('Contact') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                 
                    <div class="col-lg-3 col-sm-6">
                        <div class="axil-footer-widget">
                            <h5 class="widget-title">
                                {{ \App\Helpers\TranslationHelper::TranslateText('Contact info') }}
                            </h5>
                            <div class="inner">
                             
                                <div class="download-btn-group">

                                    <div class="inner">

                                        <ul class="support-list-item">
                                            <li><a href="mailto:example@domain.com"><i
                                                        class="fal fa-envelope-open"></i>
                                                    {{ $config->email ?? ' ' }}</a></li>
                                            <li><a href="tel:(+01)850-315-5862"><i
                                                        class="fal fa-phone-alt"></i>{{ $config->telephone ?? ' ' }}</a>
                                            </li>
                                            <li><i class="fal fa-map-marker-alt"></i>{{ $config->addresse ?? ' ' }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                </div>
            </div>
        </div>
  
        <div class="copyright-area copyright-default separator-top">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-4">

                    </div>
                    <div class="col-xl-4 col-lg-12">
                        <div class="copyright-left d-flex flex-wrap justify-content-center">
                            <ul class="quick-link">
                                <li>©{{ date('Y') }} KONICA | Design By<a
                                        href="https://www.e-build.tn" style="color: #c71f17;">
                                        <b> E-build </b>
                                    </a>.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-12">
                        <div
                            class="copyright-right d-flex flex-wrap justify-content-xl-end justify-content-center align-items-center">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Copyright Area  -->
    </footer>
    <!-- End Footer Top Area  -->


    <!-- End Footer Area  -->


    <!-- Product Quick View Modal Start -->
    <div class="modal fade quick-view-product" id="quick-view-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="far fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <div class="single-product-thumb">
                        <div class="row">
                            <div class="col-lg-7 mb--40">
                                <div class="row">
                                    <div class="col-lg-10 order-lg-2">
                                        <div
                                            class="single-product-thumbnail product-large-thumbnail axil-product thumbnail-badge zoom-gallery">
                                            <div class="thumbnail">
                                                <img src="assets/images/product/product-big-01.png"
                                                    alt="Product Images">
                                                <div class="label-block label-right">
                                                    <div class="product-badget">20% OFF</div>
                                                </div>
                                                <div class="product-quick-view position-view">
                                                    <a href="assets/images/product/product-big-01.png"
                                                        class="popup-zoom">
                                                        <i class="far fa-search-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="thumbnail">
                                                <img src="assets/images/product/product-big-02.png"
                                                    alt="Product Images">
                                                <div class="label-block label-right">
                                                    <div class="product-badget">20% OFF</div>
                                                </div>
                                                <div class="product-quick-view position-view">
                                                    <a href="assets/images/product/product-big-02.png"
                                                        class="popup-zoom">
                                                        <i class="far fa-search-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="thumbnail">
                                                <img src="assets/images/product/product-big-03.png"
                                                    alt="Product Images">
                                                <div class="label-block label-right">
                                                    <div class="product-badget">20% OFF</div>
                                                </div>
                                                <div class="product-quick-view position-view">
                                                    <a href="assets/images/product/product-big-03.png"
                                                        class="popup-zoom">
                                                        <i class="far fa-search-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 order-lg-1">
                                        <div class="product-small-thumb small-thumb-wrapper">
                                            <div class="small-thumb-img">
                                                <img src="assets/images/product/product-thumb/thumb-08.png"
                                                    alt="thumb image">
                                            </div>
                                            <div class="small-thumb-img">
                                                <img src="assets/images/product/product-thumb/thumb-07.png"
                                                    alt="thumb image">
                                            </div>
                                            <div class="small-thumb-img">
                                                <img src="assets/images/product/product-thumb/thumb-09.png"
                                                    alt="thumb image">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 mb--40">
                                <div class="single-product-content">
                                    <div class="inner">
                                        <div class="product-rating">
                                            <div class="star-rating">
                                                <img src="assets/images/icons/rate.png" alt="Rate Images">
                                            </div>
                                            <div class="review-link">
                                                <a href="#">(<span>1</span> customer reviews)</a>
                                            </div>
                                        </div>
                                        <h3 class="product-title">Serif Coffee Table</h3>
                                        <span class="price-amount">$155.00 - $255.00</span>
                                        <ul class="product-meta">
                                            <li><i class="fal fa-check"></i>In stock</li>
                                            <li><i class="fal fa-check"></i>Free delivery available</li>
                                            <li><i class="fal fa-check"></i>Sales 30% Off Use Code: MOTIVE30</li>
                                        </ul>
                                        <p class="description">In ornare lorem ut est dapibus, ut tincidunt nisi
                                            pretium. Integer ante est, elementum eget magna. Pellentesque sagittis
                                            dictum libero, eu dignissim tellus.</p>

                                        <div class="product-variations-wrapper">

                                            <!-- Start Product Variation  -->
                                            <div class="product-variation">
                                                <h6 class="title">Colors:</h6>
                                                <div class="color-variant-wrapper">
                                                    <ul class="color-variant mt--0">
                                                        <li class="color-extra-01 active"><span><span
                                                                    class="color"></span></span>
                                                        </li>
                                                        <li class="color-extra-02"><span><span
                                                                    class="color"></span></span>
                                                        </li>
                                                        <li class="color-extra-03"><span><span
                                                                    class="color"></span></span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- End Product Variation  -->

                                            <!-- Start Product Variation  -->
                                            <div class="product-variation">
                                                <h6 class="title">Size:</h6>
                                                <ul class="range-variant">
                                                    <li>xs</li>
                                                    <li>s</li>
                                                    <li>m</li>
                                                    <li>l</li>
                                                    <li>xl</li>
                                                </ul>
                                            </div>
                                         

                                        </div>

                                     
                                        <div class="product-action-wrapper d-flex-center">
                                           
                                            <div class="pro-qty"><input type="text" value="1"></div>
                                         
                                            <ul class="product-action d-flex-center mb--0">
                                                <li class="add-to-cart"><a href="cart.html"
                                                        class="axil-btn btn-bg-primary2">Add to Cart</a></li>
                                                <li class="wishlist"><a href="wishlist.html"
                                                        class="axil-btn wishlist-btn"><i class="far fa-heart"></i></a>
                                                </li>
                                            </ul>
                                

                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="header-search-modal" id="header-search-modal">
        <button class="card-close sidebar-close"><i class="fas fa-times"></i></button>
        <div class="header-search-wrap">
            <div class="card-header">
                <form role="search" action="{{ url('search') }}" method="get">
                    <div class="input-group">
                        <input value="{{ $nom ?? '' }}" class="form-control" id="search" type="search"
                            name="search"
                            placeholder="  {{ \App\Helpers\TranslationHelper::TranslateText('Rechercher produit') }}">

                        <button type="submit" class="axil-btn btn-bg-primary"><i class="far fa-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="search-result-header">
                    <h6 class="title"></h6>
                    <a href="{{ route('shop') }}" class="view-all">
                        {{ \App\Helpers\TranslationHelper::TranslateText('Voir tout') }}
                    </a>
                </div>
                <div class="psearch-results">
                    @if (isset($searchproducts))
                        @foreach ($searchproducts as $produit)
                            <div class="axil-product-list">
                                <div class="thumbnail">
                                    <a
                                        href="{{ route('details-produits', ['id' => $produit->id, 'slug' => Str::slug(Str::limit($produit->nom, 10))]) }}">
                                        <img width="100" height="100" src="{{ Storage::url($produit->photo) }}"
                                            alt="Yantiti Leather Bags">
                                    </a>
                                </div>
                                <div class="product-content">
                                    <div class="product-rating">

                                    </div>
                                    <h6 class="product-title"><a
                                            href="{{ route('details-produits', ['id' => $produit->id, 'slug' => Str::slug(Str::limit($produit->nom, 10))]) }}">
                                            {!! \App\Helpers\TranslationHelper::TranslateText($produit->nom ?? '') !!}
                                        </a>
                                    </h6>

                                    <div class="product-price-variant">
                                        @if ($produit->inPromotion() && $produit->sur_devis == false)
                                            <span class="price current-price"><b class="text-success"
                                                    style="color: #4169E1">
                                                    {{ $produit->getPrice() }} DT
                                                </b></span>
                                            <span class="price old-price">
                                                <span class="price old-price"
                                                    style="position: relative; font-size: 1.2rem; color: #dc3545; font-weight: bold;">
                                                    {{ $produit->prix }} DT
                                                    <span
                                                        style="position: absolute; top: 50%; left: 0; width: 100%; height: 2px; background-color: black;"></span>
                                                </span>
                                            </span>
                                        @elseif($produit->sur_devis == false)
                                            {{ $produit->getPrice() }}DT
                                        @endif

                                    </div>
                                    <div class="product-cart">
                                        @if ($produit->sur_devis == false)
                                            <a onclick="AddToCart( {{ $produit->id }} )" class="cart-btn"><i
                                                    class="fal fa-shopping-cart"></i></a>
                                        @else
                                          
                                            <a class="axil-btn  btn-bg-primary2 "
                                                href="{{ url('devis', $produit->id) }}">
                                                {{ \App\Helpers\TranslationHelper::TranslateText('Demmander devis') }}
                                            </a>
                                          
                                        @endif
                                        @if (Auth()->user())
                                            <a onclick="AddFavoris({{ $produit->id }})" class="cart-btn"><i
                                                    class="fal fa-heart"></i></a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>
  




    <div class="cart-dropdown" id="cart-dropdown">
        <div class="cart-content-wrap">
            <div class="cart-header">
                <h2 class="header-title"> {{ \App\Helpers\TranslationHelper::TranslateText('Mon panier') }}</h2>
                <button class="cart-close sidebar-close"><i class="fas fa-times"></i></button>
            </div>
            <div class="cart-body">
                <ul class="cart-item-list" id="list_content_panier">

                 


                </ul>
            </div>
            <div class="cart-footer">
                <h3 class="cart-subtotal">
                    <span class="subtotal-title">Subtotal:</span>
                    <span class="subtotal-amount" id="montant_total_panier">00</span>
                </h3>
                <div class="group-btn">
                    <a href="{{ route('cart') }}" class="axil-btn btn-bg-primary2 viewcart-btn">
                        {{ \App\Helpers\TranslationHelper::TranslateText('Voir panier') }}
                    </a>
                    <a href="{{ url('/commander') }}" class="axil-btn btn-bg-secondary2 checkout-btn">
                        {{ \App\Helpers\TranslationHelper::TranslateText('Passer commande') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

  
    <!-- JS
============================================ -->
    <!-- Modernizer JS -->
    <script src="/assets/js/vendor/modernizr.min.js"></script>
    <!-- jQuery JS -->
    <script src="/assets/js/vendor/jquery.js"></script>
    <!-- Bootstrap JS -->
    <script src="/assets/js/vendor/popper.min.js"></script>
    <script src="/assets/js/vendor/bootstrap.min.js"></script>
    <script src="/assets/js/vendor/slick.min.js"></script>
    <script src="/assets/js/vendor/js.cookie.js"></script>
    <!-- <script src="assets/js/vendor/jquery.style.switcher.js"></script> -->
    <script src="/assets/js/vendor/jquery-ui.min.js"></script>
    <script src="/assets/js/vendor/jquery.ui.touch-punch.min.js"></script>
    <script src="/assets/js/vendor/jquery.countdown.min.js"></script>
    <script src="/assets/js/vendor/sal.js"></script>
    <script src="/assets/js/vendor/jquery.magnific-popup.min.js"></script>
    <script src="/assets/js/vendor/imagesloaded.pkgd.min.js"></script>
    <script src="/assets/js/vendor/isotope.pkgd.min.js"></script>
    <script src="/assets/js/vendor/counterup.js"></script>
    <script src="/assets/js/vendor/waypoints.min.js"></script>

    <!-- Main JS -->
    <script src="/assets/js/main.js"></script>

</body>

</html>
