<div class="row">
    <div class="col-md-12 text-center mb-4">
        <?php
            if (isset($song) && !$song->isNew())
            {
        ?>
            <h2>Modifiez un chanson</h2>
        <?php
            }
            else
            {
        ?>
            <h2>Ajoutez un chanson</h2>
        <?php
            }
        ?>
    </div>
    <div class="col-md-12">
        <form action="" method="post">
            <div class="form-row">
                <div class="form-group col-md-2 offset-md-3">
                    <?php isset($erreurs) && in_array(\Entity\Song::COTE_INVALIDE, $erreurs) ? 'Le côté est invalide.<br />' : '' ?>
                    <label for="side">Coté : </label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="side" value="<?php echo (isset($song) ? htmlspecialchars($song->side()) : '') ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2 offset-md-3">
                    <?php isset($erreurs) && in_array(\Entity\Song::POSITION_INVALIDE, $erreurs) ? 'La position est invalide.<br />' : '' ?>
                    <label for="position">Position : </label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="position" id="position" value="<?php echo (isset($song) ? htmlspecialchars($song->position()) : '') ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2 offset-md-3">
                <?php isset($erreurs) && in_array(\Entity\Song::TITRE_CHANSON_INVALIDE, $erreurs) ? 'Le titre est invalide.<br />' : '' ?>
                    <label for="titleSong">Titre : </label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="titleSong" id="titleSong" value="<?php echo (isset($song) ? htmlspecialchars($song->titleSong()) : '') ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2 offset-md-3">
                <?php isset($erreurs) && in_array(\Entity\Song::ALT_INFO_INVALIDE, $erreurs) ? 'L\'info alternative est invalide.<br />' : '' ?>
                    <label for="alternateInfo">Alt info : </label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="alternateInfo" id="alternateInfo" value="<?php echo (isset($song) ? htmlspecialchars($song->alternateInfo()) : '') ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2 offset-md-3">
                <?php isset($erreurs) && in_array(\Entity\Song::AUTEUR_INVALIDE, $erreurs) ? 'L\'artiste est invalide.<br />' : '' ?>
                    <label for="artist">Artiste : </label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="artist" id="artist" value="<?php echo (isset($vinyl) ? htmlspecialchars($vinyl->artist()) : '') ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2 offset-md-3">
                <?php isset($erreurs) && in_array(\Entity\Song::FEATURING_INVALIDE, $erreurs) ? 'l\'artiste invitée est invalide.<br />' : '' ?>
                    <label for="feat">Feat : </label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="feat" id="feat" value="<?php echo (isset($song) ? htmlspecialchars($song->feat()) : '') ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2 offset-md-3">
                <?php isset($erreurs) && in_array(\Entity\Song::TITRE_ALBUM_INVALIDE, $erreurs) ? 'Le titre de l\'album est invalide.<br />' : '' ?>
                    <label for="titleAlbum">Album : </label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="titleAlbum" id="titleAlbum" value="<?php echo (isset($vinyl) ? htmlspecialchars($vinyl->titleAlbum()) : '') ?>">
                </div>
            </div>
            <input type="hidden" name="idVinyl" value="<?php echo (isset($vinyl) ? htmlspecialchars($vinyl->idVinyl()) : '') ?>" />

            <?php
            if (isset($song) && !$song->isNew())
            {
            ?>
            <input type="hidden" name="id" value="<?php echo $song->idSong() ?>" />
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
                    <button type="submit" name="ajouter" class="btn btn-dark my-1">Ajouter</button>
                </div>
                <div class="col-md-2">
                    <a href="/admin/vinyl-<?php echo (isset($song) ? htmlspecialchars($song->idVinyl()) : '') ?>.html" class="btn btn-success my-1">Terminé</a>
                </div>
                <div class="col-md-2">
                    <a href="/admin/" class="btn btn-warning my-1">Annuler</a>
                </div>
            </div>
            <?php
            }
            ?>
        </form>
    </div>
</div>