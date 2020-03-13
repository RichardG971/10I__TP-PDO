<?php ob_start(); ?>

<?php if(isset($_POST['modifier'])) { ?>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Etapes</th>
            <th>Résultats</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($reserv->recap_donnees as $key => $value) { ?>
        <tr>
            <td><?= $key ?></td>
            <?php if($value != 'Période indisponible') { ?>
            <td><?= $value ?></td>
            <?php } else { ?>
            <td>
                <?= $value ?><br>
                <?php
                echo 'Disponibilité(s) sur la période sélectionnée :<br>';
                for($i = 0; $i < count($dateIndispoArr)-1; $i++) {
                    if($dateIndispoDep[$i] != $dateIndispoArr[$i+1]) {
                        echo $dateIndispoDep[$i].' au '.$dateIndispoArr[++$i].'<br>';
                    }
                }
                echo 'A partir du '.$dateIndispoDep[count($dateIndispoDep)-1].'<br>';} ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php } ?>
        


<h2 class="text-center">Administration</h2>
<div class="posCenter card">
    <div class="card-header text-center"><h3>Réservation du client <?= $client->getPrenom(); ?> <?= $client->getNom(); ?></h3></div>
    <div class="card-body">
        <form action="" method="post">
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
                            <span id="prix"><?= $chambre->getPrix() ?></span> € / nuit
                        </div>
                    </div>
                    <div class="row justify-content-around align-items-center bg-primary text-white my-3 py-3 border rounded" style="font-size: 1.2rem; font-weight: bolder;">
                        <div class="col">
                            Prix total :
                        </div>
                        <div class="col">
                            <div class="prixTotal"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-around">
                <div class="col-md-4 col-12">
                    <label for="dateArr">Date d'arrivée</label>
                    <input type="date" class="form-control text-center" id="dateArr" value="<?= $reserv->getDateArrivee() ?>" min="<?= $dateArr_min ?>" max="<?= $dateArr_max ?>" name="dateArr" <?= $reserv->form ?>>
                </div>
                <div class="col-md-4 col-12">
                    <label for="dateDep">Date de départ</label>
                    <input type="date" class="form-control text-center" id="dateDep" value="<?= $reserv->getDateDepart() ?>" name="dateDep" min="<?= $dateDep_min; ?>" max="<?= $dateDep_max; ?>" title="Pour un séjour au delà de 28 jours, contacter un administrateur" required>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md">
                    <h3 class="col">Identité client</h3>
                    <div class="w-100"></div>
                    <div class="col-12">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom" value="<?= ReservationController::f_ch_retourBddUpper(stripslashes(html_entity_decode($client->getNom()))); ?>" <?= $reserv->form ?>>
                    </div>
                    <div class="col-12">
                        <label for="prenom">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Votre prénom" value="<?= ReservationController::f_ch_retourBddUcwords($client->getPrenom()); ?>" <?= $reserv->form ?>>
                    </div>
                    <div class="col-12">
                        <label for="tel">Téléphone</label>
                        <input type="tel" class="form-control" id="tel" name="tel" placeholder="Numéro de téléphone" value="<?= ReservationController::f_ch_retourBddUcwords($client->getTel()); ?>" pattern="[0-9]{8,10}" title="Veuillez inscrire 8 à 10 chiffres entre 0 et 9" <?= $reserv->form ?>>
                    </div>
                </div>
                
                <hr>
                
                <div class="col-md">
                    <h3 class="col-12">Adresse client</h3>
                    <div class="w-100"></div>
                    <div class="col">
                        <label for="nRue">Numéro et rue</label>
                        <input type="text" class="form-control" id="nRue" name="ad[]" placeholder="Numéro et rue" value="<?= $client->ad[0]; ?>" <?= $reserv->form ?>>
                    </div>
                    <div class="col-12">
                        <label for="CP">Code postal</label>
                        <input type="text" class="form-control" id="CP" name="ad[]" placeholder="Code postale" value="<?= $client->ad[1]; ?>" pattern="[0-9]{2,5}" title="Veuillez inscrire un nombre compris entre 2 et 5 chiffres" <?= $reserv->form ?>>
                    </div>
                    <div class="col-12">
                        <label for="ville">Ville</label>
                        <input type="text" class="form-control" id="ville" name="ad[]" placeholder="Ville" value="<?= $client->ad[2]; ?>" <?= $reserv->form ?>>
                    </div>
                </div>
            </div>
            
            <br>
            <div class="row justify-content-center">
                <a onclick="return confirm('Annuler les modifications...')" href="./index.php?action=admin" class="btn btn-danger col-md-3 mx-3 mt-3">Annuler</a>
                <button onclick="return confirm('Valider les modifications...')" type="submit" class="btn btn-success col-md-3 mx-3 mt-3" name="modifier">Valider</button>
            </div>

            <?php if(isset($upSuccess)) { ?>
            <div class="text-right">
                <a href="./index.php?action=admin" class="btn btn-info col-md-3 col-4 my-1">RESERVATIONS</a>
            </div>
            <?php } ?>

        </form>
        
    </div>
</div>

<?php
$contenu = ob_get_clean();
require_once('./views/gabarit.php');