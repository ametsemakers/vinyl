<div class="col col-md-12">
    <div class="card mb-3 mx-auto" style="max-width: 900px;">
        <div class="row no-gutters">
            <div class="col-md-4 text-center">
                <img src="/images/<?php echo $vinyl->imageRoute(); ?>.jpeg" class="card-img" alt="<?php echo $vinyl->titleAlbum(); ?>">
                <h5 class="card-title font-weight-bold mb-2"><a href="vinyles-de-<?php echo $vinyl->artistRoute(); ?>.html"><?php echo $vinyl->artist(); ?></a></h5>
                <h5 class="card-title mb-2" style="min-height: 3rem;"><a href="vinyle-<?php echo $vinyl->idVinyl(); ?>"><?php echo $vinyl->titleAlbum(); ?></a></h5>
                <div class="row text-left">
                    <div class="col-md-5">
                        <span class="card-title mb-1">Label : </span>
                    </div>
                    <div class="col-md-7">
                    <span class="card-title mb-1"><a href="#"><?php echo $vinyl->label(); ?></a><span>
                    </div>
                </div>
                <div class="row text-left">
                    <div class="col-md-5">
                        <span class="card-title mb-1">Pays édition : </span>
                    </div>
                    <div class="col-md-7">
                    <span class="card-title mb-1"><a href="#"><?php echo $vinyl->country(); ?></a><span>
                    </div>
                </div>
                <div class="row text-left">
                    <div class="col-md-5">
                        <span class="card-title mb-1">No. catalogue : </span>
                    </div>
                    <div class="col-md-7">
                    <span class="card-title mb-1"><a href="#"><?php echo $vinyl->catNb(); ?></a><span>
                    </div>
                </div>
                <div class="row text-left">
                    <div class="col-md-5">
                        <span class="card-title mb-1">Année sortie : </span>
                    </div>
                    <div class="col-md-7">
                    <span class="card-title mb-1"><a href="vinyles-de-l'annee-<?php echo $vinyl->yearOriginal(); ?>.html"><?php echo $vinyl->yearOriginal(); ?></a><span>
                    </div>
                </div>
                <div class="row text-left">
                    <div class="col-md-5">
                        <span class="card-title mb-1">Année édition : </span>
                    </div>
                    <div class="col-md-7">
                        <span class="card-title mb-1"><a href="#"><?php echo $vinyl->yearEdition(); ?></a><span>
                    </div>
                </div>
                <?php if ($user->isAuthenticated()) { ?>
                    <div class="row text-left">
                        <div class="col-md-6">
                            <span class="card-title mb-1"><a href="admin/update-vinyl-<?php echo $vinyl->idVinyl(); ?>.html">Modifier</a></span>
                        </div>
                        <div class="col-md-6">
                            <span class="card-title mb-1"><a href="admin/delete-vinyl-<?php echo $vinyl->idVinyl(); ?>.html">Supprimer</a><span>
                        </div>
                    </div>  
                <?php } ?>
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <?php
                        foreach ($songs as $key => $song)
                        {
                        ?>
                            <div class="row">
                                <div class="col-md-1">
                                    <?php echo $song->position(); ?>
                                </div>
                                <div class="col-md-1">
                                    <?php echo $song->side(); ?>
                                </div>
                                <div class="col-md-6">
                                    <?php echo $song->titleSong(); ?>
                                </div>
                                <div class="col-md-1">
                                    <?php echo $song->alternateInfo(); ?>
                                </div>
                                <div class="col-md-1">
                                    <?php echo $song->feat(); ?>
                                </div>
                                <?php if ($user->isAuthenticated()) { ?>
                                    <div class="col-md-2">
                                        <a href="#">Modifier</a>
                                    </div>
                                <?php } ?>
                            </div>
                        

                        <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    
    
    
    
        
    </div>
</div>