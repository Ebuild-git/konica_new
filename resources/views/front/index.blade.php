@extends('front.fixe')
@section('titre', 'Accueil')
@section('body')
    <main>
        @php

            $service = DB::table('services')->get();
            $produit = DB::table('produits')->get();
            $config = DB::table('configs')->first();
            $configs = DB::table('configs')->first();
        @endphp


        <main class="main-wrapper">

            <div class="container-fluid px-0 mb-5">
                <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($banners as $key => $banner)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <img class="d-block w-100" src="{{ Storage::url($banner->image) }}" alt="Image">


                                <div class="carousel-caption  d-md-block">
                                    <div class="container">

                                        <div class="main-slider-content">
                                            <span class="subtitle" style="color: #ffffff"><i class="fas fa-fire"></i>

                                                {{ \App\Helpers\TranslationHelper::TranslateText($banner->titre ?? ' ') }}
                                            </span>
                                            <p style="font-size: 1.5rem;   color: #ffffff;  margin-top: 10px; ">

                                                {{ \App\Helpers\TranslationHelper::TranslateText($banner->sous_titre ?? ' ') }}
                                            </p>

                                        </div>
                                        <div class="shop-btn d-flex justify-content-center">
                                            <a href="{{ route('shop') }}" class="axil-btn btn-bg-primary2 right-icon">

                                                {{ \App\Helpers\TranslationHelper::TranslateText('Voir boutique') }}
                                                <i class="fal fa-long-arrow-right"></i>
                                            </a>
                                        </div>




                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#header-carousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <div class="axil-about-area about-style-1 axil-section-gap ">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-4 col-lg-6">
                            <div class="about-thumbnail">
                                <div class="thumbnail">
                                    <img src="{{ Storage::url($config->image_apropos) }}" alt="About Us">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-6">
                            <div class="about-content content-right">
                             <h4>   <span class="axil-breadcrumb-item1 active" aria-current="page"> <i class="far fa-shopping-basket"></i>  {{ \App\Helpers\TranslationHelper::TranslateText('A propos de nous') }}</span> </h4>
                               {{--  <span class="title-highlighter highlighter-primary2"> <i class="far fa-shopping-basket"></i>A Propos de nous</span>
                               --}}  <h3 class="title">
                                {{ \App\Helpers\TranslationHelper::TranslateText($config->titre_appros ?? '') }}
                               </h3>

                                <div class="row">
                                    <div class="col-xl-12">
                                        <p style="text-align: justify">
                                            {!! \App\Helpers\TranslationHelper::TranslateText($config->des_apropos ?? ' ') !!}
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="axil-categorie-area bg-color-white axil-section-gapcommon">
                <div class="container">
                    <div class="section-title-wrapper">
                        <h4> <span class="axil-breadcrumb-item1 active" aria-current="page"> <i class="far fa-tags"></i>
                                {{ \App\Helpers\TranslationHelper::TranslateText('Categories') }}</span> </h4>
                        <h2 class="title">
                            {{ \App\Helpers\TranslationHelper::TranslateText('Parcourrir par categories') }}
                        </h2>
                    </div>
                    <div
                        class="explore-product-activation slick-layout-wrapper slick-layout-wrapper--15 axil-slick-arrow arrow-top-slide">
                        <div class="slick-single-layout">
                            <div class="row row--15">
                                @foreach ($categories as $category)
                                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12 mb--30">
                                        <div class="axil-product product-style-one"
                                            style="border: 1px solid #0162b1; border-radius: 8px; overflow: hidden;">
                                            <div class="thumbnail">
                                                <a
                                                    href="#">
                                                    <img data-sal="zoom-out" data-sal-delay="200" data-sal-duration="800"
                                                        loading="lazy" class="main-img" border-radius="8px"
                                                        src="{{ Storage::url($category->photo) }}" alt="Product Images">
                                                    <img class="hover-img" border-radius="8px"
                                                        src="{{ Storage::url($category->photo) }}" alt="Product Images">
                                                </a>
                                            </div>
                                            <div class="product-content">
                                                <div class="inner">
                                                    <div class="">
                                                        <h5 class="title text-center "><a
                                                                href="#">
                                                                {{ \App\Helpers\TranslationHelper::TranslateText($category->nom ?? '') }}

                                                            </a>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <div class="axil-product-area bg-color-white axil-section-gap">
                <div class="container">
                    <div class="section-title-wrapper">

                        <h4> <span class="axil-breadcrumb-item1 active" aria-current="page"> <i
                                    class="far fa-shopping-basket"></i>
                                {{ \App\Helpers\TranslationHelper::TranslateText('Nos produits') }}</span> </h4>

                        <h2 class="title">
                            {{ \App\Helpers\TranslationHelper::TranslateText('Parcourir nos produits ') }}
                        </h2>
                    </div>
                    <div
                        class="explore-product-activation slick-layout-wrapper slick-layout-wrapper--15 axil-slick-arrow arrow-top-slide">
                        <div class="slick-single-layout">
                            <div class="row row--15">
                                @foreach ($produits as $produit)
                                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12 mb--30">
                                        <div class="axil-product product-style-one"
                                            style="border: 1px solid #0162b1; border-radius: 8px; overflow: hidden;">


                                            <div class="thumbnail">
                                                <a
                                                    href="{{ route('details-produits', ['id' => $produit->id, 'slug' => Str::slug(Str::limit($produit->nom, 10))]) }}">
                                                    <img data-sal="zoom-out" data-sal-delay="200" data-sal-duration="800"
                                                        loading="lazy" class="main-img" border-radius="8px"
                                                        src="{{ Storage::url($produit->photo) }}" alt="Product Images">
                                                    <img class="hover-img" border-radius="8px"
                                                        src="{{ Storage::url($produit->photo) }}" alt="Product Images">
                                                </a>

                                                <div class="top-left" style="background-color: #e01010;color: white;">
                                                    <span>
                                                        @if ($produit->sur_devis == false)
                                                            @if ($produit->inPromotion())
                                                                <span>
                                                                    -{{ $produit->inPromotion()->pourcentage }}%</span>
                                                            @endif
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="product-hover-action">
                                                    <ul class="cart-action">
                                                        @if ($produit->sur_devis == false)
                                                            <li class="select-option2">
                                                                <a onclick="AddToCart( {{ $produit->id }} )">
                                                                    {{ \App\Helpers\TranslationHelper::TranslateText('Ajouter au panier') }}
                                                                </a>
                                                            </li>
                                                        @else
                                                            <li class="select-option2">
                                                                <a href="{{ url('devis', $produit->id) }}"
                                                                    style="font-size: 1.7rem; color: white;">
                                                                    {{ \App\Helpers\TranslationHelper::TranslateText('Demmander devis') }}
                                                                </a>
                                                            </li>
                                                        @endif


                                                        @if (Auth()->user())
                                                            @php

                                                                $count = DB::table('favoris')
                                                                    ->where('id_user', Auth()->user()->id)
                                                                    ->where('id_produit', $produit->id)
                                                                    ->count();
                                                            @endphp


                                                            <li class="wishlist"><a
                                                                    onclick="AddFavoris({{ $produit->id }})"
                                                                    @if ($count == 0) class="" style="color:#000000" @else class="" style="color: #dc3545; background-color:#dc3545" @endif>

                                                                    <i class="far fa-heart"></i></a></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="inner">
                                                    <div class="product-rating">

                                                    </div>

                                                    <div class="">
                                                        <h5 class="title text-center "><a
                                                                href="{{ route('details-produits', ['id' => $produit->id, 'slug' => Str::slug(Str::limit($produit->nom, 10))]) }}">
                                                                {{ \App\Helpers\TranslationHelper::TranslateText(Str::limit($produit->nom, 15)) }}

                                                            </a>
                                                        </h5>
                                                    </div>
                                                    <div class="product__price__wrapper">
                                                        <h6 class="product-price--main">
                                                            @if ($produit->inPromotion())
                                                                <div class="row text-center">
                                                                    <div class="col-sm-6 col-6">

                                                                        <b class="text-success" style="color: #4169E1">
                                                                            {{ $produit->getPrice() }} DT


                                                                        </b>
                                                                    </div>

                                                                    <div class="col-sm-6 col-6 text-center">
                                                                        <strike>


                                                                            <span
                                                                                style="font-size: 1.7rem; color: #dc3545; font-weight: bold;">
                                                                                {{ $produit->prix }} DT
                                                                            </span>


                                                                        </strike>
                                                                    </div>
                                                                @else

                                                                    <div class="text-center">
                                                                        <span class="price current-price"
                                                                            style="font-size: 1.7rem;">
                                                                            @if($produit->getPrice())
                                                                            {{ $produit->getPrice() }} <x-devise></x-devise>
                                                                            @else
                                                                            <br>

                                                                            @endif


                                                                        </span>
                                                                    </div>




                                                            @endif

                                                        </h6>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center mt--20 mt_sm--0">
                            <a href="{{ route('shop') }}" class="axil-btn btn-bg-primary2 btn-load-more">

                                {{ \App\Helpers\TranslationHelper::TranslateText('Voir tous les produits') }}
                            </a>
                        </div>
                    </div>

                </div>
            </div>




            <br><br>

            <!-- Start About Area  -->
            <div class="about-info-area">
                <div class="container">
                    <div class="row row--20">
                        <div class="col-lg-4">
                            <div class="about-info-box">
                                <div class="thumb image-center">
                                    <img src="{{ Storage::url($config->icone_satisfaction ?? '') }}" width="100"
                                        height="100" alt="Shape">
                                </div>


                                <div class="content">
                                    <h5 class="title" style="text-align: justify">
                                        {!! \App\Helpers\TranslationHelper::TranslateText($config->titre_satisfaction ?? ' ') !!}
                                    </h5>

                                    <p style="text-align: justify">

                                        {!! \App\Helpers\TranslationHelper::TranslateText($config->des_satisfaction ?? '') !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="about-info-box">
                                <div class="thumb image-center">
                                    <img src="{{ Storage::url($config->icone_annee ?? ' ') }}" height="100"
                                        width="100" alt="Shape">
                                </div>
                                <div class="content">
                                    <h5 class="title" style="text-align: justify">
                                        {{-- {{ $config->annee ?? ' ' }} --}}{!! \App\Helpers\TranslationHelper::TranslateText($config->titre_annee ?? '') !!}.</h5>
                                    <p style="text-align: justify">
                                        {!! \App\Helpers\TranslationHelper::TranslateText($config->des_annee ?? ' ') !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="about-info-box">
                                <div class="thumb image-center">
                                    <img src="{{ Storage::url($config->icone_prix ?? ' ') }}" height="100"
                                        width="100" alt="Shape">
                                </div>
                                <div class="content">
                                    <h5 class="title" style="text-align: justify"> {!! \App\Helpers\TranslationHelper::TranslateText($config->titre_prix ?? ' ') !!}.</h5>
                                    <p style="text-align: justify">
                                        {!! \App\Helpers\TranslationHelper::TranslateText($config->des_prix ?? '') !!}.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End About Area  -->

            <br><br>


            <!-- Start Expolre Product Area  -->
            <div class="axil-product-area bg-color-white axil-section-gapcommon">
                <div class="container">
                    <div class="section-title-border slider-section-title">
                        <h2 class="title"> {{ \App\Helpers\TranslationHelper::TranslateText('Produits en promotion') }}💥
                        </h2>
                    </div>
                    <div
                        class="popular-product-activation slick-layout-wrapper slick-layout-wrapper--15 axil-slick-angle angle-top-slide">
                        <div class="slick-single-layout">
                            <div class="row">

                                @foreach ($produits as $key => $produit)
                                    @if ($produit->inPromotion() && $produit->sur_devis == false)
                                        <div class="col-md-6 col-12">
                                            <div class="axil-product product-style-eight product-list-style-3">
                                                <div class="thumbnail">
                                                    <a
                                                        href="{{ route('details-produits', ['id' => $produit->id, 'slug' => Str::slug(Str::limit($produit->nom, 10))]) }}">
                                                        <img class="main-img" width="300" height="300"
                                                            src="{{ Storage::url($produit->photo) }}"
                                                            alt="Product Images">

                                                        <div class="top-left"
                                                            style="background-color:#0162b1;color: white;">
                                                            <span>

                                                                @if ($produit->inPromotion())
                                                                    <span>
                                                                        -{{ $produit->inPromotion()->pourcentage }}%</span>
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </a>


                                                </div>
                                                <div class="product-content">
                                                    <div class=" col-sm-12 inner">


                                                        <div class="product-cate"
                                                            style="font-size: 20px; font-weight: bold;"><a
                                                                href="{{ route('details-produits', ['id' => $produit->id, 'slug' => Str::slug(Str::limit($produit->nom, 10))]) }}">
                                                                {{ \App\Helpers\TranslationHelper::TranslateText($produit->nom) }}</a>
                                                        </div>
                                                        <div class="color-variant-wrapper">

                                                        </div>
                                                        <h3 class="title"><a
                                                                href="{{ route('details-produits', ['id' => $produit->id, 'slug' => Str::slug(Str::limit($produit->nom, 10))]) }}">
                                                                {{ \App\Helpers\TranslationHelper::TranslateText(Str::limit($produit->description, 20)) }}

                                                            </a></h3>
                                                        <div class="product-rating">

                                                        </div>
                                                        <div class="product-price-variant">
                                                             <span class="price current-price"> <b class="text-success"
                                                                    style="color: #4169E1">
                                                                    {{ $produit->getPrice() }} DT
                                                                </b></span>
                                                        </div>
                                                        <br>

                                                        <div class="top">
                                                            @if ($produit->statut == 'disponible')
                                                                <label class="badge btn-bg-primary2">
                                                                    {{ \App\Helpers\TranslationHelper::TranslateText('Produit en stock') }}</label>
                                                            @else
                                                                <label class="badge bg-danger">
                                                                    {{ \App\Helpers\TranslationHelper::TranslateText('Stock en cours d\'approvisionnement') }}</label>
                                                                </label>
                                                            @endif


                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="axil-testimoial-area axil-section-gap bg-vista-white">
                <div class="container">
                    <div class="section-title-wrapper">
                        <h4> <span class="axil-breadcrumb-item1 active" aria-current="page"> <i
                                    class="fal fa-quote-left"></i>
                                {{ \App\Helpers\TranslationHelper::TranslateText('Témoignages') }}</span> </h4>


                        <h2 class="title">
                            {{ \App\Helpers\TranslationHelper::TranslateText('Les retours de nos clients') }}</h2>
                    </div>

                    <!-- End .section-title -->
                    <div
                        class="testimonial-slick-activation testimonial-style-one-wrapper slick-layout-wrapper--20 axil-slick-arrow arrow-top-slide">

                        @if ($testimonials->isEmpty())
                            <p> {{ \App\Helpers\TranslationHelper::TranslateText('Aucun témoignage disponible') }}.</p>
                        @else
                            @foreach ($testimonials as $testimonial)
                                <div class="slick-single-layout testimonial-style-one">
                                    <div class="review-speech">
                                        <p>“
                                            {!! \App\Helpers\TranslationHelper::TranslateText($testimonial->message) !!}
                                            “</p>
                                    </div>
                                    <div class="media">
                                        <div class="thumbnail">
                                            @if ($testimonial->photo)
                                                <img src="{{ asset('uploads/testimonials/' . $testimonial->photo) }}"
                                                    alt="Photo Témoignage" width="100" height="100">
                                            @else
                                                <img src="./assets/images/testimonial/image-1.png"
                                                    alt="testimonial image">
                                            @endif

                                        </div>
                                        <div class="media-body">
                                            <span class="designation">{{ $testimonial->name }}</span>

                                        </div>
                                    </div>
                                    <!-- End .thumbnail -->
                                </div>
                            @endforeach
                        @endif


                    </div>

                </div>
                <br><br>
                <br>
                <div class="col-12 d-flex justify-content-center">
                    <div class="form-group mb--0">
                        <button class="axil-btn btn-bg-primary2" data-bs-toggle="modal" data-bs-target="#exampleModal"
                            type="submit">
                            <span> {{ \App\Helpers\TranslationHelper::TranslateText('Laisser un témoignage') }}</span>
                        </button>
                    </div>

                </div>


                <div id="successMessage" class="alert alert-success" style="display:none;"></div>
                <div id="errorMessage" class="alert alert-danger" style="display:none;"></div>



            </div>


            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                {{ \App\Helpers\TranslationHelper::TranslateText('Témoignage') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>



                        <div class="modal-body">
                            <form id="testimonialForm" action="{{ route('testimonial.store') }}" method="POST"
                                class="testimonial-form p-4 rounded shadow-sm bg-light">
                                @csrf
                                <div class="form-group mb-4">
                                    <label for="name" class="form-label text-muted">
                                        {{ \App\Helpers\TranslationHelper::TranslateText('Nom') }}</label>
                                    <input type="text" class="form-control border-0 rounded-pill shadow-sm"
                                        id="name" name="name" required>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="testimonial" class="form-label text-muted">
                                        {{ \App\Helpers\TranslationHelper::TranslateText('Message') }}</label>
                                    <textarea class="form-control border-0 rounded-3 shadow-sm" id="testimonial" name="message" rows="8" required></textarea>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-bg-primary2 rounded-pill shadow">
                                        {{ \App\Helpers\TranslationHelper::TranslateText('Envoyer') }}</button>
                                </div>
                            </form>

                            @if ($errors->any())
                                <div class="alert alert-danger mt-4">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success mt-4">
                                    {{ session('success') }}
                                </div>
                            @endif

                        </div>



                    </div>
                </div>
            </div>
        <!-- Start Contact Area  -->
        <div class="axil-contact-page-area axil-section-gap">
            <div class="container">
                <div class="axil-contact-page">
                    <div class="row row--30">
                        <div class="col-lg-8">
                            <div class="contact-form">
                                <h3 class="title mb--10">
                                    {{ \App\Helpers\TranslationHelper::TranslateText('Nous aimerions avoir de nos nouvelles') }}.</h3>
                                <p>

                                    {{ \App\Helpers\TranslationHelper::TranslateText('Si vous des excellents produits que vous fabriquez ou vous souhaitez travaillez avec nous, envoyez-nous un message') }}
                                </p>
                                @livewire('Front.ContactForm')


                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="contact-location mb--40">
                                <h4 class="title mb--20">
                                    {{ \App\Helpers\TranslationHelper::TranslateText('Notre magasin') }}
                                </h4>
                                <span class="address mb--20"> {{ $configs->addresse ?? ' ' }}</span>
                                <span class="phone">Télphone: {{ $configs->telephone ?? ' ' }}</span>
                                <span class="email">Email: {{ $configs->email ?? ' ' }}</span>
                            </div>

                            <div class="opening-hour">
                                <h4 class="title mb--20">
                                    {{ \App\Helpers\TranslationHelper::TranslateText('Horaires ouverture') }}:</h4>
                                <p>
                                    {{ \App\Helpers\TranslationHelper::TranslateText('Du lundi  au samedi: 9h00-22h') }}

                                    <br>
                                    {{ \App\Helpers\TranslationHelper::TranslateText('Dimanche : 10h00 - 18h00') }}

                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Start Google Map Area  -->
                <div class="axil-google-map-wrap axil-section-gap pb--0">
                    <div class="mapouter">
                        <div class="gmap_canvas">
                            <iframe width="1080" height="500" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12789.203038416284!2d10.304916246891421!3d36.73935130622774!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12fd499cebe99f5f%3A0x3cf086804d4b8482!2sKonica%20Tunisie!5e0!3m2!1sen!2stn!4v1735553747367!5m2!1sen!2stn" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
                <!-- End Google Map Area  -->
            </div>
        </div>

            <!-- Start Categorie Area  -->
            <div class="axil-categorie-area bg-color-white axil-section-gapcommon">
                <div class="container">
                    <div class="section-title-wrapper">
                        <span class="title-highlighter highlighter-primary"> <i class="far fa-shopping-basket"></i>
                            {{ \App\Helpers\TranslationHelper::TranslateText('Marques') }}</span>
                        <h2 class="title">{{ \App\Helpers\TranslationHelper::TranslateText('Nos marques') }}</h2>
                    </div>
                    <div class="categrie-product-activation slick-layout-wrapper--15 axil-slick-arrow  arrow-top-slide">
                        @foreach ($marques as $marque)
                        <div class="slick-single-layout">
                            <div class="categrie-products" data-sal="zoom-out" data-sal-delay="200"
                                data-sal-duration="500">
                                <a  href="/marque/{{ $marque->id }}"
                                    class="{{ isset($current_marque) && $current_marque->id === $marque->id ? 'selected' : '' }}">
                                    <img  class="fixed-dimension"  src="{{ Storage::url($marque->image) }}"
                                        alt="product categorie">
                                    <h6 class="cat-title">{{ $marque->nom }}</h6>
                                </a>

                                <style>
                                    .fixed-dimension {
                                        width: 133px; /* Largeur fixe */
                                        height: 87px; /* Hauteur fixe */
                                        object-fit: cover; /* Remplit le conteneur sans déformer l'image */
                                        display: block; /* Supprime les espaces blancs indésirables */
                                        border-radius: 5px; /* Optionnel : coins arrondis pour l'image */
                                        overflow: hidden; /* Cache les débordements éventuels */
                                    }

                                </style>
                            </div>
                            <!-- End .categrie-product -->
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>








        </main>



    </main>


@endsection
