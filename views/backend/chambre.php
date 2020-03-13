<?php ob_start(); ?>

<h2 class="text-center">Administration</h2>
<h4 class="text-center">Gestion des Chambres</h4>

<form method="post">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-10 col">

            <div class="row justify-content-center">
                <div class="form-group col-md-4 col">
                    <label for="dateArrSearch">Date d'arrivée</label>
                    <input type="date" id="dateArrSearch" class="form-control text-center" name="dateArrSearch" placeholder="rechercher">
                </div>
                <div class="form-group col-md-4 col">
                    <label for="dateDepSearch">Date de départ</label>
                    <input type="date" id="dateDepSearch" class="form-control text-center" name="dateDepSearch" placeholder="rechercher">
                </div>
                <div class="form-group col-md-4 col-6">
                    <label for="langue">Libres / Occupées</label>
                    <select class="form-control" id="occupation" name="occupation">
                        <option value="Toutes" required>Toutes</option>
                        <option value="libre(s)">Libres</option>
                        <option value="occupée(s)">Occupées</option>
                    </select>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-4 col-6 mb-3">
                    <button type="submit" class="form-control bg-primary text-white border-primary" id="search" name="search"><i class="fas fa-search"></i></button>
                </div>
            </div>

            <?php if(isset($_POST['search'])) { ?>
            <hr>
            <h3 class="text-center">Votre recherche</h3>
            <div class="row justify-content-center">
                <div class="form-group col-md-4 col-6">
                    <div class="<?= $bg_occupation ?> form-control text-center font-weight-bolder">
                        <?= $occupationRes ?>
                    </div>
                </div>
                <div class="form-group col-md-8 col-8">
                    <div class="form-control text-center bg-light">
                    <?php
                    if(!empty($reserv->getDateArrivee()) && !empty($reserv->getDateDepart()))
                    {
                        echo 'du <b>'.ChambreController::dateFormatMletter($reserv->getDateArrivee()).'</b> au <b>'.ChambreController::dateFormatMletter($reserv->getDateDepart()).'</b>';
                    } else {
                        echo '<b>Toutes les dates</b>';
                    }
                    ?>
                    </div>
                </div>
            </div>
            <?php } ?>
            
        </div>
    </div>
</form>

<div class="input-group my-1 justify-content-between" style="margin-bottom: 0 !important;">
    <div>
        <a href="./index.php?action=admin" class="btn btn-info">RESERVATION</a>
    </div>
    
    <?php if($_SESSION['role'] == 1) { ?>
    <div>
        <a href="./index.php?action=ajout_chambre" class="btn btn-primary">Ajouter une chambre</a>
    </div>
    <?php } ?>

</div>

<?php
if(isset($nbChambre) && $nbChambre === 0)
{
    echo "
        <div class='posCenter'>
            <h2 class='text-center'>Il n'y a pas de chambres enregistrée dans votre établissement !</h2>
            <div class='text-center'>
                <a href='chAjout.php' class='btn btn-primary'>Ajouter une chambre</a>
            </div>
        </div>
    ";
} else {
?>

<?php
if(isset($data) && (int)count($data) === 0)
{
    echo "
        <div class='posCenter'>
            <h2 class='text-center'>Il n'y a pas de ".$occupationRes." sur la période que vous avez sélectionnée</h2>
        </div>
    ";
} else {
?>

<table class="chambre table table-bordered table-striped table-hover align-middle">
    <thead class="thead-dark text-center">
        <tr>
            <th class="align-middle" colspan="2">CHAMBRE</th>
            <th class="align-middle">
                Lits
                <br>Capacité
            </th>
            <th class="align-middle">Confort</th>
            <th class="align-middle">Description</th>
            <th class="align-middle">Prix<br>/ nuit</th>
            <th class="align-middle">Action</th>
        </tr>
    </thead>

    <tbody>

        <?php foreach($data as $d) { ?>
        <tr>
            <td class="align-middle text-center"><?= $d->getNumChambre(); ?></td>
            <td class="align-middle text-center">
                <div class="divImg">
                    <span>
                        <img src="./assets/Img/<?= $d->getImage(); ?>" alt="<?= ChambreController::f_imgAlt($d->getImage); ?>">
                        <br><img src="./assets/Img/<?= $d->getImage(); ?>" class="imgHov rounded" alt="<?= ChambreController::f_imgAlt($d->getImage); ?>">
                    </span>
                </div>
            </td>
            <td class="align-middle">
                Nombre de lit(s)&nbsp;:&nbsp;<?= $d->getNbLits(); ?>
                <br><?= $d->getNbPers(); ?>&nbsp;personne(s)
            </td>
            <td class="align-middle"><?= ChambreController::f_ch_retourBdd($d->getConfort()); ?></td>
            <td class="align-middle"><?= ChambreController::f_ch_retourBdd($d->getDescription()); ?></td>
            <td class="align-middle text-center"><?= $d->getPrix(); ?></td>
            <td class="align-middle">
                <div class="my-1"><a href="./index.php?action=detail_chambre&chambre=<?= $d->getNumChambre() ?>" class="btn btn-info col" title="Détails de la Chambre <?= $d->getNumChambre(); ?>"><i class="fas fa-info"></i></a><div>
                <?php if($_SESSION['role'] == 1) { ?>
                <div class="my-1"><a href="./index.php?action=upd_chambre&chambre=<?= $d->getNumChambre(); ?>" class="btn btn-warning col" title="Editer la Chambre <?= $d->getNumChambre(); ?>"><i class="fas fa-pen"></i></a></div>    
                <div class="my-1"><a onclick="return confirm('Etes vous sûr...')" href="./index.php?action=del_chambre&chambre=<?= $d->getNumChambre(); ?>&img=<?= $d->getImage(); ?>" class="btn btn-danger col" title="Supprimer la Chambre <?= $d->getNumChambre(); ?>"><i class="fas fa-trash"></i></a></div>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
        
    </tbody>
</table>

<?php
}}
$contenu = ob_get_clean();
require_once('./views/gabarit.php');