<?php ob_start(); ?>

<h2 class="text-center">Administration</h2>

<h4 class="text-center">Gestion des Réservations</h4>
<div class="input-group my-1 justify-content-between" style="margin-bottom: 0 !important;">
    <div>
        <a href="./index.php?action=list_chambre" class="btn btn-info">CHAMBRES</a>
    </div>
</div>

<?php if($nbRow === 0) { echo "<div class='posCenter'><h2 class='text-center'>Il n'y a actuellement aucune réservation !</h2></div>"; } else { ?>

<table class="table table-bordered table-striped table-hover text-center align-middle">
    <thead class="thead-dark">
        <tr>
            <th class="align-middle">Client</th>
            <th class="align-middle">Chambre</th>
            <th class="align-middle">Arrivée</th>
            <th class="align-middle">Départ</th>
            <th class="align-middle">Action</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach($data as $d) { ?>

        <tr>
            <td class="align-middle"><?= $d->getNumClient(); ?></td>
            <td class="align-middle"><?= $d->getNumChambre(); ?></td>
            <td class="align-middle"><?= date('d-m-Y', strtotime($d->getDateArrivee())); ?></td>
            <td class="align-middle"><?= date('d-m-Y', strtotime($d->getDateDepart())); ?></td>
            <td class="align-middle">
                <div class="my-1"><a href="./index.php?action=detail_reserv&client=<?= $d->getNumClient(); ?>&chambre=<?= $d->getNumChambre(); ?>" class="btn btn-info col" title="Détails de la réservation du client <?= $d->getNumClient(); ?>"><i class="fas fa-info"></i></a></div>
                <div class="my-1"><a href="./index.php?action=upd_reserv&client=<?= $d->getNumClient(); ?>&chambre=<?= $d->getNumChambre(); ?>" class="btn btn-warning col" title="Editer la réservation du client <?= $d->getNumClient(); ?>"><i class="fas fa-pen"></i></a></div>

                <?php if($_SESSION['role'] == 1 || trim($d->getDateDepart()) <= date('Y-m-d')) { ?>
                <div class="my-1"><a onclick="return confirm('Etes vous sûr...');" href="./index.php?action=del_reserv&client=<?= $d->getNumClient(); ?>&chambre=<?= $d->getNumChambre(); ?>" class="btn btn-danger col" title="Supprimer la réservation du client <?= $d->getNumClient() ?>"><i class="fas fa-trash"></i></a></div>
                <?php } ?>

            </td>
        </tr>
    
        <?php } ?>
        
    </tbody>
</table>

<?php
}
$contenu = ob_get_clean();
require_once('./views/gabarit.php');