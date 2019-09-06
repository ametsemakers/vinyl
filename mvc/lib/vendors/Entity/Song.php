<?php
namespace Entity;

use \VinFram\Entity;

class Song extends Entity
{
    protected $idSong;
    protected $side;
    protected $position;
    protected $titleSong;
    protected $alternateInfo;
    protected $artist;
    protected $feat;
    protected $titleAlbum;
    protected $idVinyl;

    const COTE_INVALIDE = 1;
    const POSITION_INVALIDE = 2;
    const TITRE_CHANSON_INVALIDE = 3;
    const ALT_INFO_INVALIDE = 4;
    const AUTEUR_INVALIDE = 5;
    const FEATURING_INVALIDE = 6;
    const TITRE_ALBUM_INVALIDE = 7;
    const ID_VINYLE_INVALIDE = 8;
    

    // public function __construct(array $data)
    // {
    //     $this->hydrate($data);
    // }

    // public function hydrate(array $data)
    // {
    //     foreach ($data as $key => $value)
    //     {
    //         if (strstr($key, '_'))
    //         {
    //             $key = str_replace('_', '', ucwords($key, '_'));
    //         }

    //         $method = 'set'.ucfirst($key);

    //         if (method_exists($this, $method))
    //         {
    //             $this->$method($value);
    //         }
    //     }
    // }

    public function isValid()
    {
        return !(empty($this->side) || empty($this->position) || empty($this->titleSong) || empty($this->artist) || empty($this->titleAlbum) || empty($this->idVinyl));
    }

    public function isNew()
    {
        return empty($this->idSong);
    }

    public function IdSong()
    {
        return $this->idSong;
    }

    public function setIdSong($id)
    {
        $id = (int) $id;

        if ($id > 0)
        {
            $this->idSong = $id;
        }
    }

    public function Side()
    {
        return $this->side;
    }

    public function setSide($side)
    {
        if (is_string($side) || empty($side))
        {
            $this->erreurs[] = self::COTE_INVALIDE;
        }
        $this->side = $side;
    }

    public function Position()
    {
        return $this->position;
    }

    public function setPosition($position)
    {
        $position = (int) $position;

        if (empty($position))
        {
            $this->erreurs[] = self::POSITION_INVALIDE;
        }
        $this->position = $position;
    }

    public function TitleSong()
    {
        return $this->titleSong;
    }

    public function setTitleSong($titleSong)
    {
        if (is_string($titleSong) || empty($titleSong))
        {
            $this->erreurs[] = self::TITRE_CHANSON_INVALIDE;
        }
        $this->titleSong = $titleSong;
    }

    public function AlternateInfo()
    {
        return $this->alternateInfo;
    }

    public function setAlternateInfo($alternateInfo)
    {
        if (is_string($alternateInfo) || empty($alternateInfo))
        {
            $this->erreurs[] = self::ALT_INFO_INVALIDE;
        }
        $this->alternateInfo = $alternateInfo;
    }

    public function Artist()
    {
        return $this->artist;
    }

    public function setArtist($artist)
    {
        if (is_string($artist) || empty($artist))
        {
            $this->erreurs[] = self::AUTEUR_INVALIDE;
        }
        $this->artist = $artist;
    }

    public function Feat()
    {
        return $this->feat;
    }

    public function setFeat($feat)
    {
        if (is_string($feat) || empty($feat))
        {
            $this->erreurs[] = self::FEATURING_INVALIDE;
        }
        $this->feat = $feat;
    }

    public function TitleAlbum()
    {
        return $this->titleAlbum;
    }

    public function setTitleAlbum($titleAlbum)
    {
        if (is_string($titleAlbum) || empty($titleAlbum))
        {
            $this->erreurs[] = self::TITRE_ALBUM_INVALIDE;
        }
        $this->titleAlbum = $titleAlbum;
    }

    public function IdVinyl()
    {
        return $this->idVinyl;
    }

    public function setIdVinyl($idVinyl)
    {
        $idVinyl = (int) $idVinyl;

        if (empty($idVinyl))
        {
            $this->erreurs[] = self::ID_VINYLE_INVALIDE;
        }
        $this->idVinyl = $idVinyl;
    }

    public function songTitleRoute()
    {
        if (strstr($this->titleSong, ' '))
        {
            $edit = str_replace(' ','-',$this->titleSong);
        }
        return $this->titleSong;
    }
}