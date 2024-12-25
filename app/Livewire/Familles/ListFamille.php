<?php

namespace App\Livewire\Familles;

use Livewire\Component;
use App\Models\Famille;
use App\Models\Sous_category;
class ListFamille extends Component
{


    public $nom,  $sous_category_id;

    public function  save(){
   $data=    $this->validate([
            'nom' => ['required', 'string','max:255'],
            'sous_category_id' => 'required|integer|exists:sous_categories,id',
          
        ]);

        $categories = Sous_category::findOrFail($data[('sous_category_id')]);

         $famille = new Famille();
         $famille->nom = $this->nom;
         $famille->sous_category_id = $this->sous_category_id;


           
         $famille->save();
         $categories->familles()->save($famille);
         $this->nom = '';
       
         return redirect()->route('familles');
    }


public function delete($id){
 $famille=   Famille::find($id)->delete();
   if($famille){
  //  $this->emit('villeDeleted');
    session()->flash('success', 'Famille deleted successfully');
    return redirect()->route('familles');
   }
    return redirect()->route('familles');
}

    public function render()
    {
        $familles = Famille::orderby('id','desc')->get();
        $sous_categories = Sous_category::all();
        return view('livewire.familles.list-famille', compact('familles','sous_categories'));
    }
}
