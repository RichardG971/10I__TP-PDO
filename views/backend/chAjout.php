<?php ob_start(); ?>

<h2 class="text-center">Administration</h2>

<?php 
if(isset($addSuccess)) { echo $addSuccess; } 
if(isset($nChExist)) {
    echo $nChExist;
    echo '<p class="text-center">Changez le numéro de la chambre.<br>N\'oubliez pas de sélectionner à nouveau l\'image.</p>';
}
?>

<div class="card posCenter">
    <div class="card-header text-center"><h4>AJOUT D'UNE CHAMBRE</h4></div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md">
                    <label for="nCh">N° Chambre :</label>
                    <input type="text" name="nCh" id="nCh" class="form-control text-center" value="<?= $newCh->getNumchambre() ?>" min="1" pattern="[^0a-zA-Z][0-9]{0,2}" title="Nombre de 1 à 3 chiffres ne commençant pas par 0" placeholder="N° de la Chambre" required>
                </div>
                <div class="col-md">
                    <label for="nLits">Nombre de lits :</label>
                    <input type="text" name="nLits" id="nLits" class="form-control text-center" value="<?= $newCh->getNbLits() ?>" min="1" pattern="[1-8]" title="chiffre de 1 à 8" placeholder="Nombre de lits" required>
                </div>
                <div class="col-md">
                    <label for="nPers">Capacité :</label>
                    <input type="text" name="nPers" id="nPers" class="form-control text-center" value="<?= $newCh->getNbPers() ?>" min="1" pattern="[1-9]|1[0-5]" title="nombre de 1 à 15" placeholder="Nombre de personnes" required>
                </div>
            </div>

            <div class="form-group">
                <label for="image">Image :</label>
                <input type="file" name="image" id="image" class="form-control-file border" required>
            </div>

            <div class="form-group">
                <label for="conf">Confort :</label>
                <textarea name="conf" id="conf" class="form-control" rows="2" required><?= $newCh->getConfort() ?></textarea>
            </div>

            <div class="form-group">
                <label for="descr">Description :</label>
                <textarea name="descr" id="descr" class="form-control" rows="5" required><?= $newCh->getDescription() ?></textarea>
            </div>

            <div class="row justify-content-center">
                <div class="form-group col-md-3 col-6">
                    <label for="prix">Prix :</label>
                    <input type="text" name="prix" id="prix" class="form-control text-center" value="<?= $newCh->getPrix() ?>" pattern="[^0a-zA-Z][0-9]{1,3}" title="Nombre de 2 à 4 chiffres ne commençant pas par 0" placeholder="Prix" required>
                    <!-- Pour le pattern '[^0a-zA-Z][0-9]{1,3}', on demande 4 chiffres maximum. '[^0a-zA-Z]' compte pour un chiffre c'est pour cela que '[0-9]{1,3}' on ne demande que 3 chiffres maximum pour avoir un total de 4. -->
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block font-weight-bolder" name="ajouter">Ajouter</button>

        </form>

        <div class="text-right">
            <a href="./index.php?action=list_chambre" class="btn btn-warning col-md-2 col-4 mt-3">Retour</a>
        </div>

    </div>
</div>

<?php
$contenu = ob_get_clean();
require_once('./views/gabarit.php');