
@extends('front.fixe')
@section('titre', 'Paiement')
@section('body')
<main>

<body class="sticky-header">
 
    <a href="#top" class="back-to-top" id="backto-top"><i class="fal fa-arrow-up"></i></a>
 
    <main class="main-wrapper">

        <!-- Start Checkout Area  -->
        <div class="axil-checkout-area axil-section-gap">
            <div class="container">
                <form action="{{ route('devis.cofirm') }}" method="post" enctype="multipart/form-data">
                    @if ($errors->any())
                        {!! implode('', $errors->all('<div>:message</div>')) !!}
                    @endif
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                         
                            <div class="axil-checkout-billing">
                                <h4 class="title mb--40"> {{ \App\Helpers\TranslationHelper::TranslateText(' Confirmation commande') }}</h4>
                               
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label> {{ \App\Helpers\TranslationHelper::TranslateText('Nom') }} <span>*</span></label>
                                            <input type="text" name="nom"    @if (Auth::user()) value="{{ Auth::user()->nom }}" @endif required/>
                                      </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label> {{ \App\Helpers\TranslationHelper::TranslateText('Prénom') }}<span>*</span></label>
                                            <input type="text" name="prenom"    @if (Auth::user()) value="{{ Auth::user()->prenom }}" @endif required/>
                                    
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Email <span>*</span></label>
                                            <input type="mail" name="email"    @if (Auth::user()) value="{{ Auth::user()->email }}" @endif required/>
                                      </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label> {{ \App\Helpers\TranslationHelper::TranslateText('Téléphone') }}<span>*</span></label>
                                            <input type="number" name="phone"   required/>
                                    
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label> {{ \App\Helpers\TranslationHelper::TranslateText('Adresse') }} <span>*</span></label>
                                   
                                    <input type="text" name="adresse"  class="mb--15" placeholder=" {{ \App\Helpers\TranslationHelper::TranslateText('Votre adresse') }}" required />  
                                </div>
                               
                                <div class="form-group">
                                    <label> {{ \App\Helpers\TranslationHelper::TranslateText('Gouvernorat') }} <span>*</span></label>
                                    <select   name="gouvernorat" id="Region">
                                        <option value=""> {{ \App\Helpers\TranslationHelper::TranslateText('Gouvernorat') }}</option>
                                        @foreach ($gouvernorats as $gouvernorat)
                                        <option value="{{ $gouvernorat }}">
                                            {{ $gouvernorat }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                          
                               

                                <div class="form-group">
                                  
                                        <label>Quantité </label>
                                        <input  type="number" name="quantite"
                                            placeholder=" La quantité" required />
                                    
                                </div>
                              
                               
                                <div class="form-group">
                                    <label>
                                        {{ \App\Helpers\TranslationHelper::TranslateText('Note(optionnel)') }}
                                    </label>
                                    <textarea id="note" name="note" rows="2" placeholder=" {{ \App\Helpers\TranslationHelper::TranslateText('Note sur votre commande(Optionnel)') }}"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="axil-order-summery order-checkout-summery">
                                <h5 class="title mb--20"> {{ \App\Helpers\TranslationHelper::TranslateText('Votre commande') }}</h5>
                                <div class="summery-table-wrap">
                                    <table class="table summery-table">
                                        <thead>
                                            <tr>
                                                <th> {{ \App\Helpers\TranslationHelper::TranslateText('Produit') }}</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                            <tr class="order-product">
                                                <td>  {{ $produit->nom }}</td>
                                                <td class="product-total">
                                                    <span class="amount"><img src="{{ Storage::url($produit->photo) }}"
                                                            width="50 " height="50 " border-radius="8px"
                                                            alt="Product image" /></span>
                                                </td>

                                            </tr>
                                       
                                           
                                           

                                            <tr class="order-shipping">

                                            
                                            </tr>
                                           
                                        </tbody>
                                    </table>
                                </div>
                                
                                <button type="submit" class="axil-btn btn-bg-primary2 checkout-btn"> {{ \App\Helpers\TranslationHelper::TranslateText('Confirmation') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Checkout Area  -->
       
    </main>

</main>

@endsection