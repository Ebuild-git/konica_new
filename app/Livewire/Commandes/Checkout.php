<?php

namespace App\Livewire\Commandes;

use Livewire\Component;
use App\Http\Requests\commandes\CommandesRequest;
use Illuminate\Http\Request;
use App\Models\{commandes, produits,Coupon, contenu_commande, config, notifications, User, Transport};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
//use Illuminate\Support\Facade\Mail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\OrderMail;
use App\Mail\FirstOrder;
use Illuminate\Support\Facades\DB;
use App\Notifications\NewOrder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Mail\Mailable;
use App\Services\PayUService\Exception;
use Illuminate\Validation\ValidationException;
use Helper;
class Checkout extends Component
{
    public $key, $nom, $prenom, $frais, $adresse, $gouvernorat, $phone,$email,$note, $mode, $transport;

    public $cart;
 public $transports = []; 

   public $adresse_supp1;
   public $adresse_supp2;
    public function mount()
    {
       
      
        $this->nom = Auth::check() ? Auth::user()->nom : '';
        $this->prenom = Auth::check() ? Auth::user()->prenom : '';
        $this->adresse = Auth::check() ? Auth::user()->adresse : '';
        $this->gouvernorat = Auth::check() ? Auth::user()->gouvernorat : '';
        $this->phone = Auth::check() ? Auth::user()->phone : '';
        $this->email = Auth::check() ? Auth::user()->email : '';
        $this->cart = session('cart', []); 
        if (Auth::check()) {
            $user = Auth::user();
            $this->nom = $user->nom;
            $this->prenom = $user->prenom;
            $this->email = $user->email;
            $this->phone = $user->phone;
            
        }
        $this->transports = \App\Models\Transport::all(); 


    }
   
    public function updatedGouvernorat($value)
    {
        // Trouver les frais pour la ville sélectionnée
        $selectedTransport = $this->transports->firstWhere('ville', $value);

        $this->frais = $selectedTransport ? $selectedTransport->frais : null;
    }
       



    protected $rules = [
        'nom' => 'required|string|max:255',
        'prenom' => 'nullable|string|max:255',
        'email' => 'required|email',
        'phone' => 'required|string',
        'adresse' => 'required|string',
      
      
        'adresse_supp1' => 'nullable|string',
        'adresse_supp2' => 'nullable|string',
        'note' => 'nullable|string',
     //   'gouvernorat' => 'required|string',
    //    'mode' => 'required|string',
    //    'transport' => 'nullable|exists:transports,id',
        'gouvernorat' => 'required|exists:transports,ville',
        'frais' => 'nullable|numeric',
       
     //   'coupon' => 'nullable|numeric',
    ];



   public function render()
    {

        $configs = config::firstOrFail();
        // $paniers_session = session('cart');
     
        $paniers_session = session('cart', []);
     
       // Vérifier que $paniers_session est bien un tableau
       if (!is_array($paniers_session)) {
           $paniers_session = [];
       }
         $paniers = [];
         $total = 0;
         if(empty($paniers_session)){
           request()->session()->flash('error','La panier est vide !');
           return back();
       }
     
         
       if (session()->has('coupon')) {
         $coupon = session()->get('coupon');
         $value = Coupon::where('code', $coupon)->first();
         $discuont = session('coupon')['value'];
      
     }
     
         foreach ($paniers_session as $session) {
           $produit = produits::find($session['id_produit']);
           if ($produit) {
             $paniers[] = [
               'nom' => $produit->nom,
               'id_produit' => $produit->id,
               'photo' => $produit->photo,
               'quantite' => $session['quantite'],
               'prix' => $produit->getPrice(),
               'total' => $session['quantite'] * $produit->getPrice(),
             ];
             if (session()->has('coupon')) {
             $total += $session['quantite'] * $produit->getPrice() - session('coupon')['value'];
             }else{
             $total += $session['quantite'] * $produit->getPrice();
             }
            
          //  dd($total);
           }
         }
     
        $transports = Transport ::all();
        return view('livewire.commandes.checkout',   compact('configs', 'paniers', 'total','transports'));

    }


    
  public function confirmOrder(Request $request)
  {

    $connecte = Auth::user();
    $configs = config::firstOrFail();
    $total = 0;
    
    if (session()->has('coupon')) {
        $coupon = session()->get('coupon');
        $value = Coupon::where('code', $coupon)->first();
        $discuont = session('coupon')['value'];
     
    }

if($connecte){
  $order = new commandes();
  $this->validate();
      
  
        $order->user_id = $connecte->id;
        $order->nom = $this->nom;
        $order->prenom = $this->prenom;
        $order->adresse = $this->adresse;
   
        $order->phone = $this->phone;
        $order->email = $this->email;
        $order->note = $this->note;
      
        $order->adresse_supp1 = $this->adresse_supp1;
        $order->adresse_supp2 = $this->adresse_supp2;
  
       $order->gouvernorat = $this->gouvernorat;
       $order->frais = $this->frais;

   
} else{
  $this->validate();
  $order = new commandes();
      $order->nom = $this->nom;
      $order->prenom = $request->prenom;
      $order->email = $request->email;
      $order->adresse = $request->adresse;
      $order->phone = $request->phone;
      $order->note = $request->note;
   //   $produit->adresses = $this->adresses ?? false;
      $order->adresse_supp1 = $this->adresse_supp1;
      $order->adresse_supp2 = $this->adresse_supp2;
    $order->frais = $this->frais;
     

        $order->gouvernorat = $this->gouvernorat;
    
}


    $order->save();
  $existingUsersWithEmail = User::where('email', $request['email'])->exists();

  if (!$existingUsersWithEmail) {
    $this->validate();
$user = new User();
$user->nom = $this->nom;
$user->prenom = $this->prenom;
$user->email = $this->email;
$user->password = Hash::make($this->phone);
$user->phone = $this->phone;
//Mail::to($user->email)->send(new FirstOrder($user));


}
 
    $paniers_session = Session::get('cart') ?? [];
    $total = 0;

    foreach ($paniers_session as $session) {
      $produit = produits::find($session['id_produit']);
      if ($produit) {

        $items=   contenu_commande::create([
          'id_commande' => $order->id,
          'id_produit' => $produit->id,
          'prix_unitaire' => $produit->getPrice(),
          'quantite' => $session['quantite'],
       
        ]);


        $produit->diminuer_stock($session['quantite']);
      }
    }

    //envoyer les emails
   //  $this->sendOrderConfirmationMail($order);
     
    //effacer le panier
  // session()->forget('cart');
   session()->forget('coupon');

    //generate notification
    $notification = new notifications();
   $notification->url = route('details_commande', ['id' => $order->id]);
    $notification->titre = "Nouvelle commande.";
   $notification->message = "Commande passée par " . $order->nom;
    $notification->type = "commande";
    $notification->save();
   

    return redirect()->route('thank-you');
  }

 



  public function sendOrderConfirmationMail($order)
  {
   
      Mail::to($order->email)->send(new OrderMail($order));
   
  }
}
