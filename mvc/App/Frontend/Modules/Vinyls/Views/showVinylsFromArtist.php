<div class="row">
    
<?php

foreach ($listVinyls as $key => $vinyl)
{
?>
    <div class="col col-md-3 mb-4">
        <div class="card text-center" style="width: 15.5rem;">
            <a href="vinyle-<?php echo $vinyl->idVinyl(); ?>.html"><img src="/images/<?php echo $vinyl->idVinyl().' - '.$vinyl->titleAlbum()?>.jpeg" class="card-img-top mb-2" alt=""></a>
            <h5 class="card-title font-weight-bold mb-2"><a href="vinyles-de-<?php echo $vinyl->artistRoute(); ?>.html"><?php echo $vinyl->artist(); ?></a></h5>
            <h5 class="card-title mb-2" style="min-height: 3rem;"><a href="vinyle-<?php echo $vinyl->idVinyl(); ?>.html"><?php echo $vinyl->titleAlbum(); ?></a></h5>
            <h6 class="card-footer bg-transparent mb-2 text-muted"><a href="vinyles-de-l'annee-<?php echo $vinyl->yearOriginal(); ?>.html"><?php echo $vinyl->yearOriginal(); ?></a><h6>
        </div>
    </div>
<?php
}
?>
</div>