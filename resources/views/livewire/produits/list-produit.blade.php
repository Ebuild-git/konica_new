<div>

    <form wire:submit="filtrer">
        <div class="row">
            <div class="col-sm-6">
                <span>
                    <b>{{ $produits->count() }}</b> Résultats sur {{ $total }}.
                </span>
            </div>
            <div class="col-sm-6">
                <div class="input-group mb-3">
                    <input type="text" class="form-control btn-sm" wire:model="key"
                        placeholder="Titre,Description des articles">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            Filtrer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>


    @include('components.alert')

    <div class="table-responsive-sm">
        <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
            <thead class="table-dark cusor">
                <tr>
                    <th title="Ajouter un produit dans la bannier de l'accueil">
                        Top
                    </th>
                    <th>Photo</th>
                    <th>Nom</th>
                    <th>Stock</th>
                    <th>Prix vente</th>
                    <th>Prix achat</th>
                    <th>Sell</th>
                   {{--  <th>Vues</th> --}}
                    <th>Type Produit</th>
                    <th>création</th>
                    <th style="text-align: right;">
                        <span wire:loading>
                            <img src="https://i.gifer.com/ZKZg.gif" width="20" height="20" class="rounded shadow"
                                alt="">
                        </span>
                    </th>
                </tr>
            </thead>


            <tbody>
                @forelse ($produits as $produit)
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input" @checked($produit->top == 1)
                                wire:click="add_top({{ $produit->id }})">
                        </td>
                        <td>
                            <img src="{{ Storage::url($produit->photo) }}" width="40 " height="40 "
                                class="rounded shadow" alt="">
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline" data-bs-toggle="modal"
                                data-bs-target="#qr-code-{{ $produit->id }}">
                                <i class="ri-qr-code-line"></i>
                            </button>

                            {{ $produit->nom }}
                        </td>

                        <td class="cusor">
                            <select 
                            class="form-select form-select-sm {{ $produit->statut === 'disponible' ? 'text-success' : 'text-danger' }}" 
                            wire:change="updateStatus({{ $produit->id }}, $event.target.value)">
                            <option value="disponible" @if($produit->statut === 'disponible') selected @endif>En stock</option>
                            <option value="indisponible" @if($produit->statut === 'indisponible') selected @endif>En rupture</option>
                        </select>
                        </td>
                        
                         
                        {{-- <td class="cusor">
                            {{ $produit->statut }}
                        </td>
                     --}}
                        <td>
                            @if ($produit->inPromotion()   && $produit->sur_devis == false)
                            <span class=" small">
                                - {{ $produit->inPromotion()->pourcentage }} %
                            </span>
                            <b class="text-success">
                                {{ $produit->getPrice() }} DT
                            </b>
                            <br>
                            <strike>
                                <span class="text-danger small">
                                    {{ $produit->prix }} DT
                                </span>
                            </strike>
                            @elseif ($produit->sur_devis==false)
                            {{ $produit->getPrice() }}DT
                            @else
                            <b>------</b>
                        
                        @endif

                        </td>
                        <td>
                            @if($produit->sur_devis==false)
                            {{ $produit->prix_achat }} DT
                            @else
                            <b>------</b>
                            @endif
                            </td>
                        <td>
                            <i class="ri-wallet-2-line vert"></i>
                            {{ $produit->vendus->count() }}
                        </td>
                    
                        <td>
                            @if ($produit->sur_devis == false)
                                <div class="progress-bar bg-primary progress" style="width: 80%" aria-valuenow="10"
                                    aria-valuemin="0" aria-valuemax="100">
                                    <b>Produit simple</b>
                                    
                                </div>
                            @else
                                <div class="progress-bar bg-info" style="width: 80%" aria-valuenow="30"
                                    aria-valuemin="0" aria-valuemax="100">
                                    <b>Sur devis</b>
                                   
                                </div>
                            @endif
                         
                        </td>
                        <td>{{ $produit->created_at->format('d/m/Y') }} </td>
                        <td style="text-align: right;">
                            <div class="btn-group">

                               

                                <button class="btn btn-sm btn-dark"
                                    onclick="url(' {{ route('produits.update', ['id' => $produit->id]) }} ')">
                                    <i class="ri-edit-box-line"></i>
                                </button>
                                @can('product_edit')
                                    <button class="btn btn-sm btn-warning" title="Promotion"
                                        onclick="url('{{ route('promotions_produit', ['id' => $produit->id]) }}')">
                                        <i class="ri-discount-percent-fill"></i>
                                    </button>
                                @endcan
                           
                                @can('product_delete')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="toggle_confirmation({{ $produit->id }})">
                                        <i class="ri-delete-bin-6-line"></i>
                                    </button>
                                @endcan
                            </div>

                            <!-- Center modal content -->
                            <div class="modal fade" id="qr-code-{{ $produit->id }}" tabindex="-1" role="dialog"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title" id="myCenterModalLabel">
                                                Accès rapide au produit
                                            </h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table" style="text-align: left;">
                                                <tr>
                                                    <td>Prix d'acaht :</td>
                                                    <td>{{ $produit->prix_achat }} <x-devise></x-devise></td>
                                                </tr>
                                                <tr>
                                                    <td>Bénéfce / produit :</td>
                                                    <td> {{ $produit->prix - $produit->prix_achat }}
                                                        <x-devise></x-devise>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Réference :</td>
                                                    <td>
                                                        {{ $produit->reference }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Stock : </td>
                                                    <td class="d-flex justify-content-between">
                                                        <span>
                                                            {{ $produit->stock }} U.
                                                        </span>
                                                        <b class="cusor"
                                                            onclick="url('{{ route('produits.historique', ['id' => $produit->id]) }}')">
                                                            <i class="ri-history-fill"></i>
                                                            Historique
                                                        </b>
                                                    </td>
                                                </tr>
                                            </table>
                                            <br>
                                            <div class="text-center p-2">
                                                       </div>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                            <button class="btn btn-sm btn-success d-none" type="button"
                                id="confirmBtn{{ $produit->id }}" wire:click="delete({{ $produit->id }})">
                                <i class="bi bi-check-circle"></i>
                                <span class="hide-tablete">
                                    Confirmer
                                </span>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">
                            <div>
                                <img src="/icons/icons8-ticket-100.png" height="100" width="100" alt=""
                                    srcset="">
                            </div>
                            Aucun produit trouvé
                        </td>
                    </tr>
                @endforelse

            </tbody>


        </table>
    </div>
    {{ $produits->links('pagination::bootstrap-4') }}

    @role('admin')
        <div class="text-end p-2">
            <a href="{{ route('corbeille') }}" class="text-danger">
                <i class="ri-delete-bin-line"></i>
                Corbeile ( {{ $total_supprimers }} )
            </a>
        </div>
    @endrole
  {{--   <script>
        function handleSelectChange(productId, value) {
            if (value === 'historique') {
               
               

                window.location.href = `{{ route('produits.historique', ['id' => $produit->id]) }}${productId}`;   
              
              
            } else {
                updateStockStatus(productId, value);
            }
        }
    </script> --}}


    <style>
        .badge {
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
        }

        .badge-success {
            background-color: green;
        }

        .badge-danger {
            background-color: red;
        }
    </style>




    @if ($showModal)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter Stock pour {{ $selectedProduit }}</h5>
                        <button type="button" class="btn-close" wire:click="$set('showModal', false)"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="addStock">
                            <div class="mb-3">
                                <label for="stock" class="form-label">Quantité à ajouter</label>
                                <input type="number" id="stock" wire:model="stock" class="form-control"
                                    min="1">
                                @error('stock')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('openModal', () => {
                var modal = new bootstrap.Modal(document.getElementById('add-stock-modal'));
                modal.show();
            });
        });
    </script>


</div>
