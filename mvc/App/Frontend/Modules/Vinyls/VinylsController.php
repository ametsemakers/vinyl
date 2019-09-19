<?php
namespace App\Frontend\Modules\Vinyls;

use \VinFram\BackController;
use \VinFram\HTTPRequest;
use \VinFram\Paginator;
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
        $page = $request->getData('page');

        $manager = $this->managers->getManagerOf('Vinyl');

        $limit = 20;

        $offset = ($page - 1) * $limit;

        $listVinyls = $manager->getAll($limit, $offset);

        $NbVinyls = $manager->countSearchResults();

        $path = "/tous-les-vinyles/page=";
            
        $paginator = new Paginator($page, $limit, $NbVinyls);

        $this->page->addVar('listVinyls', $listVinyls);
        $this->page->addVar('links', $paginator->getHtml($path));
    }

    public function executeShowVinylsFromArtist(HTTPRequest $request)
    {
        $manager = $this->managers->getManagerOf('Vinyl');
        
        $dataUrl = $request->getData('page');

        $page = str_replace('=', '', (strpbrk( (strstr($dataUrl, '/')), '=')));

        $artist = strstr($dataUrl, '/', true);

        if (strstr($artist, '-'))
        {
            $artist = str_replace('-',' ',$artist);
        }

        $limit = 8;

        $offset = ($page - 1) * $limit;
        
        $listVinyls = $manager->getAlbumsFromArtist($artist, $limit, $offset);

        $NbVinyls = $manager->countSearchResults();

        $path = "/vinyles-de-".$artist."/page=";
            
        $paginator = new Paginator($page, $limit, $NbVinyls);
        
        $this->page->addVar('listVinyls', $listVinyls);
        $this->page->addVar('links', $paginator->getHtml($path));
    }

    public function executeShowFromYear(HTTPRequest $request)
    {
        $manager = $this->managers->getManagerOf('Vinyl');

        $dataUrl = $request->getData('page');

        $dataUrlBackup = $dataUrl;

        if (strlen($dataUrl) <= 5)
        {
            $page = $dataUrl;

            $year = strstr($dataUrlBackup, '/', true);
        }
        else
        {
            $page = str_replace('=', '', (strpbrk( (strstr($dataUrl, '/')), '=')));

            $year = strstr($dataUrl, '/', true);
        }

        $limit = 4;

        $offset = ($page - 1) * $limit;
        
        $listVinyls = $manager->getFromYear($year, $limit, $offset);

        $nbVinyls = $manager->countSearchResults();

        $path = "/vinyles-par-annee-".$year."/page=";
            
        $paginator = new Paginator($page, $limit, $nbVinyls);
        
        $this->page->addVar('listVinyls', $listVinyls);
        $this->page->addVar('links', $paginator->getHtml($path));
        $this->page->addVar('nbVinyls', $nbVinyls);

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