<?php

namespace App\Livewire\Commandes;

use App\Http\Traits\ListGouvernorats;
use App\Models\clients;
use App\Models\commandes;
use App\Models\config;
use App\Models\contenu_commande;
use App\Models\packs;
use App\Models\produits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class AjouterCommande extends Component
{
    public $key, $nom, $pays, $prenom, $frais, $adresse, $gouvernorat, $phone, $recherche, $clients = [];
    public $quantites = [];
    public $produits = [];
    public $panier, $gouvernoratsTunisie;
    use ListGouvernorats;

    public function updateKey($value)
    {
        $this->key = $value;
        $this->resetPage();
    }


    public function updatedRecherche($recherche)
    {
        if (strlen($recherche) > 0) {
            $this->clients = clients::where('nom', 'like', '%' . $recherche . '%')
                ->orWhere('prenom', 'like', '%' . $recherche . '%')
                ->orWhere('phone', 'like', '%' . $recherche . '%')
                ->take(10)
                ->get();
        } else {
            $this->clients = [];
        }
    }

    public function import($client)
    {
        $this->nom = $client["nom"];
        $this->prenom = $client["prenom"];
        $this->adresse = $client["adresse"];
        $this->phone = $client["phone"];
        $this->gouvernorat = $client["gouvernorat"];
        $this->pays = $client["pays"];

        $this->recherche = "";
        $this->clients = [];

        //flash message
        session()->flash("message", "Client Importé avec succés");
    }





    public function ajouterProduit($produitId, $type, $reference)
    {
        $cartData = Session::get('panier', []);
    
        $quantite = $this->quantites[$produitId] ?? 1;
        $this->quantites[$produitId] = 1;

        if ($type == "produit") {
            //verifier le produit
            $article = produits::find($produitId);
            if ($article) {
                //verifier la quantite disponible en stock
                if ($quantite <= $article->stock) {
                    // Stocker les données dans la session
                    $cartData[] =[
                        "id" => $article->id,
                        "quantite" =>  intval($quantite),
                        "type"=> $type,
                        "nom" =>$article->nom,
                        "prix" => $article->prix,
                        "reference" =>$article->reference,
                    ];
                } else {
                    //flash error message
                    session()->flash('error', "La quantité demandée pour l'article ' $article->nom ' est indisponible.");
                }
                $this->render();
            }
        } else {
            //verifier le pack existe
            $pack = produits::find($produitId);
            if ($pack) {
                // Stocker les données dans la session
                $cartData[]=[
                    "id" =>  $pack->id,
                    "quantite" =>  intval($quantite),
                    "type"=> $type,
                    "nom" => $pack->nom,
                    "prix" => $pack->prix,
                    "reference" => $pack->reference,
                ];
            }
        }
        $this->quantites[$produitId] = 0;
        $this->produits = [];
        $this->render();
        Session::put('panier', $cartData);
    }









    public function render()
    {
        //recuperation du panier dans la session
         $paniers = session()->get('panier', []);
        //dd( $this->panier);
        //session()->forget('panier');
        

        if (!is_null($this->key)) {
            $produits = Produits::where('nom', 'like', '%' . $this->key . '%')->take(5)->get();
            $packs = Packs::where('nom', 'like', '%' . $this->key . '%')->take(5)->get();

            $result = [];

            // Ajouter les produits au tableau result avec le type 'produit'
            foreach ($produits as $produit) {
                $result[] = [
                    'id' => $produit->id,
                    'nom' => $produit->nom,
                    'prix' => $produit->prix,
                    'reference' => $produit->reference,
                    'type' => 'produit'
                ];
            }

            // Ajouter les packs au tableau result avec le type 'pack'
            foreach ($packs as $pack) {
                $result[] = [
                    'id' => $pack->id,
                    'nom' => $pack->nom,
                    'prix' => $pack->prix,
                    'reference' => $pack->reference,
                    'type' => 'pack'
                ];
            }

            $this->produits = $result;
        }
        

        $this->gouvernoratsTunisie = $this->getListGouvernorat();
        return view('livewire.commandes.ajouter-commande', compact('paniers'));
    }




    public function delete_from_session($produitId)
    {
        unset($this->panier[$produitId]);
        session(['panier' => $this->panier]);
    }


    public function order()
    {
        //validation du formulaire
        $this->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'nullable|string|max:100',
            'adresse' => 'required|string|max:150',
            'phone' => 'required|string|max:100',
            'pays' => 'required|string|max:100',
            'gouvernorat' => 'required|string|max:12',
            'frais' => 'nullable',
        ]);

        //check $gouvernorat exist in $gouvernoratsTunisie array
        if (!in_array($this->gouvernorat, $this->gouvernoratsTunisie)) {
            session()->flash('message', "Le gouvernorat saisi n'est pas valide");
            return;
        }


        //creer un nouveau client si le numerod e tel nest pas encore utiliser
        $count = clients::Where("phone", $this->phone)->count();
        if ($count == 0) {
            $client = new clients();
            $client->nom = $this->nom;
            $client->prenom = $this->prenom;
            $client->adresse = $this->adresse;
            $client->phone = $this->phone;
            $client->pays = $this->pays;
            $client->gouvernorat = $this->gouvernorat;
            $client->save();
        }



        $panier = session()->get('panier', []);
        if ($panier) {
            $config = config::first();
            $commande = new commandes();
            $commande->nom = $this->nom;
            $commande->prenom = $this->prenom;
            $commande->adresse = $this->adresse;
            $commande->phone = $this->phone;
            $commande->pays = $this->pays;
            $commande->frais = $this->frais ? $config->frais : null;
            $commande->gouvernorat = $this->gouvernorat;
            if ($commande->save()) {
                foreach ($panier as $panier) {

                    //recuperation du type
                    $type = $panier["type"];
                    $quantite = intval($panier["quantite"]);
                    if($type == "produit"){
                        //il s'agit d'un produit
                        $article = produits::find($panier["id"]);
                        if ($article) {
                            $contenu = new contenu_commande();
                            $contenu->id_commande = $commande->id;
                            $contenu->id_produit = $article->id;
                            $contenu->quantite =  $quantite;
                            $contenu->type = $type;
                            $contenu->prix_unitaire =  $article->getPrice();
                            $contenu->benefice = ($article->getPrice() - $article->prix_achat) * $quantite;
                            $contenu->save();
    
                            //diminuer le stock
                            $article->diminuer_stock($quantite);
                        }
                    }else{
                        //il s'agit du pack
                        $pack = packs::find($panier["id"]);
                        if($pack){
                                $contenu = new contenu_commande();
                                $contenu->id_commande = $commande->id;
                                $contenu->id_pack = $pack->id;
                                $contenu->quantite =  $quantite;
                                $contenu->type = $type;
                                $contenu->prix_unitaire =  $pack->prix;
                                $contenu->benefice = 0;
                                $contenu->save();
                        }
                    }

                    
                }

                //delete session panier
                session()->forget('panier');

                //redirection
                return Redirect()->route('details_commande', ["id" => $commande->id])->with("success", "Votre commande a été enregistré");
            } else {
                //flash error message
                session()->flash('warning', 'Echec de la création de la commande.');
            }
        } else {
            //flash error message
            session()->flash('warning', 'Votre panier est vide.');
        }
    }
}
