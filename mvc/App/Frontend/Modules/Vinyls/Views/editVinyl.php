<div class="row">
    <div class="col-md-12 text-center mb-4">
        <h2>Ajouter un vinyl</h2>
    </div>
    <div class="col-md-12 offset-md-3">
        <form action="" method="post">
            <div class="form-row">
                <div class="form-group col-md-2">
                    <?php isset($erreurs) && in_array(\Entity\Vinyl::AUTEUR_INVALIDE, $erreurs) ? 'L\'artiste est invalide.<br />' : '' ?>
                    <label for="artist">Artiste : </label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="artist">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                <?php isset($erreurs) && in_array(\Entity\Vinyl::TITRE_ALBUM_INVALIDE, $erreurs) ? 'Le titre est invalide.<br />' : '' ?>
                    <label for="title">Titre : </label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="title" id="title" value="<?php isset($vinyl) ? htmlspecialchars($vinyl->titleAlbum()) : '' ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                <?php isset($erreurs) && in_array(\Entity\Vinyl::LABEL_INVALIDE, $erreurs) ? 'Le label est invalide.<br />' : '' ?>
                    <label for="label">Label : </label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="label" id="label" value="<?php isset($vinyl) ? htmlspecialchars($vinyl->label()) : '' ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                <?php isset($erreurs) && in_array(\Entity\Vinyl::PAYS_INVALIDE, $erreurs) ? 'Le pays est invalide.<br />' : '' ?>
                    <label for="country">Pays édition : </label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="country" id="country" value="<?php isset($vinyl) ? htmlspecialchars($vinyl->country()) : '' ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                <?php isset($erreurs) && in_array(\Entity\Vinyl::CATEGORY_NB_INVALIDE, $erreurs) ? 'Le no. de catégorie est invalide.<br />' : '' ?>
                    <label for="catNb">Nb catalogue : </label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="catNb" id="catNb" value="<?php isset($vinyl) ? htmlspecialchars($vinyl->catNb()) : '' ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                <?php isset($erreurs) && in_array(\Entity\Vinyl::ANNEE_ORIGINALE_INVALIDE, $erreurs) ? 'L\'année originale est invalide.<br />' : '' ?>
                    <label for="yrOriginal">Année sortie : </label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="yrOriginal" id="yrOriginal" value="<?php isset($vinyl) ? htmlspecialchars($vinyl->yearOriginal()) : '' ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                <?php isset($erreurs) && in_array(\Entity\Vinyl::ANNEE_EDITION_INVALIDE, $erreurs) ? 'L\'année d\'édition est invalide.<br />' : '' ?>
                    <label for="yrEdition">Année édition : </label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="yrEdition" id="yrEdition" value="<?php isset($vinyl) ? htmlspecialchars($vinyl->yearEdition()) : '' ?>">
                </div>
            </div>
            <div class="form-row offset-md-3">
                <button type="submit" name="ajouter" class="btn btn-dark my-1">Valider</button>
            </div>

        </form>
    </div>
</div>