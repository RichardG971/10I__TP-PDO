<?php ob_start(); ?>

<h2 class="text-center">Administration</h2>

<?php if(isset($upSuccess)) { echo $upSuccess; ?>
<div class="input-group my-1 justify-content-end" style="margin-bottom: 0 !important;">
    <div>
        <a href="./index.php?action=list_chambre" class="btn btn-success">CHAMBRES</a>
    </div>
</div>
<?php } ?>

<div class="chEdit card posCenter">
    <div class="card-header text-center"><h4>Editer la chambre <?= $chambre->getNumChambre() ?></h4></div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <label for="nLits">Nombre de lits :</label>
                    <input type="text" name="nLits" id="nLits" class="form-control text-center" value="<?= $chambre->getNbLits() ?>" min="1" pattern="[1-8]" title="chiffre de 1 à 8" required>
                </div>
                <div class="col-md-4">
                    <label for="nPers">Nombre de personnes :</label>
                    <input type="text" name="nPers" id="nPers" class="form-control text-center" value="<?= $chambre->getNbPers() ?>" min="1" pattern="[1-9]|1[0-5]" title="nombre de 1 à 15" required>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="form-group text-center col-md-8">
                    <label for="image">Image :</label>
                    <input type="file" name="image" class="form-control-file border rounded">
                    <div class="divImg pl-3">
                        <span>
                            <img src="./assets/Img/<?= $chambre->getImage() ?>" alt="<?= ChambreController::f_imgAlt($chambre->getImage()) ?>" class="my-3">
                            <br><img src="./assets/Img/<?= $chambre->getImage() ?>" class="imgHov rounded" alt="<?= ChambreController::f_imgAlt($chambre->getImage()) ?>">
                        </span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="conf">Confort :</label>
                <textarea name="conf" id="conf" class="form-control" rows="2" required><?= ChambreController::f_ch_retourBdd($chambre->getConfort()) ?></textarea>
            </div>

            <div class="form-group">
                <label for="descr">Description :</label>
                <textarea name="descr" id="descr" class="form-control" rows="10" required><?= ChambreController::f_ch_retourBdd($chambre->getDescription()) ?></textarea>
            </div>

            <div class="row justify-content-center">
                <div class="form-group col-md-3 col-6">
                    <label for="prix">Prix :</label>
                    <input type="text" name="prix" id="prix" class="form-control text-center" value="<?= $chambre->getPrix() ?>" pattern="[^0a-zA-Z][0-9]{1,3}" title="Nombre de 2 à 4 chiffres ne commençant pas par 0" required>
                    <!-- Pour le pattern '[^0a-zA-Z][0-9]{1,3}', on demande 4 chiffres maximum. '[^0a-zA-Z]' compte pour un chiffre c'est pour cela que '[0-9]{1,3}' on ne demande que 3 chiffres maximum pour avoir un total de 4. -->
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block" name="valider">Valider</button>

        </form>

        <div class="text-right">
            <a onclick="return confirm('Annuler les modifications ?')" href="./index.php?action=list_chambre" class="btn btn-warning col-md-3 col-4 my-1">Annuler</a>

            <?php if(isset($upSuccess)) { ?>
            <a href="./index.php?action=list_chambre" class="btn btn-success col-md-3 col-4 my-1">CHAMBRES</a>
            <?php } ?>

        </div>

    </div>
</div>

<?php
$contenu = ob_get_clean();
require_once('./views/gabarit.php');