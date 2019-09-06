<div class="row mt-5">    
    <div class="col col-md-12">
        <div class="card mb-3 p-1 mx-auto" >
            <div class="row no-gutters">
                <div class="col-md-4 text-center">
                    <img src="/images/<?php echo $vinyl->imageRoute(); ?>.jpeg" class="card-img" alt="<?php echo $vinyl->titleAlbum(); ?>">
                    <h5 class="card-title font-weight-bold mb-2"><a href="vinyls-from-<?php echo $vinyl->artistRoute(); ?>.html"><?php echo $vinyl->artist(); ?></a></h5>
                    <h5 class="card-title mb-2" style="min-height: 3rem;"><a href="/admin/vinyl-<?php echo $vinyl->idVinyl(); ?>"><?php echo $vinyl->titleAlbum(); ?></a></h5>
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
                        <span class="card-title mb-1"><?php echo $vinyl->catNb(); ?><span>
                        </div>
                    </div>
                    <div class="row text-left">
                        <div class="col-md-5">
                            <span class="card-title mb-1">Année sortie : </span>
                        </div>
                        <div class="col-md-7">
                        <span class="card-title mb-1"><a href="/admin/vinyls-recorded-in-<?php echo $vinyl->yearOriginal(); ?>.html"><?php echo $vinyl->yearOriginal(); ?></a><span>
                        </div>
                    </div>
                    <div class="row text-left">
                        <div class="col-md-5">
                            <span class="card-title mb-1">Année édition : </span>
                        </div>
                        <div class="col-md-7">
                            <span class="card-title mb-1"><a href="/admin/vinyls-issued-in-<?php echo $vinyl->yearEdition(); ?>.html"><?php echo $vinyl->yearEdition(); ?></a><span>
                        </div>
                    </div>
                    <div class="row text-left">
                        <div class="col-md-5">
                            <span class="card-title mb-1">Id : </span>
                        </div>
                        <div class="col-md-7">
                            <span class="card-title mb-1"><?php echo $vinyl->idVinyl(); ?><span>
                        </div>
                    </div>
                    <?php if ($user->isAuthenticated()) { ?>
                        
                        <hr>
                        <div class="row text-left justify-content-between mt-3">
                            <div class="col-md-4">
                                <span class="card-title mb-1"><a href="/admin/update-vinyl-<?php echo $vinyl->idVinyl(); ?>.html" class="btn btn-secondary">Modifier</a></span>
                            </div>
                            <div class="col-md-4">
                                <span class="card-title mb-1"><a href="/admin/delete-vinyl-<?php echo $vinyl->idVinyl(); ?>.html" class="btn btn-danger">Supprimer</a><span>
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
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php echo $song->titleSong(); ?>
                                            </div>
                                            <?php
                                            if ($song->alternateInfo() !== '')
                                            {
                                            ?>
                                                <div class="col-md-12">
                                                    <small>Alt Info : <?php echo $song->alternateInfo(); ?></small>
                                                </div>
                                            <?php
                                            }
                                            if ($song->feat() !== '')
                                            {
                                            ?>
                                                <div class="col-md-12">
                                                    <small>Feat. : <?php echo $song->feat(); ?></small>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>                                   
                                    <?php                                  
                                    if ($user->isAuthenticated()) { ?>
                                        <div class="col-md-1">
                                            <a href="/admin/update-song-<?php echo $song->idSong(); ?>.html"><img src="/images/edit.png" alt="edit" style="height: 20px; width: auto;"></a>
                                        </div>
                                        <div class="col-md-1">
                                            <a href="/admin/delete-song-<?php echo $song->idSong(); ?>.html"><img src="/images/delete.png" alt="edit" style="height: 20px; width: auto;"></a>
                                        </div>
                                    <?php } ?>
                                </div>
                                <hr>
                            

                            <?php
                            }
                        ?>
                        <div class="row justify-content-end">
                            <div class="col-md-2">
                                <a href="/admin/add-song-to-<?php echo $vinyl->idVinyl(); ?>.html"><img src="/images/add.png" alt="add_song" style="height: 20px; width: auto;"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>       
        </div>
    </div>
</div>