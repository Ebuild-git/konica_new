<div class="axil-dashboard-account">
    @include('components.alert')

    <form wire:submit="update_user" class="account-details-form">


        <div class="row">

            <div class="col-lg-6">
                <div class="form-group">
                    <label class="small mb-1" for="nom"> {{ \App\Helpers\TranslationHelper::TranslateText('Nom') }}</label>
                    <input wire:model="nom" type="text" {{ Auth::user()->nom }} class= "form-control"
                        style="font-size: 18px; color:black">
                    @error('nom')
                        <span class="small text-danger">
                            {{ $message }}
                        </span>
                    @enderror

                </div>
            </div>


            <div class="col-lg-6">
                <div class="form-group">
                    <label class="small mb-1" for="nom"> {{ \App\Helpers\TranslationHelper::TranslateText('Prénom') }}</label>
                    <input wire:model="prenom" type="text" {{ Auth::user()->prenom }} class= "form-control"
                        style="font-size: 18px; color:black">
                    @error('prenom')
                        <span class="small text-danger">
                            {{ $message }}
                        </span>
                    @enderror

                </div>
            </div>

        </div>
        

        <div class="row ">

            <div class="col-lg-6">
                <div class="form-group">
                    <label class="small mb-1" for="inputOrgName">Email</label>

                    <input type="text" value=" {{ Auth::user()->email }}" wire:model="email" class= "form-control"
                        style="font-size: 18px; color:black">
                    @error('email')
                        <span class="text-danger small"> {{ $message }} </span>
                    @enderror
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label class="small mb-1" for="inputLocation"> {{ \App\Helpers\TranslationHelper::TranslateText('Téléphone') }}</label>

                    <input value=" {{ Auth::user()->phone }}" wire:model="phone" id="inputLocation" type="text"
                        class= "form-control" style="font-size: 18px; color:black">
                    @error('phone')
                        <span class="text-danger small"> {{ $message }} </span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">

            <label class="small mb-1" for="adresse"> {{ \App\Helpers\TranslationHelper::TranslateText('Adresse') }}</label>
            <input type="text" value=" {{ Auth::user()->adresse }}" wire:model="adresse"
                style="font-size: 18px; color:black" class= "form-control">
            @error('adresse')
                <span class="text-danger small"> {{ $message }} </span>
            @enderror
        </div>
        </div>
   
        <div class="form-group mb--0">
          {{--   <input type="submit" class="axil-btn2 " value="Confirmer les changements"> --}}
            <button type="submit" class="axil-btn btn-bg-primary2 submit-btn">

                <span wire:loading>
                    <img src="/icons/kOnzy.gif" height="20" width="20" alt="" srcset="">
                </span>
                <span>
                    {{ \App\Helpers\TranslationHelper::TranslateText('Confirmer les changements') }}
                </span>
            </button>
        </div>
    </form>

   
</div>

