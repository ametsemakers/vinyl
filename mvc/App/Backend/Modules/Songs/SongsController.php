<?php
namespace App\Backend\Modules\Songs;

use \VinFram\BackController;
use \VinFram\HTTPRequest;
use \Entity\Vinyl;
use \Entity\Song;

class SongsController extends BackController
{
    public function executeAddSongToVinyl(HTTPRequest $request)
    {
        if ($request->postExists('side'))
        {
            //var_dump($request->getData('idVinyl'));
            //exit;
            $this->processForm($request);
        }

        $idVinyl = $request->getData('idVinyl');
        
        $vinyl = $this->managers->getManagerOf('Vinyl')->getUnique($idVinyl);

        $this->page->addVar('title', 'Ajoutez un chanson');
        $this->page->addVar('vinyl', $vinyl);
    }

    public function executeUpdateSong(HTTPRequest $request)
    {
        if ($request->postExists('side'))
        {
            $this->processForm($request);
        }
        else
        {
            $song = $this->managers->getManagerOf('Song')->getUnique($request->getData('id'));

            $vinyl = $this->managers->getManagerOf('Vinyl')->getUnique($song->idVinyl());

            $this->page->addVar('song', $song);
            $this->page->addVar('vinyl', $vinyl);
        }

        $this->page->addVar('title', 'Modification d\'un chanson');
    }

    public function executeDeleteSong(HTTPRequest $request)
    {
        $idSong = $request->getData('id');
        $idSong = (int) $idSong;
        $song = $this->managers->getManagerOf('Song')->getUnique($idSong);
        
        $vinyl = $this->managers->getManagerOf('Vinyl')->getUnique($song->idVinyl());
        
        $this->managers->getManagerOf('Song')->deleteSong($idSong);

        $this->app->user()->setFlash('Le chanson a été supprimé');

        $this->app->httpResponse()->redirect('/admin/vinyl-'.$vinyl->idVinyl().'.html');
    }

    public function processForm(HTTPRequest $request)
    {
        $song = new Song([
            'side' => $request->postData('side'),
            'position' => $request->postData('position'),
            'titleSong' => $request->postData('titleSong'),
            'alternateInfo' => $request->postData('alternateInfo'),
            'artist' => $request->postData('artist'),
            'feat' => $request->postData('feat'),
            'titleAlbum' => $request->postData('titleAlbum'),
            'idVinyl' => $request->postData('idVinyl')
        ]);

        if ($request->postExists('id'))
        {
            $song->setIdSong($request->getData('id'));
        }

        if ($song->isValid())
        {
            $this->managers->getManagerOf('Song')->save($song);

            $this->app->user()->setFlash($song->isNew() ? 'Le Chanson a été ajouté.' : 'Le chanson a été modifié.');

            if (!$song->isNew())
            {
                $this->app->httpResponse()->redirect('/admin/vinyl-'.$song->idVinyl().'.html');
            }
        }
        else
        {
            $this->page->addVar('erreurs', $song->erreurs());
        }

        $this->page->addVar('song', $song);
    }

    
}