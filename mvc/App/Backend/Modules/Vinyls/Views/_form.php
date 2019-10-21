<div class="row">
    <div class="col-md-12 text-center mb-4">
        <?php
            if (isset($vinyl) && !$vinyl->isNew())
            {
        ?>
            <h2>Modifier un vinyl</h2>
        <?php
            }
            else
            {
        ?>
            <h2>Ajouter un vinyl</h2>
        <?php
            }
        ?>
    </div>
    <div class="col-md-12">
        <form action="" method="post">
            <div class="form-row">
                <div class="form-group col-md-2 offset-md-3">
                    <?php isset($erreurs) && in_array(\Entity\Vinyl::AUTEUR_INVALIDE, $erreurs) ? 'L\'artiste est invalide.<br />' : '' ?>
                    <label for="artist">Artiste : </label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="artist" value="<?php echo (isset($vinyl) ? htmlspecialchars($vinyl->artist()) : '') ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2 offset-md-3">
                    <?php isset($erreurs) && in_array(\Entity\Vinyl::TITRE_ALBUM_INVALIDE, $erreurs) ? 'Le titre est invalide.<br />' : '' ?>
                    <label for="title">Titre : </label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="title" id="title" value="<?php echo (isset($vinyl) ? htmlspecialchars($vinyl->titleAlbum()) : '') ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2 offset-md-3">
                <?php isset($erreurs) && in_array(\Entity\Vinyl::LABEL_INVALIDE, $erreurs) ? 'Le label est invalide.<br />' : '' ?>
                    <label for="label">Label : </label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="label" id="label" value="<?php echo (isset($vinyl) ? htmlspecialchars($vinyl->label()) : '') ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2 offset-md-3">
                <?php isset($erreurs) && in_array(\Entity\Vinyl::PAYS_INVALIDE, $erreurs) ? 'Le pays est invalide.<br />' : '' ?>
                    <label for="country">Pays édition : </label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="country" id="country" value="<?php echo (isset($vinyl) ? htmlspecialchars($vinyl->country()) : '') ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2 offset-md-3">
                <?php isset($erreurs) && in_array(\Entity\Vinyl::CATEGORY_NB_INVALIDE, $erreurs) ? 'Le no. de catégorie est invalide.<br />' : '' ?>
                    <label for="catNb">Nb catalogue : </label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="catNb" id="catNb" value="<?php echo (isset($vinyl) ? htmlspecialchars($vinyl->catNb()) : '') ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2 offset-md-3">
                <?php isset($erreurs) && in_array(\Entity\Vinyl::ANNEE_ORIGINALE_INVALIDE, $erreurs) ? 'L\'année originale est invalide.<br />' : '' ?>
                    <label for="yrOriginal">Année sortie : </label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="yrOriginal" id="yrOriginal" value="<?php echo (isset($vinyl) ? htmlspecialchars($vinyl->yearOriginal()) : '') ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2 offset-md-3">
                <?php isset($erreurs) && in_array(\Entity\Vinyl::ANNEE_EDITION_INVALIDE, $erreurs) ? 'L\'année d\'édition est invalide.<br />' : '' ?>
                    <label for="yrEdition">Année édition : </label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="yrEdition" id="yrEdition" value="<?php echo (isset($vinyl) ? htmlspecialchars($vinyl->yearEdition()) : '') ?>">
                </div>
            </div>

            <?php
            if (isset($vinyl) && !$vinyl->isNew())
            {
            ?>
            <input type="hidden" name="id" value="<?php echo $vinyl->idVinyl() ?>" />
            <div class="form-row">
                <div class="col-md-2 offset-md-3">
                    <button type="submit" name="modifier" class="btn btn-dark my-1">Modifier</button>
                </div>
                <div class="col-md-2 offset-md-3">
                    <a href="/admin/" class="btn btn-warning my-1">Annuler</a>
                </div>
            </div>
            <?php
            }
            else
            {
            ?> 
            <div class="form-row">
                <div class="col-md-2 offset-md-3">
                    <button type="submit" name="ajouter" class="btn btn-dark my-1">Enregistrer</button>
                </div>
                <div class="col-md-2 offset-md-3">
                    <a href="/admin/page=1.html" class="btn btn-warning my-1">Annuler</a>
                </div>
            </div>
            <?php
            }
            ?>
        </form>
        <div class="col-md-12 text-center text-white bg-dark mt-4">
            <small>
                Pendant l'enregistrement de l'image n'oubliez pas de remplacer les '.' par '_', ':' par '=' et '/' par '§'.
            </small>
        </div>
    </div>
</div>