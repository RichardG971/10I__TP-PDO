<?php ob_start(); ?>

<div class="posCenter col-md-6" style="margin-left: auto; margin-right: auto;">
    <div class="card text-center" style="font-size: 1.5rem;">
        <div class="card-body bg-light">
            <h5 class="card-title" style="font-variant: small-caps;">Paiement de votre séjour</h5>
        </div>
        
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Chambre : <?= $reserv->getNumChambre(); ?></li>
            <li class="list-group-item">Prix : <?= $reserv->getPrixTotal(); ?> €</li>
        </ul>
    
        <form action="" method="POST">
            <input type="hidden" value="<?= $reserv->getNumChambre(); ?>" name="nCh">
            <input type="hidden" value="<?= $reserv->getPrixTotal(); ?>" name="prix">
            <script
                src="https://checkout.stripe.com/checkout.js"
                class="stripe-button"
                data-key="pk_test_EhFhj8ZGmHtMJzGhngd6tFTo00hbGYxoJe"
                data-name="Booking-AFPA.com"
                data-description="Pour de meilleures vacances"
                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                data-amount="<?= $prix; ?>00"
                data-locale="auto"
                data-currency="eur">
            </script>
            <div class="mb-2"></div>
        </form>
    </div>
</div>

<?php 
$contenu = ob_get_clean();
require_once('./views/gabarit.php');