<?php
namespace App\Frontend\Modules\Vinyls;

use \VinFram\BackController;
use \VinFram\HTTPRequest;
use \Entity\Vinyl;
use \Entity\Song;

class VinylsController extends BackController
{
    public function executeIndex(HTTPRequest $request)
    {
        $nombreVinyls = $this->app->config()->get('nombre_vinyls');
        
        // On ajoute une définition pour le titre.
        $this->page->addVar('title', 'Liste des '.$nombreVinyls.' dernières vinyles');
    
        // On récupère le manager des vinyles.
        $manager = $this->managers->getManagerOf('Vinyl');

        $listVinyls = $manager->getList(0, $nombreVinyls);

        // ... //

        // on ajoute la variable $listVinyls à la vue.
        $this->page->addVar('listVinyls', $listVinyls);
    }

    public function executeShow(HTTPRequest $request)
    {
        $vinyl = $this->managers->getManagerOf('Vinyl')->getUnique($request->getData('id'));
        $songs = $this->managers->getManagerOf('Song')->getSongsFromAlbum($request->getData('id'));

        if (empty($vinyl) || empty($songs))
        {
            $this->app->httpResponse()->redirect404();
        }

        $this->page->addVar('vinyl', $vinyl);
        $this->page->addVar('songs', $songs);
    }

    public function executeShowAllVinyls(HTTPRequest $request)
    { 
        // On récupère le manager des vinyles.
        $manager = $this->managers->getManagerOf('Vinyl');

        $listVinyls = $manager->getAll();

        // on ajoute la variable $listVinyls à la vue.
        $this->page->addVar('listVinyls', $listVinyls);
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

    public function executeInsertVinyl(HTTPRequest $request)
    {
        $this->page->addVar('title', 'Ajout d\'un vinyle');

        if ($request->postExists('artist'))
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
            // $vinyl->hydrate([
            //     'artist' => $request->postData('artist'),
            //     'titleAlbum' => $request->postData('title'),
            //     'label' => $request->postData('label'),
            //     'country' => $request->postData('country'),
            //     'catNb' => $request->postData('catNb'),
            //     'yearOriginal' => $request->postData('yrOriginal'),
            //     'yearEdition' => $request->postData('yrEdition')
            // ]);
            //var_dump($request->postData('artist'));
            //exit;
            if ($vinyl->isValid())
            {
                $this->managers->getManagerOf('Vinyl')->save($vinyl);

                $this->app->user()->setFlash('Le vinyle à bien été ajouté');

                $this->app->httpResponse()->redirect('/');
            }
            else
            {
                $this->page->addVar('erreurs', $vinyl->erreurs());
            }

            $this->page->addVar('vinyl', $vinyl);
        }
    }

    public function executeUpdateVinyl(HTTPRequest $request)
    {
        if ($request->postExist('artist'))
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

        $this->managers->getManagerOf('Vinyl')->delete($idVinyl);
        // enchainement pour supprimer les morceaux avec l'album 
        // à décommenter après les tests de l'album 
        //$this->managers->getManagerOf('Song')->deleteFromVinyl($idVinyl);

        $this->app->user()->setFlash('Le vinyl a été supprimé.');

        $this->app->httpResponse()->redirect('.');
    }
}