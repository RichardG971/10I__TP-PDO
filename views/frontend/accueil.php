<?php
ob_start();

// Suite à un paiement validé, les variables superglobales contenant les objets permettant d'enregistrer une nouvelle réservation en base sont détruites.
// La condition qui suit permet de supprimer les variables superglobales d'un client qui est allé jusqu'au paiement mais qui ne l'a pas validé.
if(isset($_SESSION['cons'])) { unset($_SESSION['cons']); }
?>

<h2 class="text-center">Booking-AFPA.com</h2>

    <section class="accueil">
        
        <?php foreach($data as $d) { ?>

        <div class="row align-items-center border rounded my-3">
            <div class="divImg col-sm-4 text-center py-1">
                <span><img src="./assets/Img//<?= $d->getImage() ?>" class="rounded" alt="<?= ChambreController::f_imgAlt($d->getImage()) ?>">
                <br><img src="./assets/Img//<?= $d->getImage() ?>" class="imgHov rounded" alt="<?= ChambreController::f_imgAlt($d->getImage()) ?>"></span>
            </div>
            <div class="col-sm-8">
                <div class="row align-items-center">
                    <div class="col-lg-9 col-md-8 py-3 bg-light rounded">
                        <b>Chambre <?= $d->getNumChambre() ?></b>
                        <br>
                        <b>Description :</b>
                        <br><?= ChambreController::f_ch_retourBdd($d->getDescription()) ?>
                    </div>
                    <div class="col-lg-3 col-md-4 text-center py-3">
                        <div>
                            <b>Prix : <?= $d->getPrix() ?> €</b>
                        </div>    
                        <div>
                            <a href="./index.php?action=detail_chambre&chambre=<?= $d->getNumChambre() ?>" class="btn btn-primary text-white mt-3" title="Détails de la Chambre <?= $d->getNumChambre() ?>"><i class="fas fa-info"> Détail</i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php } ?>

    </section>

<?php 
$contenu = ob_get_clean();
require_once('./views/gabarit.php');