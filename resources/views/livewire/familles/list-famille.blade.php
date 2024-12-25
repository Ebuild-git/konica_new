<div class="row">
    <div class="col-sm-8">
        <div class="card radius-15">
            <div class="card-body">
                <div class="card-title">
                    <h5 class="mb-0 my-auto">
                        Liste des Familles
                    </h5>
                </div>
                <div class="table-responsive-sm">
                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead class="table-dark cusor">
                            <tr>
                                
                                <th>Libellé</th>

                                <th>Nombre de produits</th>
                              
                                <th>création</th>
                                <th style="text-align: right;">
                                    <span wire:loading>
                                        <img src="https://i.gifer.com/ZKZg.gif" width="20" height="20"
                                            class="rounded shadow" alt="">
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($familles as $famile)
                                <tr data-id="{{ $famile->id }}" class="cusor">
                                 
                                    <td> {{ $famile->nom }} </td>
                                    <td> {{ $famile->produits->count() }} </td>
                                   
                                   
                                    <td> {{ $famile->created_at->format('d/m/Y') }} </td>
                                    <td class="text-end">
                                       
                                        <button class="btn btn-sm btn-danger"
                                            onclick="toggle_confirmation({{ $famile->id }})">
                                            <i class="ri-delete-bin-6-line"></i>
                                        </button>
                                        <button class="btn btn-sm btn-success d-none" type="button"
                                            id="confirmBtn{{ $famile->id }}"
                                            wire:click="delete({{ $famile->id }})">
                                            <i class="bi bi-check-circle"></i>
                                            <span class="hide-tablete">
                                                Confirmer
                                            </span>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="text-center p-3">
                                            <p>Aucune faille</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card radius-15">
            <div class="card-body">
                <div class="card-title">
                    <h5 class="mb-0 my-auto">
                        Enregistrement
                    </h5>
                </div>
                <form wire:submit="save">
                    <div class="mb-2">
                        <label for="">Libellé</label>
                        <input type="text" name="ville" wire:model="nom" class="form-control" id="">
                        @error('nom')
                            <span class="small text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    
                    <div class="mb-2">
                        <label for="">Rayon </label>
                        <select wire:model='sous_category_id' class="form-control @error('marque_id') is-invalid @enderror">
                            <option value=""></option>
                            @foreach ($sous_categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-danger small"> {{ $message }} </span>
                        @enderror
                    </div> 
             
                 
             
                
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading>
                                <img src="https://i.gifer.com/ZKZg.gif" height="15" alt="" srcset="">
                            </span>
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
