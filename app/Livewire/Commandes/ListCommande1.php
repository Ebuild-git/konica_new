<?php

namespace App\Livewire\Commandes;

use App\Http\Traits\ListGouvernorats as TraitsListGouvernorats;
use App\Models\commandes;
use App\Models\produits;
use Livewire\Component;
use Livewire\WithPagination;
use App\Mail\{OrderChangeStatut, ChangeStatut};
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;


class ListCommande extends Component
{
    use WithPagination;
    use TraitsListGouvernorats;

    public $selectedCommandes = [];
    public $date, $statut, $key, $gouvernoratsTunisie, $gouvernorat, $statut2;



    public function updatedKey($value)
    {
        $this->key = $value;
        $this->resetPage();
    }


    public function render()
    {
        $commandesQuery = commandes::query();
        if (strlen($this->date) > 0) {
            $commandesQuery->whereDate('created_at', $this->date);
        }
        if (strlen($this->gouvernorat) > 0) {
            $commandesQuery->where('gouvernorat', $this->gouvernorat);
        }
        if (strlen($this->statut) > 0) {
            $commandesQuery->where('statut', $this->statut);
        }
        if (strlen($this->statut2) > 0) {
            if ($this->statut2 == "confirmer") {
                $commandesQuery->where('etat', "confirmé");
            } else {
                $commandesQuery->where('etat', "annulé");
            }
        }
        if (strlen($this->key) > 0) {
            $commandesQuery->where('nom', 'like', '%' . $this->key . '%')
                ->orWhere('adresse', 'like', '%' . $this->key . '%')
                ->orWhere('phone', 'like', '%' . $this->key . '%')
                ->orWhere('gouvernorat', 'like', '%' . $this->key . '%')
                ->orWhere('prenom', 'like', '%' . $this->key . '%');
        }
        $commandes = $commandesQuery->Orderby('id', "Desc")->paginate(80);
        $total = commandes::count();
        $this->gouvernoratsTunisie = $this->getListGouvernorat();
        return view('livewire.commandes.list-commande', compact("commandes", "total"));
    }


    public function updateStatus($commandeId, $newStatus)
    {
        // Mettre à jour le statut de la commande dans la base de données
        $commande = commandes::findOrFail($commandeId);
        if ($commande) {
            $commande->statut = $newStatus;

            //retourner le stock si l'etat de dla command epasser a retourner
            if ($newStatus == "retournée") {
                foreach ($commande->contenus as $contenus) {
                    $article = produits::find($contenus->id_produit);
                    if ($article) {
                        $article->retourner_stock($contenus->quantite);
                    }
                }
                $this->sendOrderConfirmationMail($commande);
            }
            if ($newStatus == "traitement") {
                foreach ($commande->contenus as $contenus) {
                    $article = produits::find($contenus->id_produit);
                    if ($article) {
                        $article->retourner_stock($contenus->quantite);
                    }
                }
                $this->sendOrderConfirmationMail($commande);
            }
            if ($newStatus == "planification") {
                foreach ($commande->contenus as $contenus) {
                    $article = produits::find($contenus->id_produit);
                    if ($article) {
                        $article->retourner_stock($contenus->quantite);
                    }
                }
                $this->sendOrderConfirmationMail($commande);
            }

            //enregistrer le chagement de l'etat de la commande
            $commande->save();
        }
    }


    public function sendOrderConfirmationMail($commande){
        Mail::to ($commande->email)->send(new OrderChangeStatut($commande));
      }

    public function delete($id)
    {
        $commande = commandes::find($id);
        if ($commande) {
            $commande->delete();

            //flash message
            session()->flash('success', 'Commande supprimée avec succès');
        }
        return view('livewire.commandes.list-commande');
    }

    public function filtrer()
    {
        //reset page
        $this->resetPage();
    }


    public function confirmer($id)
    {
        $commande = commandes::find($id);
        if ($commande) {
            $commande->etat = "confirmé";
            $commande->save();
            $this->sendOrderConfirmationMail($commande);
        }
    }

    public function annuler($id)
    {
        $commande = commandes::find($id);
        if ($commande) {
            foreach ($commande->contenus as $contenus) {
                $article = produits::find($contenus->id_produit);
                if ($article) {
                    $article->retourner_stock($contenus->quantite);
                }
            }
            $commande->statut = "retournée";
            $commande->etat = "annulé";

            $commande->save();
            $this->sendOrderConfirmationMail($commande);
            
        }
    }


    public function toggleCommandeSelection($commandeId)
    {
        if (in_array($commandeId, $this->selectedCommandes)) {
            $this->selectedCommandes = array_diff($this->selectedCommandes, [$commandeId]);
        } else {
            $this->selectedCommandes[] = $commandeId;
        }
    }


    public function getSelectedCommandes()
    {
        //check if $this->selectedCommandes is not empty
        if (count($this->selectedCommandes) > 0) {
            $ids = json_encode($this->selectedCommandes);
            return redirect()->route('print_bordereau', ["ids" => $ids]);
        } else {
            return false;
        }
    }

}
