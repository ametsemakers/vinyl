<?php
namespace Model;

use \VinFram\Manager;
use \Entity\Song;

abstract class SongManager extends Manager
{
    /**
     * Méthode retournant une liste de vinyles demandée
     * @param $debut int Le premier vinyle à sélectionner
     * @param $limite int Le nombre de vinyles à sélectionner
     * @return array La liste des vinyles. Chaque entrée est une instance de Vinyl.
     */
    abstract public function getList($debut = -1, $limite = -1);

    /**
     * Méthode retournant un vinyle précise.
     * @param $id int L'identifiant du vinyle à récupérer
     * @return Vinyl Le vinyle demandé
     */
    abstract function getUnique($id);

    /**
     * Méthode retournant les chansons d'un vinyl spécifique.
     * @param $id int L'identifiant du vinyle contenant les chansons.
     * @return Song Le(s) chanson(s) demandéés.
     */
    abstract function getSongsFromAlbum($id);

    /**
     * Méthode permettant d'ajouter un chanson.
     * @param $song Le chanson à ajouter
     * @param $idVinyl Le vinyl qui contient le chanson
     * @return void
     */
    abstract protected function addSong(Song $song);

    /**
     * Méthode permettant d'enregistrer un chanson.
     * @param $song Le chanson à enregistrer
     * @see self::addSong()
     * @see self::updateSong()
     * @return void
     */
    public function save(Song $song)
    {
        if ($song->isValid())
        {
            $song->isNew() ? $this->addSong($song) : $this->updateSong($song);
        }
        else
        {
            throw new \RuntimeException('Le chanson doit être validé pour être enregistré');
        }
    }

    /**
     * Méthode permettant de supprimer un chanson.
     * @param $id L'identifiant du chanson à supprimer
     * @return void
     */
    abstract public function deleteSong($id);

    /**
     * Méthode permettant de modifiér les données d'un chanson.
     * @param $song L'identifiant du chanson à modifier
     * @return void
     */
    abstract protected function updateSong(Song $song);

    /**
     * Méthode permettant de supprimer toutes les chansons liées à un vinyle.
     * @param $vinyl L'identifiant du vinyle dont les chansons doivent être supprimés
     * @return void
     */
    abstract public function deleteFromVinyl($vinyl);

    /**
     * Méthode permettant de chercher une chanson par mot clé
     * @param $query Le mot clé
     * @return array la liste des chansons
     */
    abstract public function searchSong($query, $limit, $offset);

    /**
     * Méthode qui retourne le nombre de la dernière requête.
     * @return int
     */
    abstract public function countSearchResults();
}