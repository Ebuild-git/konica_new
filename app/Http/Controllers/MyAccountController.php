<?php

namespace App\Http\Controllers;

use App\Models\commandes;
use App\Models\config;
use App\Models\historiques_connexion;
use App\Models\{produits, Category, favoris as ModelsFavoris};
use App\Models\User;
use App\Models\views;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportUser;
use App\Http\Traits\ListGouvernorats;
use App\Models\clients;
use App\Models\contenu_commande;
use App\Models\domaines;
use App\Models\notifications;
use App\Models\templates;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\{OrderChangeStatuts, ChangeStatut};
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;

class MyAccountController extends Controller
{
    use ListGouvernorats;




     public function comptes(){

        $commandes= commandes::where('user_id', auth()->id() )->get();
        return view('front.comptes.commandes' , compact('commandes'));
     }

     public function favories(){
        
        return view('front.comptes.favories');
     }
     
public function profile(){
    return view('front.comptes.profile');
}

public function mesdevis(){
    $commandes= commandes::where('user_id', auth()->id() )->get();
  //  dd($commandes);
    return view('front.comptes.devis');
}



public function account(){

    //$commandes= commandes::where('user_id', auth()->id() )->get();
    $commandes = commandes::where('user_id', auth()->id())->latest()->paginate(10);
    $favoris = ModelsFavoris::where('id_user', auth()->id())->latest()->paginate(10);
   // $totalCommand = $commandes->count();
    $totalCommand = commandes::where('user_id', auth()->id())
    ->WhereIn('statut',[ 'livrée', 'payée'])
    ->count();
    $totalFavoris = ModelsFavoris::where('id_user', auth()->id())->count();
    $commandesEnCours = commandes::where('user_id', auth()->id())
    ->whereIn('statut', ['attente' ,'traitement', 'En cours livraison','planification'])
    ->count();

    

    return view('front.comptes.account', compact('commandes', 'totalCommand','totalFavoris','favoris','commandesEnCours'));

}


    public function dashboard(Request $request)
    {

 

        $currentYear = date('Y');

        $currentYear2 = Carbon::now()->year;


        // Format ISO 8601 (YYYY-MM-DD)
        $firstDayOfYearISO = Carbon::createFromDate($currentYear2, 1, 1)->startOfDay()->format('Y-m-d');
        $lastDayOfYearISO = Carbon::createFromDate($currentYear2, 12, 31)->endOfDay()->format('Y-m-d');



        $date_debut = $request->input('date_debut') ??  $firstDayOfYearISO;
        $date_fin = $request->input('date_fin') ?? $lastDayOfYearISO;


        //get statistiques
        $visitsPerMonth = [];
        $commandesPerMonth = [];
        $ventesPerMonth = [];
        $inscriptionMonth = [];
        $stat_commande_confirmer_Month = [];
        $stat_commande_non_confirmer_Month = [];
        $profilNet = [];
        for ($i = 1; $i <= 12; $i++) {
            $visitsPerMonth[] = Views::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $i)
                ->count();
            $commandesPerMonth[] = Commandes::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $i)->count();

