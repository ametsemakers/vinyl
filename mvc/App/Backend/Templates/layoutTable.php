<div class="row mt-5">
    <div class="col col-md-12">
        <?php if ($user->hasFlash()) echo '<p style="text-align: center;">', $user->getFlash(), '</p>'; ?>
    </div>
</div>

<div class="row">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
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
                    <th scope="row"><?php echo $counter; $counter++; ?></th>
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