<?php

namespace App\Livewire\SousCategories;
use Livewire\Component;
use App\Models\Category;
use App\Models\produits;
use Illuminate\Support\Facades\Storage;
use App\Models\Sous_category;
use Livewire\WithPagination;

class ListSousCategories extends Component
{


    use WithPagination;
    public $key;

     
    public function delete($id)
    {
        $cat = Sous_category::find($id);
        if ($cat) {
            $cat->delete();
            session()->flash('info', 'Sous category supprimée avec succès');
        }
    }

    public function render()
    {
        
        $Query = Sous_category::query();
        if(!is_null($this->key)){
            $Query->where('titre', 'like', '%'.$this->key.'%');
        }
        $categories = $Query->paginate(30);
        $total = Sous_category::count();
        return view('livewire.sous-categories.list-sous-categories', compact('categories','total'));
    }
}
