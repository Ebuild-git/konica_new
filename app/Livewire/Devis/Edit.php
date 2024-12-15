<?php

namespace App\Livewire\Devis;

use Livewire\Component;
use App\Http\Traits\ListGouvernorats as TraitsListGouvernorats;
use App\Models\config;
use App\Models\contenu_commande;



class Edit extends Component
{


    use TraitsListGouvernorats;

    public $commande, $gouvernoratsTunisie, $nom, $prenom, $adresse, $gouvernorat, $phone,$frais , $tax;
    

    public $contenus = [];

  

    public function mount($commande)
    {
        $this->commande = $commande;

        $this->frais = $commande->frais;
        $this->tax = $commande->tax;
        $this->nom = $commande->nom;
        $this->prenom = $commande->prenom;
        $this->adresse = $commande->adresse;
        $this->gouvernorat = $commande->gouvernorat;
        $this->phone = $commande->phone;

       // $this->commande = $commande;
        $this->contenus = $commande->contenus;
    }




    public function updatePrix($contenuId, $newPrix)
    {
        // Mise à jour du prix dans la collection contenus
        foreach ($this->contenus as $key => $contenu) {
            if ($contenu['id'] == $contenuId) {
                $this->contenus[$key]['prix_unitaire'] = $newPrix;
                break;
            }
        }

        // Mise à jour du prix dans la commande
        $contenu = $this->commande->contenus()->find($contenuId);
        $contenu->prix_unitaire = $newPrix;
        $contenu->save();

        // Mettre à jour le composant Livewire
      //  $this->emit('updated');
    }

    
    public function updateQuantite($contenuId, $newQte)
    {
        // Mise à jour  dans la collection contenus
        foreach ($this->contenus as $key => $contenu) {
            if ($contenu['id'] == $contenuId) {
                $this->contenus[$key]['quantite'] = $newQte;
                break;
            }
        }

        // Mise à jour quantité dans la commande
        $contenu = $this->commande->contenus()->find($contenuId);
        $contenu->quantite = $newQte;
        $contenu->save();

        // Mettre à jour le composant Livewire
      //  $this->emit('updated');
    }



    public function update_user_info()
    {
        $this->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'nullable|string|max:100',
            'adresse' => 'required|string|max:150',
            'phone' => 'required|string|max:100',
            'gouvernorat' => 'required|string|max:12',
            'frais'=> 'nullable',
            'tax'=> 'nullable',
        ]);
        $config = config::first();
        $this->commande->nom = $this->nom;
        $this->commande->prenom = $this->prenom;
        $this->commande->adresse = $this->adresse;
        $this->commande->phone = $this->phone;
        $this->commande->gouvernorat = $this->gouvernorat;
        $this->commande->frais = $this->frais ? $config->frais : null;
        $this->commande->tax = $this->tax ? $config->tax : null;
        $this->commande->save();

        //flash success message en frnancais
        session()->flash('success', __('Les informations de la commandes ont été  modifiés !')); 
    }


    public function change($id_contenu, $quantite, $type)
    {
        $contenu = contenu_commande::find(intval($id_contenu));
        if (!$contenu) {
            //flash error message
            session()->flash('warning', 'Contenu non trouvé');
            return;
        }

        if ($type == "up") {
            
             if ( intval($quantite) <= 0 ) {
            
                session()->flash('error', 'Quantité ne doit pas être négative');
                return;
            } 
            $contenu->quantite =  intval($quantite);
            $contenu->produit->diminuer_stock(intval($quantite));
            $contenu->save();
        } else {
            //ajout d'un contenu à la commande
            $contenu->quantite =  intval($quantite);
            $contenu->produit->retourner_stock(intval($quantite));
            $contenu->save();
        }
    }

    public function delete($id)
    {
        $contenu = contenu_commande::find(intval($id));
        if (!$contenu) {
            //flash error message
            session()->flash('warning', 'Contenu non trouvé');
            return;
        }
        $contenu->delete();
        //fash mesage
        session()->flash('success', 'Le contenu a été supprimé de votre commande');

        $total = $this->commande->contenus->count();
        if ($total == 0) {
            //supprimer la commande
            $this->commande->delete();
            //redirection vers la page des commandes
            return redirect()->route('commandes')->with('success', '');
        }
    }
    public function render()
    {
        $this->gouvernoratsTunisie = $this->getListGouvernorat();
        return view('livewire.devis.edit');
    }
}
