<?php
ob_start();

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    if(isset($_SESSION['login']))
    {
?>

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
                echo 'A partir du '.$dateIndispoDep[count($dateIndispoDep)-1].'<br>'; } ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php
    } else {
        if($reserv->recap_donnees['Nouvelle réservation'] == 'Réservation en attente de paiement') {
            $formRes = 'formResFinal';
        } else {
            $formRes = 'formRes';
        }
    }
    ?>

    <div class="<?php if(isset($formRes)) { echo $formRes; } ?> modalBgc reserv">

        <div class="modalRes container col-md-8 bg-white rounded py-3">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h2>
                    <?php
                    if(isset($msgAccCl)) { echo $msgAccCl; };
                    echo $client->getPrenom().' '.$client->getNom();?>
                    </h2>
                    <h3><?= $reserv->recap_donnees['Nouvelle réservation'] ?></h3>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center align-items-center">
                        <h3>Votre sélection</h3>
                        <div class="w-100"></div>
                        <div class="divImg col-md-6 text-center">
                            <span style="font-size: 1.5rem;"><b>CHAMBRE <?= $chambre->getNumChambre() ?></b></span>
                            <br><br><img src="./assets/Img/<?= $chambre->getImage() ?>" alt="<?= PublicController::f_imgAlt($chambre->getImage()) ?>" class="border border-primary rounded" style="box-shadow: 0 0 0 0.25rem #17a2b8;">
                        </div>
                            
                        <div class="col-md-6">
                            <div class="row justify-content-center" style="font-size: 1.5rem;">
                                <div class="col-md col-6 my-3">
                                    <div class="row justify-content-between border rounded py-3 text-center">
                                        <div class="col-xl"><b>ARRIVEE&nbsp;:</b></div>
                                        <div class="col-xl"><?= PublicController::dateFormatMletter($reserv->getDateArrivee()) ?></div>
                                    </div>
                                </div>
                                <div class="w-100"></div>
                                <div class="col-md col-6 my-3">
                                    <div class="row justify-content-between border rounded py-3 text-center">
                                        <div class="col-xl"><b>DEPART&nbsp;:</b></div>
                                        <div class="col-xl"><?= PublicController::dateFormatMletter($reserv->getDateDepart()) ?></div>
                                    </div>
                                </div>

                                <?php if($reserv->recap_donnees['Nouvelle réservation'] == 'Réservation en attente de paiement') { ?>
                                <div class="w-100"></div>
                                
                                <div class="col-md col-6 my-3">
                                    <div class="row justify-content-between align-items-center border rounded py-3 text">
                                        <div class="col text-center"><b>PRIX&nbsp;:</b></div>
                                        <div class="col"><span class="prixTotal"></span></div>
                                    </div>
                                </div>
                                <?php } ?>
                                
                            </div>
                        </div>
                    </div>
                    
                    <?php if($reserv->recap_donnees['Nouvelle réservation'] == 'Réservation non validée') { ?>
                    <div class="row justify-content-center">
                        <div class="col-md-8 text-center mt-4" style="font-size: 1.2rem;">

                        <?php
                        if(isset($dateInfo) && !empty($dateInfo)) { echo '<p><b>'.$dateInfo.'</b></p>'; }
                        if(isset($periode) && !empty($periode)) { echo '<p><b>'.$periode.'</b></p>'; }
                        if(isset($reserv->recap_donnees['Période']) && $reserv->recap_donnees['Période'] == 'Période indisponible')
                        {
                            echo '<b><u>Période(s) disponible(s) sur la période que vous avez choisie&nbsp;:</u></b><br>';
                            for($i = 0; $i < count($dateIndispoArr)-1; $i++) {
                                if($dateIndispoDep[$i] != $dateIndispoArr[$i+1]) {
                                    echo $dateIndispoDep[$i].' au '.$dateIndispoArr[++$i].'<br>';
                                }
                            }
                            echo 'A partir du '.$dateIndispoDep[count($dateIndispoDep)-1].'<br>';
                        }
                        if(isset($reservConnue) && !empty($reservConnue)) { echo '<p><b>'.$reservConnue.'<br>'.PublicController::dateFormatMletter($verifReservCl->getDateArrivee()).'</b> au <b>'.PublicController::dateFormatMletter($verifReservCl->getDateDepart()).'</b></p>'; }
                        ?>

                        </div>
                    </div>

                    <div class="text-center">
                        <a class="btnModalClose btn btn-info text-white col-md-4 col-4 mt-3" style="font-size: 1.2rem;">Modifier</a>
                    </div>
                    <div class="text-right">
                        <a onclick="return confirm('Voulez-vous vraiment quitter la réservation ?')" href="./index.php" class="btn btn-warning col-md-4 col-4 mt-3" style="font-size: 1.2rem;">Retour à l'accueil</a>
                    </div>
                    <?php } ?>

                    <?php if($reserv->recap_donnees['Nouvelle réservation'] == 'Réservation en attente de paiement') { ?>
                    <div class="text-right">
                        <a href="./index.php?action=recap" class="btn btn-success col-md-4 col-4 mt-3">Paiement</a>
                    </div>
                    <?php } ?>

                </div>
            </div>
        </div>
                
    </div>

<?php } ?>


