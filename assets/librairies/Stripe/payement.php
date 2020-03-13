<?php
require_once('vendor/autoload.php');

require_once('../Administration/connect.php');
require_once('../Administration/autoload.php');

//var_dump($_POST); die;
if(isset($_POST['stripeToken']) && !empty($_POST['stripeToken'])){
  $token = $_POST['stripeToken'];
  $prix = $_POST['prix'];
  $id = $_POST['id'];

  \Stripe\Stripe::setApiKey("sk_test_fnszwMz2YEz6KX7eBXLCjJfz00JfebNXx0");
  $charge = \Stripe\Charge::create([
      'amount'=>$prix.'00',
      'currency'=>'eur',
      'description'=>'ventes de véhicules',
      'source'=> $token
  ]);
}
/*echo('<pre>');
var_dump($charge);
echo('</pre>');
*/
if($charge) {
  $driver = new Driver($base);
  $veh = new Vehicule();

  $veh->setStatut(0);
  $veh->setIdVehicule($id);
  $driver->changerStatut($veh);

  header('location:../index.php');
}
