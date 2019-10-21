<?php
namespace App\Backend\Modules\Vinyls;

use \VinFram\BackController;
use \VinFram\HttpRequest;
use \VinFram\Paginator;
use \Entity\Vinyl;
use \Entity\Song;

class VinylsController extends BackController
{
    public function executeIndex(HTTPRequest $request)
    {        
        $page = $request->getData('page');
        
        $manager = $this->managers->getManagerOf('Vinyl');

        $limit = 12;

        $offset = ($page - 1) * $limit;

        $listVinyls = $manager->getAll($limit, $offset);

        $NbVinyls = $manager->countSearchResults();

        $path = "/admin/page=";
            
        $paginator = new Paginator($page, $limit, $NbVinyls);

        $this->page->addVar('title', 'Gestion des vinyles');
        $this->page->addVar('listVinyls', $listVinyls);
        $this->page->addVar('count', $NbVinyls);
        $this->page->addVar('links', $paginator->getHtml($path));
        $this->page->addVar('counter', $paginator->getCounter());

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

            $this->app->httpResponse()->redirect('/admin/add-song-to-'.$vinyl->idVinyl().'.html');
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

    public function executeSearch(HTTPRequest $request)
    {
        if ($request->postExists('query'))
        {           
            $managerVinyl = $this->managers->getManagerOf('Vinyl');

            $managerSong = $this->managers->getManagerOf('Song');

            $query = htmlspecialchars('%' . trim($request->postData('query')) . '%');

            $page = (!empty($request->postData('page')) ? $request->postData('page') : 1);
            
            $limit = 10;

            $offset = ($page - 1) * $limit;

            $listVinyls = $managerVinyl->searchVinyl($query, $limit, $offset);

            $NbVinyls = $managerSong->countSearchResults();

            $listSongs = $managerSong->searchSong($query, $limit, $offset);
            
            if ($listVinyls == null && $listSongs == null)
            {
                $this->app->user()->setFlash('Le mot recherché ne se trouve pas dans la base de données.');

                $this->app->httpResponse()->redirect('.');
            }
            $query = $request->postData('query');

            $nbSongs = $managerSong->countSearchResults();

            $nbPages = ceil($nbSongs / $limit);

            $path = "/admin/search/query=".$query."/page=";
            
            $paginator = new Paginator($page, $limit, $nbSongs, $nbPages);

            $links = $paginator->getHtml($path);
            
            $this->page->addVar('listVinyls', $listVinyls);
            $this->page->addVar('listSongs', $listSongs);
            $this->page->addVar('query', $query);
            $this->page->addVar('page', $page);
            $this->page->addVar('nbSongs', $nbSongs);
            $this->page->addVar('nbVinyls', $NbVinyls);
            $this->page->addVar('nbPages', $nbPages);
            $this->page->addVar('links', $links);

        }
        else
        {
            $managerVinyl = $this->managers->getManagerOf('Vinyl');

            $managerSong = $this->managers->getManagerOf('Song');

            $dataUrl = $request->getData('page');
            // séparation du mot recherché et le numéro de page contenu dans l'url.
            $page = str_replace('=', '', (strpbrk( (strstr($dataUrl, '/')), '=')));
            
            $query = str_replace('=', '', (strpbrk( (strstr($dataUrl, '/', true)), '=')));
              
            // je garde la valeur de $query pour plus tard
            $queryBackUp = $query;

            $query = htmlspecialchars('%' . trim($query) . '%');

            $limit = 10;

            $offset = ($page - 1) * $limit;

            $listVinyls = $managerVinyl->searchVinyl($query, $limit, $offset);

            $NbVinyls = $managerSong->countSearchResults();

            $listSongs = $managerSong->searchSong($query, $limit, $offset);

            $nbSongs = $managerSong->countSearchResults();
            
            $query = $queryBackUp;
            
            $nbPages = ceil($nbSongs / $limit);

            $path = "/admin/search/query=".$query."/page=";
            
            $paginator = new Paginator($page, $limit, $nbSongs, $nbPages);

            $links = $paginator->getHtml($path);

            $this->page->addVar('listVinyls', $listVinyls);
            $this->page->addVar('listSongs', $listSongs);
            $this->page->addVar('query', $query);
            $this->page->addVar('page', $page);
            $this->page->addVar('nbSongs', $nbSongs);
            $this->page->addVar('nbVinyls', $NbVinyls);
            $this->page->addVar('nbPages', $nbPages);
            $this->page->addVar('links', $links);
        }
    }

    public function redirectToSongs(HTTPRequest $request)
    {
        
    }
}