<h2 class="text-center">Booking-AFPA.com</h2>
<div class="reserv posCenter card">
    <div class="card-header text-center"><h3>Réservation de votre Séjour</h3></div>
    <div class="row justify-content-center">
        <div class="col-md-8 mt-3"><b><span class="text-danger">*</span> Tous les champs sont requis</b></div>
    </div>
    <div class="card-body">
        <form action="" method="post">
            <div class="row justify-content-center align-items-center text-center border rounded bg-light ">
                <h3>Votre sélection</h3>
                <div class="w-100"></div>
                <div class="divImg col-md-4 col-8">
                    <span>
                        <img src="./assets/Img/<?= $chambre->getImage() ?>" alt="<?= PublicController::f_imgAlt($chambre->getImage()) ?>">
                        <br><img src="./assets/Img/<?= $chambre->getImage() ?>" class="imgHov rounded" alt="<?= PublicController::f_imgAlt($chambre->getImage()) ?>">
                    </span>
                </div>
                
                <div class="col-md-4 col-8 text-left py-3" style="font-size: 1.5rem;">
                    <div class="row justify-content-around">
                        <div class="col">
                            Chambre :
                        </div>
                        <div class="col">
                            <?= $chambre->getNumChambre() ?>
                        </div>
                    </div>
                    <div class="row justify-content-around">
                        <div class="col">
                            Prix :
                        </div>
                        <div class="col">
                            <span id="prix"><?= $chambre->getPrix() ?></span> € / nuit
                        </div>
                    </div>
                    <div class="row justify-content-around align-items-center bg-primary text-white my-3 py-3 border rounded">
                        <div class="col">
                            Prix total :
                        </div>
                        <div class="col">
                            <b><div class="prixTotal text-center"></div></b>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center my-5 text-center">
                <div class="col-md-4 col-12">
                    <label for="dateArr text-center"><span style="font-size: 1.5rem;">Date d'arrivée</span></label>
                    <input type="date" class="form-control text-center" id="dateArr" value="<?= $reserv->getDateArrivee() ?>" min="<?= date('Y-m-d'); ?>" name="dateArr" <?= $reserv->form ?>>
                </div>
                <div class="col-md-4 col-12">
                    <label for="dateDep text-center"><span style="font-size: 1.5rem;">Date de départ</span></label>
                    <input type="date" class="form-control text-center" id="dateDep" value="<?= $reserv->getDateDepart() ?>" name="dateDep" <?= $reserv->form ?> title="Pour un séjour au delà de 28 jours, contacter directement l'établissement">
                </div>
            </div>

            <hr>
            
            <div class="row justify-content-center">
                <h3>Votre identité</h3>
                <div class="w-100"></div>
                <div class="col-md-4">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom" value="<?= $client->getNom() ?>" <?= $reserv->form ?>>
                </div>
                <div class="col-md-4">
                    <label for="prenom">Prénom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Votre prénom" value="<?= $client->getPrenom() ?>" <?= $reserv->form ?>>
                </div>
                <div class="w-100"></div>
                <div class="col-md-4">
                    <label for="tel">Téléphone</label>
                    <input type="tel" class="form-control" id="tel" name="tel" placeholder="Numéro de téléphone" value="<?= $client->getTel() ?>" pattern="[0-9]{8,10}" title="Veuillez inscrire 8 à 10 chiffres entre 0 et 9" <?= $reserv->form ?>>
                </div>
            </div>
            
            <hr>
            
            <div class="row justify-content-center">
                <h3>Votre adresse</h3>
                <div class="w-100"></div>
                <div class="col-md-8">
                    <label for="nRue">Numéro et rue</label>
                    <input type="text" class="form-control" id="nRue" name="ad[]" placeholder="Numéro et rue" value="<?= PublicController::f_ch_recupFormFormat($client->ad_rec[0]); ?>" <?= $reserv->form ?>>
                </div>
                <div class="w-100"></div>
                <div class="col-md-3 col-5">
                    <label for="CP">Code postal</label>
                    <input type="text" class="form-control" id="CP" name="ad[]" placeholder="Code postale" value="<?= PublicController::f_ch_recupFormFormat($client->ad_rec[1]); ?>" pattern="[0-9]{2,5}" title="Veuillez inscrire un nombre compris entre 2 et 5 chiffres" <?= $reserv->form ?>>
                </div>
                <div class="col-md-5 col">
                    <label for="ville">Ville</label>
                    <input type="text" class="form-control" id="ville" name="ad[]" placeholder="Ville" value="<?= PublicController::f_ch_recupFormFormat($client->ad_rec[2]); ?>" <?= $reserv->form ?>>
                </div>
            </div>

            <br>
            <div class="row justify-content-center">
                
                <?php if($reserv->recap_donnees['Nouvelle réservation'] == 'Réservation en attente de paiement') { ?>
                    <a href="./index.php?action=recap" class="btn btn-success col-md-3 col-4 mt-3">Paiement</a>
                <?php } else { ?>
                <a href="./index.php?action=detail_chambre&chambre=<?= $chambre->getNumChambre() ?>" class="btn btn-info col-md-3 mx-3 mt-3">Précédent</a>
                <button type="submit" class="btn btn-success col-md-3 mx-3 mt-3" name="reserver">Valider</button>
                <?php } ?>

            </div>

        </form>

        <div class="text-right">
            <a onclick="return confirm('Quitter la réservation...')" href="./index.php" class="btn btn-warning col-md-2 col-4 mt-3">Accueil</a>
            
            <?php if(isset($_SESSION['login'])) { ?>
            <a href="./index.php?action=admin" class="btn btn-success col-md-2 col-4 mt-3">RESERVATIONS</a>
            <?php } ?>

        </div>

    </div>
</div>

<?php
$contenu = ob_get_clean();
require_once('./views/gabarit.php');