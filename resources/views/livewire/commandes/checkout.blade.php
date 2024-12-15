<div>
   
    <form class="checkout__form" wire:submit="confirmOrder" >
        @if ($errors->any())
            {!! implode('', $errors->all('<div>:message</div>')) !!}
        @endif
     
        <div class="row justify-content-xl-between">
            <div class="col-12 col-md-5 col-lg-6">
                <div>
                    <h6> {{ \App\Helpers\TranslationHelper::TranslateText('Informations personnelles') }}
                    </h6>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-6 col-md-12 col-lg-6">
                        <div class="input-wrp">
                            <input class="textfield" name="nom" wire:model.lazy="nom" 
                                @if (Auth::user()) value="{{ Auth::user()->nom }}" @endif
                                placeholder=" {{ \App\Helpers\TranslationHelper::TranslateText('Votre nom') }} *"
                                type="text" required />
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-12 col-lg-6">
                        <div class="input-wrp">
                            <input class="textfield" name="prenom"  wire:model.lazy="prenom" 
                                @if (Auth::user()) value="{{ Auth::user()->prenom }}" @endif
                                placeholder=" {{ \App\Helpers\TranslationHelper::TranslateText('Prénom') }} *"
                                type="text" required />
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-12 col-lg-6">
                        <div class="input-wrp">
                            <input type="mail" name="email" class="textfield"  wire:model.lazy="email" wire:click="email"
                                @if (Auth::user()) value="{{ Auth::user()->email }}" @endif
                                placeholder=" {{ \App\Helpers\TranslationHelper::TranslateText('Votre email ') }}"   required />
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-12 col-lg-6">
                        <div class="input-wrp">
                            <input type="number" name="phone"  wire:model.lazy="phone" wire:click="phone"
                              placeholder=" {{ \App\Helpers\TranslationHelper::TranslateText('Votre téléphone') }}"
                            class="textfield" required />
                        </div>
                    </div>



                    <div class="col-12">
                        <div class="input-wrp">
                            <input type="text" name="adresse" class="textfield"  wire:model.lazy="adresse" wire:click="adresse"
                                placeholder=" {{ \App\Helpers\TranslationHelper::TranslateText('Votre adresse') }}"
                                required />
                        </div>
                    </div>
                 
    
                    <div class="col-12">
                        <div class="input-wrp">
                            <input type="text" name="adresse_supp1" class="textfield"  wire:model.lazy="adresse_supp1" wire:click="adresse_supp1"
                                placeholder=" {{ \App\Helpers\TranslationHelper::TranslateText('Adresse 1(Optionnel)') }}"
                                />
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="input-wrp">
                            <input type="text" name="adresse_supp2" class="textfield"  wire:model.lazy="adresse_supp2" wire:click="adresse_supp2"
                                placeholder=" {{ \App\Helpers\TranslationHelper::TranslateText('Adresse 2(Optionnel)') }}"
                                 />
                        </div>
                    </div>
                </div>

                <div class="spacer py-6"></div>



                <div class="row">


                    <div class="col-12">
                        <div class="input-wrp">
                            <select class="textfield" name="gouvernorat" wire:model.lazy="gouvernorat"    {{-- wire:change="updatedGouvernorat"  --}}  id="transport_id">
                                <option value="">
                                    {{ \App\Helpers\TranslationHelper::TranslateText('Gouvernorat') }}
                                </option>
                                @foreach ($transports as $gouvernorat)
                                    <option value="{{ $gouvernorat->ville }}">
                                        {{ $gouvernorat->ville }} - Frais Transport: {{ $gouvernorat->frais }} DT
                                    </option>
                                @endforeach
                            </select>
                            @error('gouvernorat')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    

                    <div class="col-12">
                        <div class="input-wrp">
                            <textarea id="note" name="note"  wire:model.lazy="note" wire:click="note" class="textfield"
                                placeholder="{{ \App\Helpers\TranslationHelper::TranslateText('Note sur votre commande(Optionnel)') }}"></textarea>
                        </div>
                    </div>
                </div>


                <div class="spacer py-6 d-md-none"></div>
            </div>

            <div class="col-12 col-md-7 col-lg-6 col-xl-5">
                <div>
                    <h6>{{ \App\Helpers\TranslationHelper::TranslateText('Votre commande') }}</h6>
                </div>

                <div class="checkout__table">
                    <table>
                        <tbody>
                            @foreach ($paniers as $id => $details)
                                <tr>
                                    <td width="65%">
                                        <div class="d-table">
                                            <div class="d-table-cell align-middle">
                                                <figure class="__image">
                                                    <a href="#">
                                                        <img class="lazy"src="{{ Storage::url($details['photo']) }}"
                                                            data-src="{{ Storage::url($details['photo']) }}"
                                                            alt="demo" />
                                                    </a>
                                                </figure>
                                            </div>

                                            <div class="d-table-cell align-middle">
                                                <a href="#"
                                                    class="__name">{{ $details['nom'] }}</a>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="__amount">x{{ $details['quantite'] }}</span>
                                    </td>

                                    <td width="1%">
                                        <span class="__total">{{ $details['quantite']*$details['prix'] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>



                    </table>
                </div>



                <div class="checkout__total">
                    <table>
                        <thead>
                            <tr>
                                <td colspan="2">
                                    <h3> {{ \App\Helpers\TranslationHelper::TranslateText('Votre') }}
                                        <span>
                                            {{ \App\Helpers\TranslationHelper::TranslateText('commande') }}</span>
                                    </h3>
                                </td>
                            </tr>
                        </thead>

                        <tfoot>
                           {{--  <tr>
                                <td colspan="2" class="__note">
                                
                                    <div class="content">
                                        <div class="checkbox">
                                              <form-group>
                                              

                                            </form-group>

                                        </div>
                                    </div>
                                </td>
                            </tr> --}}

                            <tr>
                                <td colspan="2">
                            
                                    <button
                                        class="custom-btn custom-btn--medium custom-btn--style-1"
                                        type="submit"
                                        role="button">{{ \App\Helpers\TranslationHelper::TranslateText('Confirmation') }}</button>
                                </td>
                            </tr>
                        </tfoot>

                        <tbody>
                            <tr>
                                <td>SubTotal:</td>
                                <td>{{ $total }} DT</td>
                            </tr>

                            <tr>
                               
                                </td>




                          

                                <tr>
                                    <td class="tax"> {{ \App\Helpers\TranslationHelper::TranslateText('Frais de livraison') }}</td>
                                    <td>

                                        @if ($frais)
                                        <p> {{ $frais }} DT</p>
                                    @else
                                        <p>Veuillez sélectionner une ville pour voir les frais de transport.</p>
                                    @endif
                                    </td>
                                </tr>
                            </tr>
                            
                             <tr>
                                        <td>Total</td>
                                        <td>{{ $total + $frais }} DT

                                           

                                        </td>
                                    </tr> 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>
