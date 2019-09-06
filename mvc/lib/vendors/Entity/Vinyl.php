<?php
namespace Entity;

use \VinFram\Entity;

class Vinyl extends Entity
{
    protected $idVinyl;
    protected $artist;
    protected $titleAlbum;
    protected $label;
    protected $country;
    protected $catNb;
    protected $yearOriginal;
    protected $yearEdition;

    const AUTEUR_INVALIDE = 1;
    const TITRE_ALBUM_INVALIDE = 2;
    const LABEL_INVALIDE = 3;
    const PAYS_INVALIDE = 4;
    const CATEGORY_NB_INVALIDE = 5;
    const ANNEE_ORIGINALE_INVALIDE = 6;
    const ANNEE_EDITION_INVALIDE = 7;

    //public function __construct() //arrar $data
    //{
        //$this->hydrate($data);
    //}

    //public static function build(array $data)
    //{
    //    $obj = new static;
    //    $obj->hydrate($data);
    //    return $obj;
    //}

    //public function hydrate(array $data)
    //{
    //    foreach ($data as $key => $value)
    //    {
            /// enlève les underscores des noms de colonnes et met les premières caractères suivantes en majescule
            ///if (strstr($key, '_'))
            ///{
            ///    $key = str_replace('_','',ucwords($key, '_'));
            ///}
            // récupère le nom du setteur
    //        $method = 'set'.ucfirst($key);

    //        if (method_exists($this, $method))
    //        {
                // appelle le setteur
    //            $this->$method($value);
    //        }
    //    }
    //}

    public function isValid()
    {
        return !(empty($this->artist) || empty($this->titleAlbum) || empty($this->label) || empty($this->country) || empty($this->catNb) || empty($this->yearOriginal) || empty($this->yearEdition));
    }

    public function isNew()
    {
        return empty($this->idVinyl);
    }

    public function idVinyl()
    {
        return $this->idVinyl;
    }

    public function setIdVinyl($id)
    {
        $id = (int) $id;
    
        if ($id > 0)
        {
            $this->idVinyl = $id;
        }
    }

    public function artist()
    {
        return $this->artist;
    }

    public function setArtist($artist)
    {
        if (!is_string($artist) || empty($artist))
        {
            $this->erreurs[] = self::AUTEUR_INVALIDE;
        }
        $this->artist = $artist;
    }

    public function titleAlbum()
    {
        return $this->titleAlbum;
    }

    public function setTitleAlbum($titleAlbum)
    {
        if (!is_string($titleAlbum) || empty($titleAlbum))
        {
            $this->erreurs[] = self::TITRE_ALBUM_INVALIDE;
        }
        $this->titleAlbum = $titleAlbum;
    }

    public function label()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        if (!is_string($label) || empty($label))
        {
            $this->erreurs[] = self::LABEL_INVALIDE;
        }
        $this->label = $label;
    }

    public function country()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        if (!is_string($country) || empty($country))
        {
            $this->erreurs[] = self::PAYS_INVALIDE;
        }
        $this->country = $country;
    }

    public function catNb()
    {
        return $this->catNb;
    }

    public function setCatNb($catNb)
    {
        if (!is_string($catNb) || empty($catNb))
        {
            $this->erreurs[] = self::CATEGORY_NB_INVALIDE;
        }
        $this->catNb = $catNb;
    }

    public function yearOriginal()
    {
        return $this->yearOriginal;
    }

    public function setYearOriginal($yearOriginal)
    {
        $yearOriginal = (int) $yearOriginal;

        if (!is_int($yearOriginal) || empty($yearOriginal))
        {
            $this->erreurs[] = self::ANNEE_ORIGINALE_INVALIDE;
        }
        $this->yearOriginal = $yearOriginal;
    }

    public function yearEdition()
    {
        return $this->yearEdition;
    }

    public function setYearEdition($yearEdition)
    {
        $yearEdition = (int) $yearEdition;

        if (!is_int($yearEdition) || empty($yearEdition))
        {
            $this->erreurs[] = self::ANNEE_EDITION_INVALIDE;
        }
        $this->yearEdition = $yearEdition;
    }

    public function artistRoute()
    {
        // remplace les éspaces des noms avec une tiré
            if (strstr($this->artist, ' '))
            {
                $edit = str_replace(' ','-',$this->artist);
                return $edit;
            }
            return $this->artist;
    }

    public function imageRoute()
    {
        $titleAlbum = $this->titleAlbum;

        // Remplace les '#' avec '/'
        if (strstr($titleAlbum, '/'))
        {
            $titleAlbum = str_replace('/','§',$titleAlbum);      
        }
        // Remplace les '_' avec '.'
        if (strstr($titleAlbum, '.'))
        {
            $titleAlbum = str_replace('.','_',$titleAlbum);
        }
        // Remplace les '=' avec ':'
        if (strstr($this->titleAlbum, ':'))
        {
            $titleAlbum = str_replace(':','=',$titleAlbum);
        }
        return $this->idVinyl . ' - ' . $titleAlbum;

    }
}