            $stat_commande_confirmer_Month[] =  Commandes::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $i)
                ->where('etat', 'confirmé')
                ->count();

            $stat_commande_non_confirmer_Month[] =  Commandes::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $i)
                ->where('etat', 'annulé')
                ->count();

            $montant = Commandes::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $i)
                ->where('statut', 'payée')
                ->get()
                ->sum(function ($commande) {
                    return $commande->montant();
                });
            $inscriptionMonth[] = clients::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $i)
                ->count();

            $ventesPerMonth[] = $montant;


            //calcul du profil net de tous les produit
            $stat_commande_non_confirmer_Month[] =  Commandes::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $i)
            ->where('etat', 'annulé')
            ->count();
            $profilNet[] = contenu_commande::whereBetween('created_at', [$date_debut, $date_fin])
                ->whereMonth('created_at', $i)
                ->whereHas('commandes', function ($query) {
                    $query->where('statut', 'payée');
                })
                ->sum('benefice');
        }


        $total_visites = views::whereBetween('created_at', [$date_debut, $date_fin])->count();
        $total_commandes = commandes::whereBetween('created_at', [$date_debut, $date_fin])->where('statut', 'payée')->get(['id']);
        $total_produits = produits::count();
        $totalDesCommandes = 0;
        foreach ($total_commandes as $command) {
            $totalDesCommandes += $command->montant();
        }
        $totalUser = clients::whereBetween('created_at', [$date_debut, $date_fin])->count();


        //get all command group by gouvernorrant collun Asc 
        $top_gouvernorat = [];
        $gouvernorats = commandes::select('gouvernorat', DB::raw('COUNT(*) as count'))
            ->whereBetween('commandes.created_at', [$date_debut, $date_fin])
            ->groupBy('gouvernorat')
            ->orderBy('count', 'desc')
            ->get();
        foreach ($gouvernorats as $top) {
            $top_gouvernorat[] = [
                "nom" => $top->gouvernorat,
                "total" => $top->count,
                "montant" => 0,
            ];
        }



        $commandes = DB::table('commandes')
            ->selectRaw('statut, COUNT(*) as count')
            ->whereBetween('created_at', [$date_debut, $date_fin])
            ->where(function ($query) {
                $query->where('statut', '!=', 'créé')
                    ->orWhere(function ($query) {
                        $query->where('statut', 'créé')
                            ->where('etat', 'confirmé');
                    });
            })
            ->groupBy('statut')
            ->whereIn('statut', ['créé', 'traitement', 'livraison', 'livrée', 'payée', 'planification retour', 'retournée'])
            ->get()
            ->pluck('count', 'statut')
            ->toArray();

        $nombre_total_commande = commandes::whereBetween('created_at', [$date_debut, $date_fin])->count();
        $statistique_commandes_graph = [];
        if ($nombre_total_commande > 0) {
            foreach ($commandes as $key => $coms) {
                $statistique_commandes_graph[] = [
                    "statut" => $key,
                    "valeur" => $coms,
                    "pourcentage" => round((($coms / $nombre_total_commande) * 100), 2),
                ];
            }
        }

        $etat_commandes = commandes::selectRaw('etat, COUNT(*) as count')
            ->whereBetween('created_at', [$date_debut, $date_fin])
            ->groupBy('etat')
            ->whereIn('etat', ['confirmé', 'annulé'])
            ->get()
            ->pluck('count', 'etat')
            ->toArray();
        // Vérifiez si $etat_commandes est défini, sinon définissez-le comme un tableau vide
        $etat_commandes = $etat_commandes ?? [];
        $pourcentage_confirmer = 0;
        $pourcentage_non_confirmer = 0;
        $total_confirme = $etat_commandes['confirmé'] ?? 0;
        $total_non_confirme = $etat_commandes['annulé'] ?? 0;
        $total_commandes = $total_confirme + $total_non_confirme;
        if ($total_commandes != 0) {
            $pourcentage_confirmer = round(($total_confirme / $total_commandes) * 100);
            $pourcentage_non_confirmer = round(($total_non_confirme / $total_commandes) * 100);
        }

        $etat_commandes = [
            'confirmer' => $total_confirme,
            'non-confirmer' => $total_non_confirme,
            'pourcentage_confirmer' => $pourcentage_confirmer,
            'pourcentage_non-confirmer' => $pourcentage_non_confirmer,
        ];


        $json_commandes = '[' . implode(',', [$commandes['créé'] ?? 0, $commandes['traitement'] ?? 0, $commandes['livraison'] ?? 0, $commandes['livré'] ?? 0, $commandes['payée'] ?? 0, $commandes['planification retour'] ?? 0, $commandes['retournée'] ?? 0]) . ']';



      //  $notifications = auth()->user()->unreadNotifications;

        return view('compte.index')
            ->with("totalUser", $totalUser)
            ->with('visitsPerMonth', $visitsPerMonth)
            ->with('commandesPerMonth', $commandesPerMonth)
            ->with('ventesPerMonth', $ventesPerMonth)
            ->with('total_visites', $total_visites)
            ->with('total_commandes', $total_commandes)
            ->with('total_produits', $total_produits)
            ->with("statistique_commandes_graph", $statistique_commandes_graph)
            ->with("commandes", $commandes)
            ->with('nombre_total_commande', $nombre_total_commande)
            ->with("json_commandes", $json_commandes)
            ->with('inscriptionMonth', $inscriptionMonth)
            ->with('profilNet', $profilNet)
            ->with('stat_commande_non_confirmer_Month', $stat_commande_non_confirmer_Month)
            ->with('stat_commande_confirmer_Month', $stat_commande_confirmer_Month)
            ->with('etat_commandes', $etat_commandes)
            ->with('top_gouvernorat', $top_gouvernorat)
            ->with('totalDesCommandes', $totalDesCommandes);
            //->with('notifications', $notifications);
    }





    public function add_note(Request $request)
    {
        $id_commande = $request->input('id_commande');
        $note = $request->input("note");

        $commande = commandes::find($id_commande);
        $commande->note = $note;
        if (!$commande) {
            return redirect()
                ->route("commandes")
                ->with("error", "Commande introuvable!");
        }
        $commande->save();
        return redirect()
            ->route("commandes")
            ->with("success", "La note a été ajouté a la commande.");
    }





    public function produits_update($id)
    {
        $produit = produits::find($id);
        if (!$produit) {
            $message = "Produit non disponible !";
            abort(404, $message);
        }
        return view('admin.produits.update', compact('produit'));
    }


    public function historique($id)
    {
        $produit = produits::find($id);
        if (!$produit) {
            $message = "Produit non disponible !";
            abort(404, $message);
        }
        return view('admin.produits.historique', compact('produit'));
    }



    public function commandes()
    {
        return view('comptes.commandes.list');
    }

    public function parametres()
    {
        $connexions = historiques_connexion::Orderby("id", "Desc")
            ->where('user_id', Auth::id())
            ->get();

        $ipAddress = request()->ip();
        return view('admin.parametres.index', compact('connexions'));
    }



    public function details_commande($id)
    {
        $commande = commandes::find($id);
        if (!$commande) {
            $message = "Commande introuvable !";
            abort(404, $message);
        }
        return view('admin.commandes.details', compact('commande'));
    }



    public function promotions($id = null)
    {
        if ($id !== null) {
            $produit = Produits::find($id);
            if (!$produit) {
                abort(404);
            }
        } else {
            $produit = null;
        }
        return view('admin.promotions.index', compact('produit'));
    }


    public function clients()
    {
        return view('admin.clients.list');
    }



    public function contact_admin()
    {
        return view('admin.parametres.contact');
    }

    public function delete_personnel($id)
    {
        $user = User::where("id", '=', $id)->first();
        if ($user) {
            $user->delete();
            return redirect()->back()->with('success', 'Personnel supprimé avec succès!');
        }
    }


    public function update_permission(Request $request)
    {

        $selectedPermissions = $request->input('permissions', []);
        $user = User::findOrFail($request->input('id'));
        $user->syncPermissions($selectedPermissions);
        return redirect()
            ->back()
            ->with('success', 'Permissions mises à jour avec succès.');
    }
}
