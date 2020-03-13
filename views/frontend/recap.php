<?php ob_start() ?>

    <div class="card posCenter">
        <div class="card-header bg-primary text-white text-center">
            <h2><?php echo 'Félicitations '.$client->getPrenom().' '.$client->getNom(); ?></h2>
        </div>
        <div class="card-body">
            <div class="row justify-content-center align-items-center text-center">
                <h3>Votre réservation n° <?= $reserv->getOrder() ?> est validée</h3>
                <div class="w-100"></div>
                <div class="divImg col-md-6" style="font-size: 1.5rem;">
                    <b>CHAMBRE <?= $reserv->getNumChambre() ?></b>
                </div>
                    
                <div class="col-md-6">
                    <div class="row justify-content-center" style="font-size: 1.5rem;">
                        <div class="col-md col-6 my-3">
                            <div class="row justify-content-between border rounded py-3">
                                <div class="col-xl"><b>ARRIVEE&nbsp;:</b></div>
                                <div class="col-xl"><?= PublicController::dateFormatMletter($reserv->getDateArrivee()) ?></div>
                            </div>
                        </div>
                        
                        <div class="w-100"></div>
                        
                        <div class="col-md col-6 my-3">
                            <div class="row justify-content-between border rounded py-3">
                                <div class="col-xl"><b>DEPART&nbsp;:</b></div>
                                <div class="col-xl"><?= PublicController::dateFormatMletter($reserv->getDateDepart()) ?></div>
                            </div>
                        </div>
                        
                        <div class="w-100"></div>
                        
                        <div class="col-md col-6 my-3">
                            <div class="row justify-content-between align-items-center border rounded py-3 text">
                                <div class="col text-center"><b>PRIX&nbsp;:</b></div>
                                <div class="col"><?= $reserv->getPrixTotal() ?> €</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="./index.php" class="btn btn-success col-md-4 col-4 mt-3">Accueil</a>
            </div>

        </div>
    </div>

<?php
$contenu = ob_get_clean();
require_once('./views/gabarit.php');