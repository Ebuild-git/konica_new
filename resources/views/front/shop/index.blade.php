@extends('front.fixe')
@section('titre', 'Shop')
@section('body')


<main>
    <body class="sticky-header">

        <a href="#top" class="back-to-top" id="backto-top"><i class="fal fa-arrow-up"></i></a>

        <main class="main-wrapper">
            <!-- Start Breadcrumb Area  -->
            <div class="axil-breadcrumb-area">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-8">
                            <div class="inner">
                                <h1 class="title">
                                    {{ \App\Helpers\TranslationHelper::TranslateText('Explorez tous les produits') }}
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Breadcrumb Area  -->

            <!-- Start Shop Area  -->
            <div class="axil-shop-area axil-section-gap bg-color-white">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="axil-shop-sidebar">
                                <div class="d-lg-none">
                                    <button class="sidebar-close filter-close-btn"><i class="fas fa-times"></i></button>
                                </div>
                                <div class="toggle-list product-categories active">
                                    <h6 class="title">
                                        {{ \App\Helpers\TranslationHelper::TranslateText('CATEGORIES') }}</h6>
                                    <div class="shop-submenu">
                                        <ul>
                                            <li class="current-cat"><a href="/shop">
                                                    {{ \App\Helpers\TranslationHelper::TranslateText('Tous les produits') }}</a>
                                            </li>

                                            @foreach ($categories as $category)
                                            <li><a href="/category/{{ $category->id }}" class="{{ isset($current_category) && $current_category->id === $category->id ? 'selected' : '' }}">

                                                    {{ \App\Helpers\TranslationHelper::TranslateText(Str::limit($category->nom, 25)) }}

                                                    <span>({{ $category->produits->count() }})</span></a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                     <div class="toggle-list product-categories product-gender active">
                                        <h6 class="title">  {{ \App\Helpers\TranslationHelper::TranslateText('LES MARQUES') }}</h6>
                                        <div class="shop-submenu">
                                            <ul>
                                                @foreach ($marques as $marque)
                                                    <li><a href="/marque/{{ $marque->id }}"
                                                            class="{{ isset($current_marque) && $current_marque->id === $marque->id ? 'selected' : '' }}">{{ $marque->nom }}
                                                            ({{ $marque->produits->count() }})</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>


                                    <div class="toggle-list product-price-range active">
                                        <h6 class="title">  {{ \App\Helpers\TranslationHelper::TranslateText('FILTRES') }}</h6>
                                        <div class="shop-submenu">
                                            @php
                                            $max = DB::table('produits')->max('prix');
                                            $min = DB::table('produits')->min('prix');
                                            //dd($max);
                                        @endphp

                                            <form action="/shop" method="post" class="mt--25">
                                                @csrf
                                                <div id="slider-range"  data-min="{{ $min }}" data-max="{{ $max }}"></div>
                                                <div class="flex-center mt--20">
                                                    <span class="input-range">  {{ \App\Helpers\TranslationHelper::TranslateText('Prix') }}: </span>
                                                    <input style="" type="text" id="amount" readonly>
                                                    <input type="hidden" name="price_range" id="price_range" />                                                </div>
                                                <button class="tp-product-widget-filter-btn filter_button  axil-btn btn-bg-primary2"
                                                type="submit">  {{ \App\Helpers\TranslationHelper::TranslateText('Filtrer') }}</button>
                                            </form>
                                        </div>

                                    </div>


                            </div>
                            <!-- End .axil-shop-sidebar -->
                        </div>
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="axil-shop-top mb--40">
                                        <div class="category-select align-items-center justify-content-lg-end justify-content-between">
                                            <!-- Start Single Select  -->
                                            <span class="filter-results">
                                                {{ \App\Helpers\TranslationHelper::TranslateText('Filtrer') }}</span>
                                            <select class="single-select" name="sort_by" id="sort_by" onchange="window.location.href=this.value;">

                                                <option value="{{ url('shop') }}">
                                                    {{ \App\Helpers\TranslationHelper::TranslateText('Défaut') }}
                                                </option>
                                                <option value="{{ url('croissant') }}">
                                                    {{ \App\Helpers\TranslationHelper::TranslateText('Croissant') }}
                                                </option>

                                                <option value="{{ url('decroissant') }}">
                                                    {{ \App\Helpers\TranslationHelper::TranslateText('Décroissant') }}
                                                </option>
                                            </select>
                                            <!-- End Single Select  -->
                                        </div>
                                        <div class="d-lg-none">
                                            <button class="product-filter-mobile filter-toggle"><i class="fas fa-filter"></i>
                                                {{ \App\Helpers\TranslationHelper::TranslateText('Filtrer') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End .row -->
                            <div class="row row--15">


                                @foreach ($produits as $key => $produit)
                                <div class="col-xl-4 col-sm-6">
                                    <div class="axil-product product-style-one mb--30" style="border: 1px solid #0162b1; border-radius: 8px; overflow: hidden;">
                                        <div class="thumbnail ">
                                            <a href="{{ route('details-produits', ['id' => $produit->id, 'slug' => Str::slug(Str::limit($produit->nom, 10))]) }}">
                                                <img class="product-image"   src="{{ Storage::url($produit->photo) }}" alt="{{ $produit->nom }}" style="max-width: 300px; max-height: 300px;">

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
                                            @if (Auth()->user())
                                            @php

                                            $count = DB::table('favoris')
                                            ->where('id_user', Auth()->user()->id)
                                            ->where('id_produit', $produit->id)
                                            ->count();
                                            @endphp


                                            <li class="wishlist"><a onclick="AddFavoris({{ $produit->id }})" @if ($count==0) class="" style="color:#000000" @else class="" style="color: #dc3545; background-color:#dc3545" @endif>

                                                    <i class="far fa-heart"></i></a></li>
                                            @endif


                                            <li class="select-option2">
                                                @if ($produit->sur_devis == false)
                                                <a onclick="AddToCart( {{ $produit->id }} )">
                                                    {{ \App\Helpers\TranslationHelper::TranslateText('Ajouter au panier') }}</a>
                                                @else
                                                <a href="{{ url('devis', $produit->id) }}" style="font-size: 1.7rem; color: white;">
                                                    {{ \App\Helpers\TranslationHelper::TranslateText('Demander devis') }}
                                                </a>
                                                @endif

                                            </li>


                                        </ul>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <div class="inner">
                                        <h5 class="title text-center"><a href="{{ route('details-produits', ['id' => $produit->id, 'slug' => Str::slug(Str::limit($produit->nom, 10))]) }}">
                                                {{ \App\Helpers\TranslationHelper::TranslateText(Str::limit($produit->nom, 15)) }}
                                            </a>
                                        </h5>

                                        <div class="product-price-variant">
                                            <h6 class="product-price--main">

                                                @if ($produit->inPromotion() && $produit->sur_devis == false)
                                                <div class="row text-center">
                                                    <div class="col-sm-6 col-6">

                                                        <b class="text-success" style="color: #4169E1">
                                                            {{ $produit->getPrice() }} DT
                                                        </b>
                                                    </div>

                                                    <div class="col-sm-6 col-6 text">
                                                        <strike>


                                                            <span style="font-size: 1.7rem; color: #dc3545; font-weight: bold;">
                                                                {{ $produit->prix }} DT
                                                            </span>


                                                        </strike>
                                                    </div>

                                                    @else



                                                    <div class="text-center">
                                                        <span class="price current-price" style="font-size: 1.7rem;">
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
                    <div class="text-center pt--20">
                        <ul class="pagination-list">
                            {{ $produits->links('pagination::bootstrap-4') }}
                        </ul>
                    </div>
                </div>
            </div>
            </div>

            </div>


            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script src="{{ asset('js/script.js') }}"></script>
            <script>
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            </script>
            <script>
                $(document).ready(function(e) {
                    $('.range_slider').on('change', function() {
                        let left_value = $('#input_left').val();
                        let right_value = $('#input_right').val();
                        // alert(left_value+right_value);
                        $.ajax({
                            url: "{{ route('search.products') }}",
                            method: "GET",
                            data: {
                                left_value: left_value,
                                right_value: right_value
                            },
                            success: function(res) {
                                $('.search-result').html(res);
                            }
                        });
                    });

                    $('#sort_by').on('change', function() {
                        let sort_by = $('#sort_by').val();
                        $.ajax({
                            url: "{{ route('sort.by') }}",
                            method: "GET",
                            data: {
                                sort_by: sort_by
                            },
                            success: function(res) {
                                $('.search-result').html(res);
                            }
                        });
                    });
                })
            </script>

            <script>
                $(document).ready(function() {
                    /*----------------------------------------------------*/
                    /*  Jquery Ui slider js
                    /*----------------------------------------------------*/
                    if ($("#slider-range").length > 0) {
                        const max_value = parseInt($("#slider-range").data('max')) || 500;
                        const min_value = parseInt($("#slider-range").data('min')) || 0;
                        const currency = $("#slider-range").data('currency') || '';
                        let price_range = min_value + '-' + max_value;
                        if ($("#price_range").length > 0 && $("#price_range").val()) {
                            price_range = $("#price_range").val().trim();
                        }

                        let prix = price_range.split('-');
                        $("#slider-range").slider({
                            range: true,
                            min: min_value,
                            max: max_value,
                            values: prix,
                            slide: function(event, ui) {
                                $("#amount").val(currency + ui.values[0] + " -  " + currency + ui.values[1]);
                                $("#price_range").val(ui.values[0] + "-" + ui.values[1]);
                            }
                        });
                    }
                    if ($("#amount").length > 0) {
                        const m_currency = $("#slider-range").data('currency') || '';
                        $("#amount").val(m_currency + $("#slider-range").slider("values", 0) +
                            "  -  " + m_currency + $("#slider-range").slider("values", 1));
                    }
                })
            </script>

        </main>


</main>
@endsection
