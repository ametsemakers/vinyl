<?php
namespace Model;

use \Entity\Song;

class SongManagerPDO extends SongManager
{
    public function getList($debut = -1, $limite = -1)
    {
        $sql = 'SELECT idSong, side, position, titleSong, alternateInfo, artist, feat, titleAlbum, idVinyl FROM song ORDER BY titleSong, artist';

        if ($debut != -1 || $limite != -1)
        {
            $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
        }
        $array = array(array());
        $requete = $this->dao->query($sql);
        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Song');

        $listSongs = $requete->fetchAll();

        $requete->closeCursor();
        
        return $listSongs;
    }

    public function getUnique($id)
    {
        $requete = $this->dao->prepare('SELECT idSong, side, position, titleSong, alternateInfo, artist, feat, titleAlbum, idVinyl FROM song WHERE idSong = :id');
        
        $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $requete->execute();

        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Song');

        if ($song = $requete->fetch())
        {
            return $song;
        }
        return null;
    }

    public function getSongsFromAlbum($id)
    {
        $requete = $this->dao->prepare('SELECT idSong, side, position, titleSong, alternateInfo, artist, feat, titleAlbum, idVinyl FROM song WHERE idVinyl = :id ORDER BY side, position');

        $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $requete->execute();

        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Song');

        $listSongsAlbum = $requete->fetchAll();

        $requete->closeCursor();
        
        return $listSongsAlbum;
    }

    public function addSong(Song $song)
    {
        $request = $this->dao->prepare('INSERT INTO song(side, position, titleSong, alternateInfo, artist, feat, titleAlbum, idVinyl) VALUES (:side, :position, :titleSong, :alternateInfo, :artist, :feat, :titleAlbum, :idVinyl)');
    
        $request->bindValue(':side', $song->side());
        $request->bindValue(':position', $song->position());
        $request->bindValue(':titleSong', $song->titleSong());
        $request->bindValue(':alternateInfo', $song->alternateInfo());
        $request->bindValue(':artist', $song->artist());
        $request->bindValue(':feat', $song->feat());
        $request->bindValue(':titleAlbum', $song->titleAlbum());
        $request->bindValue(':idVinyl', $song->idVinyl());

        $request->execute();
    }

    public function deleteSong($id)
    {
        $this->dao->exec('DELETE FROM song WHERE idSong = '.(int) $id);
    }

    public function updateSong(Song $song)
    {
        $request = $this->dao->prepare('UPDATE song SET side = :side, position = :position, titleSong = :titleSong, alternateInfo = :alternateInfo, artist = :artist, feat = :feat, titleAlbum = :titleAlbum, idVinyl = :idVinyl WHERE idSong = :id');

        $request->bindValue(':side', $song->side());
        $request->bindValue(':position', $song->position());
        $request->bindValue(':titleSong', $song->titleSong());
        $request->bindValue(':alternateInfo', $song->alternateInfo());
        $request->bindValue(':artist', $song->artist());
        $request->bindValue(':feat', $song->feat());
        $request->bindValue(':titleAlbum', $song->titleAlbum());
        $request->bindValue(':idVinyl', $song->idVinyl());
        $request->bindValue(':id', $song->idSong(), \PDO::PARAM_INT);

        $request->execute();
    }

    public function deleteFromVinyl($vinyl)
    {
        $this->dao->exec('DELETE FROM SONG WHERE idVinyl ='.(int) $vinyl);
    }

    public function searchSong($query, $limit, $offset)
    {
        //$requete = $this->dao->prepare('SELECT song.idSong, song.side, song.position, song.titleSong, song.alternateInfo, song.artist, song.feat, song.titleAlbum, vinyl.idVinyl, vinyl.label, vinyl.country FROM song LEFT JOIN vinyl ON song.idvinyl = vinyl.idvinyl  WHERE song.titleSong LIKE :titleSong XOR song.alternateInfo LIKE :altInfo XOR song.feat LIKE :feat XOR song.artist LIKE :art XOR song.titleAlbum LIKE :titleAlbum XOR vinyl.label LIKE :lab XOR vinyl.country LIKE :country');
        $requete = $this->dao->prepare('SELECT SQL_CALC_FOUND_ROWS idSong, side, position, titleSong, alternateInfo, artist, feat, titleAlbum, idVinyl FROM song WHERE titleSong LIKE :titleSong XOR alternateInfo LIKE :altInfo XOR artist LIKE :art XOR feat LIKE :feat XOR titleAlbum LIKE :titleAlbum LIMIT :maxResults OFFSET :startFrom');

        $requete->bindValue(':titleSong', $query, \PDO::PARAM_STR);
        $requete->bindValue(':altInfo', $query, \PDO::PARAM_STR);
        $requete->bindValue(':feat', $query, \PDO::PARAM_STR);
        $requete->bindValue(':art', $query, \PDO::PARAM_STR);
        $requete->bindValue(':titleAlbum', $query, \PDO::PARAM_STR);
        $requete->bindValue(':maxResults', $limit, \PDO::PARAM_INT);
        $requete->bindValue(':startFrom', $offset, \PDO::PARAM_INT);
        
        $requete->execute();

        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Song');
        $listSong = $requete->fetchAll();
                
        $requete->closeCursor();
                
        return $listSong;
    }

    public function count()
    {
        return $this->dao->query('SELECT COUNT(*) FROM song')->fetchColumn();
    }

    public function countSearchResults()
    {
        $results = $this->dao->query('SELECT FOUND_ROWS()');

        return $results->fetchColumn();
    }
}