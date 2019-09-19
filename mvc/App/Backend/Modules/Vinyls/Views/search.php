<div class="row mt-5">
    <div class="col col-md-12">
        <?php if ($user->hasFlash()) echo '<p style="text-align: center;">', $user->getFlash(), '</p>'; ?>
    </div>
</div>

<?php
if ($listVinyls != null)
{
?>   
    <div class="row">
        <div class="col-md-12 text-center">
            <h3><?php echo $nbVinyls; ?> résultats pour '<?php echo $query; ?>' dans les vinyles :</h3>
        </div>
    </div>
    <div class="row mt-3">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Artist</th>
                    <th scope="col">Album</th>
                    <th scope="col">Yr Original</th>
                    <th scope="col">Yr Edition</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
        
                <?php
                $i = 1;
                foreach ($listVinyls as $key => $vinyl)
                {
                ?>
                    
                    <tr>
                        <td><a href="/admin/vinyls-from-<?php echo $vinyl->artistRoute(); ?>.html"><?php echo $vinyl->artist(); ?></a></td>
                        <td><a href="/admin/vinyl-<?php echo $vinyl->idVinyl(); ?>.html"><?php echo $vinyl->titleAlbum(); ?></a></td>
                        <td><a href="/admin/vinyls-recorded-in-<?php echo $vinyl->yearOriginal(); ?>.html"><?php echo $vinyl->yearOriginal(); ?></a></td>
                        <td><a href="/admin/vinyls-issued-in-<?php echo $vinyl->yearEdition(); ?>.html"><?php echo $vinyl->yearEdition(); ?></a></td>
                        <td><a href="/admin/add-song-to-<?php echo $vinyl->idVinyl(); ?>.html"><img src="/images/add.png" alt="add_song" style="height: 20px; width: auto;"></a></td>
                        <td><a href="/admin/edit-vinyl-<?php echo $vinyl->idVinyl(); ?>.html"><img src="/images/edit.png" alt="edit" style="height: 20px; width: auto;"></a></td>
                        <td><a href="/admin/delete-vinyl-<?php echo $vinyl->idVinyl(); ?>.html"><img src="/images/delete.png" alt="delete" style="height: 20px; width: auto;"></a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

    </div>
<?php
}
if ($listSongs != null)
{
?>
    <div class="row">
        <div class="col-md-12 text-center">
            <h3><?php echo $nbSongs; ?> résultats pour '<?php echo $query ?>' dans les chansons :</h3>
        </div>
    </div>
    <div class="row mt-3">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Song</th>
                    <th scope="col">AltInfo</th>
                    <th scope="col">Artist</th>
                    <th scope="col">Feat.</th>
                    <th scope="col">Title Album</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
        
                <?php
                $i = 1;
                foreach ($listSongs as $key => $song)
                {
                ?>
                    
                    <tr>
                        <td><a href="#"><?php echo $song->titleSong(); ?></a></td>
                        <td><a href="#"><?php echo $song->alternateInfo(); ?></a></td>
                        <td><a href="#"><?php echo $song->artist(); ?></a></td>
                        <td><a href="#"><?php echo $song->feat(); ?></a></td>
                        <td><a href="#"><?php echo $song->titleAlbum(); ?></a></td>
                        <td><a href="/admin/edit-song-<?php echo $song->idSong(); ?>.html"><img src="/images/edit.png" alt="edit" style="height: 20px; width: auto;"></a></td>
                        <td><a href="/admin/delete-song-<?php echo $song->idSong(); ?>.html"><img src="/images/delete.png" alt="delete" style="height: 20px; width: auto;"></a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <div class="row">
            <div class="col-md-12">
                <?php echo $links ?>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <a href="/admin/search/<?php echo 'query=' . $query . '/page=' . ($page - 1); ?>.html">Page précédente</a>
                <a href="/admin/search/<?php echo 'query=' . $query . '/page=' . ($page + 1); ?>.html">Page suivante</a>
            </div>
        </div>
    </div>
<?php
}
if ($listVinyls == null && $listSongs == null)
{
?>
    <div class="row">
        <div class="col-md-12 text-center mt-5">
            Aucun résultat trouvé...
        </div>
    </div>
<?php
}
?>