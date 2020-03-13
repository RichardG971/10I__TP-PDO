<?php 
if(isset($_GET['id'])&& !empty($_GET['id'])){
  $id = $_GET['id'];
  $prix = $_GET['prix'];
  $model = $_GET['model'];
  echo $id;
}
?>

<div class="row ">
  <div class="card col-6 offset-3" style="width: 18rem;">
  
  <div class="card-body">
      <h5 class="card-title">Achat du véhicule <?= $model; ?></h5>
      
  </div>
  <ul class="list-group list-group-flush">
      <li class="list-group-item">Modele : <?= $model; ?></li>
      <li class="list-group-item">Prix : <?= $prix; ?></li>
      
  </ul>

  <form action="./payement.php" method="POST">
  <input type="hidden" value="<?= $id; ?>" name="id">
  <input type="hidden" value="<?= $prix; ?>" name="prix">
  <!-- data-amount="50000" - 50000 = 500.00 -->
  <!-- Pour tester une CB, la carte test c'est '42' répété -->
  <script
      src="https://checkout.stripe.com/checkout.js"
      class="stripe-button"
      data-key="pk_test_EhFhj8ZGmHtMJzGhngd6tFTo00hbGYxoJe"
      data-name="Concessionnaire"
      data-description="Vehicule de dernières génarations"
      data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
      data-amount="<?=$prix; ?>00"
      data-locale="auto"
      data-currency="eur">
  </script>
  </form>
  </div>
</div>
<?php 
  $contenu = ob_get_clean();
  require_once('../gabarit.php');
