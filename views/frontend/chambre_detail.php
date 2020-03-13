<?php ob_start(); ?>

<h2 class="text-center">Booking-AFPA.com</h2>
<section class="chDetail posCenter row">
    <h1 class="text-center w-100 bg-info text-white rounded">Chambre <?= $chambre->getNumChambre(); ?></h1>
        <div class="divImg col-md-4 text-center align-self-center">
            <span>
                <img src="./assets/Img/<?= $chambre->getImage(); ?>" alt="<?= PublicController::f_imgAlt($chambre->getImage()) ?>" >
                <br><img src="./assets/Img/<?= $chambre->getImage(); ?>" class="imgHov rounded" alt="<?= PublicController::f_imgAlt($chambre->getImage()) ?>" >
            </span>
        </div>
        <div class="col-md-8">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><b>NumChambre</b> <?= $chambre->getNumChambre(); ?></li>
                
                <li class="list-group-item"><b>Capacité :</b> <?= $chambre->getNbPers(); ?> personne(s)</li>
                
                
                <li class="list-group-item"><b>Nombre de lit(s) :</b> <?= $chambre->getNblits(); ?></li>
                <li class="list-group-item"><b>Confort :</b> <?= PublicController::f_ch_retourBdd($chambre->getConfort()); ?></li>
                <li class="list-group-item">
                    <h3>Description</h3>
                    <?= PublicController::f_ch_retourBdd($chambre->getDescription()); ?>
                </li>
                <li class="list-group-item"><b>Prix :</b> <?= $chambre->getPrix(); ?></li>
            </ul>
        </div>
    <div class="text-right w-100">
        <a href="./index.php" class="btn btn-info col-sm-3 my-1">Accueil</a>
        <a href="./index.php?action=reservation&chambre=<?= $chambre->getNumChambre() ?>" class="btn btn-primary col-sm-3 my-1">Réserver</a>
    </div>
    <?php if(isset($_SESSION['login'])) { ?>
    <div class="text-right w-100">
        <?php if($_SESSION['role'] == 1) { ?>
        <a href="./index.php?action=upd_chambre&chambre=<?= $chambre->getNumChambre(); ?>" class="btn btn-warning col-sm-3 my-1" title="Editer la Chambre <?= $chambre->getNumChambre(); ?>">Editer</a>
        <?php } ?>
        <a href="./index.php?action=list_chambre" class="btn btn-success col-sm-3 my-1">CHAMBRES</a>
    </div>
    <?php } ?>
</section>

<?php
$contenu = ob_get_clean();
require_once('./views/gabarit.php');