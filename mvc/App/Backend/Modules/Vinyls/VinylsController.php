<?php
namespace App\Backend\Modules\Vinyls;

use \VinFram\BackController;
use \VinFram\HttpRequest;
use \Entity\Vinyl;
use \Entity\Song;

class VinylsController extends BackController
{
    public function executeIndex(HTTPRequest $request)
    {
        $this->page->addVar('title', 'Gestion des vinyles');

        $manager = $this->managers->getManagerOf('Vinyl');

        $this->page->addVar('listVinyls', $manager->getAll());
        $this->page->addVar('count', $manager->count());
    }

    public function executeInsertVinyl(HTTPRequest $request)
    {
        if ($request->postExists('artist'))
        {
            $this->processForm($request);
        }

        $this->page->addVar('title', 'Ajoutez un vinyle');
    }

    public function executeUpdateVinyl(HTTPRequest $request)
    {
        if ($request->postExists('artist'))
        {
            $this->processForm($request);
        }
        else
        {
            $this->page->addVar('vinyl', $this->managers->getManagerOf('Vinyl')->getUnique($request->getData('id')));
        }

        $this->page->addVar('title', 'Modification d\'un vinyle');
    }

    public function executeDeleteVinyl(HTTPRequest $request)
    {
        $idVinyl = $request->getData('id');

        $this->managers->getManagerOf('Vinyl')->deleteVinyl($idVinyl);
        // enchainement pour supprimer les morceaux avec l'album 
        // à décommenter après les tests de l'album 
        // $this->managers->getManagerOf('Song')->deleteFromVinyl('$idVinyl');

        $this->app->user()->setFlash('Le Vinyle a été supprimé.');

        $this->app->httpResponse()->redirect('.');
    }

    public function processForm(HTTPRequest $request)
    {
        $vinyl = new Vinyl([
            'artist' => $request->postData('artist'),
            'titleAlbum' => $request->postData('title'),
            'label' => $request->postData('label'),
            'country' => $request->postData('country'),
            'catNb' => $request->postData('catNb'),
            'yearOriginal' => $request->postData('yrOriginal'),
            'yearEdition' => $request->postData('yrEdition') 
        ]);

        // L'id du vinyle est transmis si on veut le modifier.
        if ($request->postExists('id'))
        {
            $vinyl->setIdVinyl($request->getData('id'));
        }

        if ($vinyl->isValid())
        {
            $this->managers->getManagerOf('Vinyl')->save($vinyl);

            $this->app->user()->setFlash($vinyl->isNew() ? 'Le vinyle a été ajouté.' : 'Le vinyle a été modifié.');

            $this->app->httpResponse()->redirect('.');
        }
        else
        {
            $this->page->addVar('erreurs', $vinyl->erreurs());
        }

        $this->page->addVar('vinyl', $vinyl);
    }

    public function executeShow(HTTPRequest $request)
    {
        $vinyl = $this->managers->getManagerOf('Vinyl')->getUnique($request->getData('id'));
        $songs = $this->managers->getManagerOf('Song')->getSongsFromAlbum($request->getData('id'));

        if (empty($vinyl) || empty($songs))
        {
            $this->app->user()->setFlash('La référence demandée est inconnue ou vide.');

            $this->app->httpResponse()->redirect('.');
        }

        $this->page->addVar('vinyl', $vinyl);
        $this->page->addVar('songs', $songs);
    }

    public function executeShowVinylsFromArtist(HTTPRequest $request)
    {
        $manager = $this->managers->getManagerOf('Vinyl');

        $artist = $request->getData('artist');
        if (strstr($artist, '-'))
        {
            $artist = str_replace('-',' ',$artist);
        }

        $listVinyls = $manager->getAlbumsFromArtist($artist);

        $this->page->addVar('listVinyls', $listVinyls);
    }

    public function executeShowFromYear(HTTPRequest $request)
    {
        $manager = $this->managers->getManagerOf('Vinyl');

        $listVinyls = $manager->getFromYear($request->getData('year'));

        $this->page->addVar('listVinyls', $listVinyls);
    }

    public function executeShowFromYearEdition(HTTPRequest $request)
    {
        $manager = $this->managers->getManagerOf('Vinyl');

        $listVinyls = $manager->getFromYearEdition($request->getData('year'));

        $this->page->addVar('listVinyls', $listVinyls);
    }

    public function redirectToSongs(HTTPRequest $request)
    {
        
    }
}
