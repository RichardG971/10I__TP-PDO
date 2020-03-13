<?php ob_start(); ?>

<h2 class="text-center">Administration</h2>
<div class="posCenter card">
    <div class="card-header text-center"><h3>Réservation du client <?= $client->getPrenom(); ?> <?= $client->getNom(); ?></h3></div>
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="w-100"></div>
            <div class="text-center">
                <h4>Chambre <?= $chambre->getNumChambre() ?></h4>
            </div>
            <div class="w-100"></div>
            <div class="col-md-4 col-8 text-left py-3">
                <div class="row justify-content-around">
                    <div class="col">
                        Prix :
                    </div>
                    <div class="col">
                        <span id="prix"><?= $chambre->getPrix(); ?></span> € / nuit
                    </div>
                </div>
                <div class="row justify-content-around align-items-center bg-primary text-white my-3 py-3 border rounded" style="font-size: 1.2rem; font-weight: bolder;">
                    <div class="col">
                        Prix total :
                    </div>
                    <div class="col">
                        <div><?= $tpsSejour; ?> nuit(s)<br><?= $prixSejour; ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-around">
            <div class="col-md-4 col-12">
                <label for="dateArr">Date d'arrivée</label>
                <span style="background-color: #e9ecef;" class="form-control text-center"><?= ReservationController::dateFormatMletter($reserv->getDateArrivee()) ?></span>
            </div>
            <div class="col-md-4 col-12">
                <label for="dateDep">Date de départ</label>
                <span style="background-color: #e9ecef;" class="form-control text-center"><?= ReservationController::dateFormatMletter($reserv->getDateDepart()) ?></span>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md">
                <h3 class="col">Identité client</h3>
                <div class="w-100"></div>
                <div class="col-12">
                    <label for="nom">Nom</label>
                    <span style="background-color: #e9ecef;" class="form-control"><?= ReservationController::f_ch_retourBddUpper(stripcslashes(html_entity_decode($client->getNom()))); ?></span>
                </div>
                <div class="col-12">
                    <label for="prenom">Prénom</label>
                    <span style="background-color: #e9ecef;" class="form-control"><?= ReservationController::f_ch_retourBddUcwords($client->getPrenom()); ?></span>
                </div>
                <div class="col-12">
                    <label for="tel">Téléphone</label>
                    <span style="background-color: #e9ecef;" class="form-control"><?= ReservationController::f_ch_retourBddUcwords($client->getTel()); ?></span>
                </div>
            </div>
            
            <hr>
            
            <div class="col-md">
                <h3 class="col-12">Adresse client</h3>
                <div class="w-100"></div>
                <div class="col">
                    <label for="nRue">Numéro et rue</label>
                    <span style="background-color: #e9ecef;" class="form-control"><?= $client->ad[0]; ?></span>
                </div>
                <div class="col-12">
                    <label for="CP">Code postal</label>
                    <span style="background-color: #e9ecef;" class="form-control"><?= $client->ad[1]; ?></span>
                </div>
                <div class="col-12">
                    <label for="ville">Ville</label>
                    <span style="background-color: #e9ecef;" class="form-control" ><?= $client->ad[2]; ?></span>
                </div>
            </div>
        </div>
        
        <br>
        <div class="row justify-content-center">
            
            <?php if($_SESSION['role'] === 1 || trim($reserv->getDateDepart()) <= date('Y-m-d')) { ?>
            <a onclick="return confirm('Etes vous sûr...');" href="./index.php?action=del_reserv&client=<?= $reserv->getNumClient(); ?>&chambre=<?= $reserv->getNumChambre(); ?>" class="btn btn-danger col-md-3 mx-3 mt-3" title="Supprimer la réservation du client <?= $client->getPrenom().' '.$client->getNom(); ?>">Supprimer</a>
            <?php } ?>

            <a href="./index.php?action=admin" class="btn btn-info col-md-3 mx-3 mt-3">Précédent</a>
            <a href="./index.php?action=upd_reserv&client=<?= $reserv->getNumClient(); ?>&chambre=<?= $reserv->getNumChambre(); ?>" class="btn btn-warning col-md-3 mx-3 mt-3" title="Editer la réservation du client <?= $client->getPrenom().' '.$client->getNom(); ?>">Editer</a>
        </div>

        
    </div>
</div>

<?php
$contenu = ob_get_clean();
require_once('./views/gabarit.php');