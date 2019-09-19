<?php
namespace Model;

use \Entity\Vinyl;

class VinylManagerPDO extends VinylManager
{
    protected function addVinyl(Vinyl $vinyl)
    {
        $request = $this->dao->prepare('INSERT INTO vinyl(artist, titleAlbum, label, country, catNb, yearOriginal, yearEdition) VALUES (:artist, :titleAlbum, :label, :country, :catNb, :yearOriginal, :yearEdition)');
    
        $request->bindValue(':artist', $vinyl->artist());
        $request->bindValue(':titleAlbum', $vinyl->titleAlbum());
        $request->bindValue(':label', $vinyl->label());
        $request->bindValue(':country', $vinyl->country());
        $request->bindValue(':catNb', $vinyl->catNb());
        $request->bindValue(':yearOriginal', $vinyl->yearOriginal());
        $request->bindValue(':yearEdition', $vinyl->yearEdition());

        $request->execute();
    }

    public function deleteVinyl($id)
    {
        $this->dao->exec('DELETE FROM vinyl WHERE idVinyl = '.(int) $id);
    }

    protected function updateVinyl(Vinyl $vinyl)
    {
        $request = $this->dao->prepare('UPDATE vinyl SET artist = :artist, titleAlbum = :titleAlbum, label = :label, country = :country, catNb = :catNb, yearOriginal = :yearOriginal, yearEdition = :yearEdition WHERE idVinyl = :id');

        $request->bindValue(':artist', $vinyl->artist());
        $request->bindValue(':titleAlbum', $vinyl->titleAlbum());
        $request->bindValue(':label', $vinyl->label());
        $request->bindValue(':country', $vinyl->country());
        $request->bindValue(':catNb', $vinyl->catNb());
        $request->bindValue(':yearOriginal', $vinyl->yearOriginal());
        $request->bindValue(':yearEdition', $vinyl->yearEdition());
        $request->bindValue(':id', $vinyl->idVinyl(), \PDO::PARAM_INT);

        $request->execute();
    }

    public function getList($debut = -1, $limite = -1)
    {
        $sql = 'SELECT idVinyl, artist, titleAlbum, label, country, catNb, yearOriginal, yearEdition FROM vinyl ORDER BY idVinyl DESC, artist, yearOriginal';

        if ($debut != -1 || $limite != -1)
        {
            $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
        }
        $array = array(array());
        $requete = $this->dao->query($sql);
        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Vinyl');

        $listVinyl = $requete->fetchAll();

        $requete->closeCursor();
        
        return $listVinyl;
    }

    public function count()
    {
        return $this->dao->query('SELECT COUNT(*) FROM vinyl')->fetchColumn();
    }

    public function getUnique($id)
    {
        $requete = $this->dao->prepare('SELECT idVinyl, artist, titleAlbum, label, country, catNb, yearOriginal, yearEdition FROM vinyl WHERE idVinyl = :id');

        $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $requete->execute();

        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Vinyl');

        if ($vinyl = $requete->fetch())
        {
            return $vinyl;
        }
        return null;
    }

    public function getAll($limit, $offset)
    {
        $requete = $this->dao->prepare('SELECT SQL_CALC_FOUND_ROWS idVinyl, artist, titleAlbum, label, country, catNb, yearOriginal, yearEdition FROM vinyl ORDER BY artist, yearOriginal LIMIT :maxResults OFFSET :startFrom');

        $requete->bindValue(':maxResults', $limit, \PDO::PARAM_INT);
        $requete->bindValue(':startFrom', $offset, \PDO::PARAM_INT);
        $requete->execute();
        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Vinyl');

        $listVinyl = $requete->fetchAll();

        $requete->closeCursor();
        
        return $listVinyl;
    }

    public function getAlbumsFromArtist($artist, $limit, $offset)
    {
        $requete = $this->dao->prepare('SELECT SQL_CALC_FOUND_ROWS idVinyl, artist, titleAlbum, label, country, catNb, yearOriginal, yearEdition FROM vinyl WHERE artist = :artist ORDER BY artist, yearOriginal LIMIT :maxResults OFFSET :startFrom');

        $requete->bindValue(':artist', $artist, \PDO::PARAM_STR);
        $requete->bindValue(':maxResults', $limit, \PDO::PARAM_INT);
        $requete->bindValue(':startFrom', $offset, \PDO::PARAM_INT);
        $requete->execute();

        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Vinyl');

        $listVinyl = $requete->fetchAll();
        //var_dump($artist);
        //exit();
        $requete->closeCursor();
        
        return $listVinyl;
    }

    public function getFromYear($year, $limit, $offset)
    {
        $requete = $this->dao->prepare('SELECT SQL_CALC_FOUND_ROWS idVinyl, artist, titleAlbum, label, country, catNb, yearOriginal, yearEdition FROM vinyl WHERE yearOriginal = :yearOri ORDER BY artist, yearOriginal LIMIT :maxResults OFFSET :startFrom');
        
        $requete->bindValue(':yearOri', $year, \PDO::PARAM_STR);
        $requete->bindValue(':maxResults', $limit, \PDO::PARAM_INT);
        $requete->bindValue(':startFrom', $offset, \PDO::PARAM_INT);
        $requete->execute();

        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Vinyl');

        $listVinyl = $requete->fetchAll();
        
        $requete->closeCursor();
        
        return $listVinyl;
    }

    public function getFromYearEdition($year, $limit, $offset)
    {
        $requete = $this->dao->prepare('SELECT SQL_CALC_FOUND_ROWS idVinyl, artist, titleAlbum, label, country, catNb, yearOriginal, yearEdition FROM vinyl WHERE yearEdition = :yearEdi ORDER BY artist, yearEdition LIMIT :maxResults OFFSET :startFrom');

        $requete->bindValue(':yearEdi', $year, \PDO::PARAM_STR);
        $requete->bindValue(':maxResults', $limit, \PDO::PARAM_INT);
        $requete->bindValue(':startFrom', $offset, \PDO::PARAM_INT);
        $requete->execute();

        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Vinyl');

        $listVinyl = $requete->fetchAll();

        $requete->closeCursor();

        return $listVinyl;
    }

    public function searchVinyl($query, $limit, $offset)
    {
        $requete = $this->dao->prepare('SELECT SQL_CALC_FOUND_ROWS idVinyl, artist, titleAlbum, label, country, catNb, yearOriginal, yearEdition FROM vinyl WHERE artist LIKE :art XOR titleAlbum LIKE :title XOR label LIKE :lab XOR country LIKE :country LIMIT :maxResults OFFSET :startFrom');

        $requete->bindValue(':art', $query, \PDO::PARAM_STR);
        $requete->bindValue(':title', $query, \PDO::PARAM_STR);
        $requete->bindValue(':lab', $query, \PDO::PARAM_STR);
        $requete->bindValue(':country', $query, \PDO::PARAM_STR);
        $requete->bindValue(':maxResults', $limit, \PDO::PARAM_INT);
        $requete->bindValue(':startFrom', $offset, \PDO::PARAM_INT);

        $requete->execute();

        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Vinyl');
        $listVinyl = $requete->fetchAll();
                
        $requete->closeCursor();
                
        return $listVinyl;
    }

    public function countSearchResults()
    {
        $results = $this->dao->query('SELECT FOUND_ROWS()');

        return $results->fetchColumn();
    }
}