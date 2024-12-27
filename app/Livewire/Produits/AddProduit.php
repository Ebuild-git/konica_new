<?php

namespace App\Livewire\Produits;
use App\Models\{produits, Category, Marque, Sous_category, Famille};
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\Request;

class AddProduit extends Component
{
    use WithFileUploads;

    public $nom,$tags, $prix, $category_id, $categorie_id,$categori_id,$photo, $photos, $prix_achat, $photo2, $photos2, $produit, $reference, $description,$marque_id, $brochures;

    public $free_shipping, $sur_devis;
    public $meta_description, $sous_category_id,$famille_id;
    public $sous_categories = array();
    public $familles = array();


    public function mount($produit)
    {
        if ($produit) {
            $this->produit = $produit;
            $this->nom = $produit->nom;
            $this->tags = $produit->tags;
            $this->category_id = $produit->category_id;
            $this->categorie_id = $produit->categorie_id;
            $this->sous_category_id = $produit->sous_category_id;
            $this->famille_id = $produit->famille_id;
            $this->marque_id = $produit->marque_id;
            $this->reference = $produit->reference;
            $this->prix = $produit->prix;
            $this->prix_achat = $produit->prix_achat;
            $this->photo2 = $produit->photo;
            $this->photos2 = $produit->photos;
            $this->description = $produit->description;
            $this->free_shipping = $produit->free_shipping;
            $this->sur_devis = $produit->sur_devis ?? 0;
            $this->meta_description = $produit->meta_description;
            $this->sous_categories = Sous_category::where('categorie_id', $this->category_id)->get();
            $this->familles = Famille::where('sous_category_id', $this->sous_category_id)->get();
            $this->brochures = $produit->brochures;
        }
    }


    public function render()
    {
        $categories = Category::all();
        $marques = Marque::all();

        return view('livewire.produits.add-produit', compact('categories','marques'));
    }

    public function loadSubCategories()
    {
        $this->sous_category_id = null;
        $this->sous_categories = Sous_category::where('categorie_id', $this->category_id)->get();
    }


    public function loadFamilles()
    {
        $this->famille_id = null;
        $this->familles = Famille::where('sous_category_id', $this->sous_category_id)->get();
    }


    //validation
    public function create()
    {
        $data =  $this->validate([
            'nom' => 'required|string',
            'description' => 'required|string|max:5000060',

            'reference' => 'required|string|unique:produits,reference',
            'prix' => 'nullable|numeric|gt:prix_achat',
            'prix_achat' => 'nullable|numeric',
            'photo' =>  'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'photos.*' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'category_id' => 'required|integer|exists:categories,id',
            'sous_category_id' => 'nullable|integer|exists:sous_categories,id',
            'famille_id' => 'nullable|integer|exists:familles,id',
            'sur_devis' => 'nullable|boolean',
            'marque_id' => 'nullable|integer|exists:marques,id',
            'brochures' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',

        ]);
        ;[
            'reference.required' => ' La reference',
            'nom.required' => 'Veuillez entrer votre nom',
           'prix.required' => 'Veuillez entrer  le prix',
            //'adresse.required' => 'Veuillez entrer votre addresse',

          ];


        $categories = Category::findOrFail($data[('category_id')]);
        $sous_categories = Sous_category::findOrFail($data[('sous_category_id')]);
        $famille = Famille::findOrFail($data[('famille_id')]);

        $produit = new produits();
        $produit->nom = $this->nom;
        $produit->description = $this->description;
        $produit->reference = $this->reference;
        $produit->free_shipping = $this->free_shipping;
        $produit->sur_devis = $this->sur_devis ?? false;


        $produit->category_id = $this->category_id;
        $produit->marque_id = $this->marque_id;
        $produit->sous_category_id = $this->sous_category_id;
        $produit->sous_category_id = $this->sous_category_id;
        $produit->famille_id = $this->famille_id;




        $produit->prix = $this->prix;
        $produit->prix_achat = $this->prix_achat;
        $produit->photo = $this->photo->store('produits', 'public');
        if ($this->photos) {
            $photosPaths = [];
            foreach ($this->photos as $photo) {
                $photosPaths[] = $photo->store('produits', 'public');
            }
            $produit->photos = json_encode($photosPaths);
        }
        if ($this->brochures) {
            $produit->brochures = $this->brochures->store('brochures', 'public');
        }
        $produit->save();

        $this->reset();


        session()->flash('success', 'Produit ajouté avec succès');
    }


    public function update_produit()
    {
        if ($this->produit) {
            $this->validate([
                'nom' => 'required|string',
                'prix' => 'nullable|numeric|gt:prix_achat',
                'brochures' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'prix_achat' => 'nullable|numeric',
                'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp',
                'photos.*' => 'nullable|image|mimes:jpg,jpeg,png,webp',
                'marque_id' => 'nullable|integer|exists:marques,id',
                'category_id' => 'required|integer|exists:categories,id',
                'free_shipping' => 'nullable|boolean',
                'sur_devis' => 'nullable|boolean',
                'sous_category_id' => 'nullable|integer|exists:sous_categories,id',
                'famille_id' => 'nullable|integer|exists:familles,id',

            ]);



            $this->produit->nom = $this->nom;
            $this->produit->description = $this->description;


            $this->produit->prix = $this->prix;
            $this->produit->prix_achat = $this->prix_achat;
            $this->produit->marque_id = $this->marque_id;
            $this->produit->category_id = $this->category_id;
            $this->produit->sous_category_id = $this->sous_category_id;
            $this->produit->famille_id = $this->famille_id;


            $this->produit->free_shipping = $this->free_shipping;
            $this->produit->sur_devis = $this->sur_devis ?? false;


            if ($this->photo) {
                //delete old photo
                if ($this->produit->photo) {
                    Storage::disk('public')->delete($this->produit->photo);
                }
                $this->produit->photo = $this->photo->store('produits', 'public');
            }

            if ($this->photos) {
                $photosPaths = [];
                foreach ($this->photos as $photo) {
                    $photosPaths[] = $photo->store('produits', 'public');
                }
                $this->produit->photos = json_encode($photosPaths);
            }

            if ($this->brochures) {
                if ($this->produit->brochures) {
                    Storage::disk('public')->delete($this->produit->brochures);
                }
                $this->produit->brochures = $this->brochures->store('brochures', 'public');
            }

            $this->produit->save();


            $this->resetInput();

            return redirect()->route('produits')->with('success', "Produit modifié avec succès");
        }
    }



    public function resetInput()
    {
        $this->nom = '';
        $this->meta_description = '';
        $this->tags = '';
        $this->prix = '';
        $this->photo = '';
        $this->photos = '';
        $this->brochures = '';

    }
}
