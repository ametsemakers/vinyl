<?php
namespace Model;

use \VinFram\Manager;
use \Entity\Vinyl;

abstract class VinylManager extends Manager
{
    /**
     * Méthode retournant une liste de vinyles demandée
     * @param $debut int Le premier vinyle à sélectionner
     * @param $limite int Le nombre de vinyles à sélectionner
     * @return array La liste des vinyles. Chaque entrée est une instance de Vinyl.
     */
    abstract public function getList($debut = -1, $limite = -1);

    /**
     * Méthode retournant le nombre des vinyles en total.
     * @return int
     */
    abstract public function count();

    /**
     * Méthode retournant un vinyle précise.
     * @param $id int L'identifiant du vinyle à récupérer
     * @return Vinyl Le vinyle demandé
     */
    abstract public function getUnique($id);

    /**
     * Méthode retournant tous les vinyles.
     * @return array La liste des vinyles
     */
    abstract public function getAll();

    /**
     * Méthode retournant tous les vinyles d'une artiste.
     * @param $artist Le nom de l'artiste à récupérer
     * @return array La liste des vinyles
     */
    abstract public function getAlbumsFromArtist($artist);

    /**
     * Méthode retournant tous les vinyles d'une année.
     * @param $year L'année à interroger
     * @return array La liste des vinyles
     */
    abstract public function getFromYear($year);

    /**
     * Méthode retournant les vinyles édités dans une année spécifique.
     * @param $year L'année à interroger
     * @return array La liste des vinyles
     */
    abstract public function getFromYearEdition($year);

    /**
     * Méthode permettant d'ajouter un vinyle.
     * @param $vinyl Le vinyle à ajouter
     * @return void
     */
    abstract protected function addVinyl(Vinyl $vinyl);

    /**
     * Méthode permettant d'enregistrer un vinyle
     * @param $vinyl Le vinyle à enregistrer
     * @see self::addVinyl()
     * @see self::modifyVinyl()
     * @return void
     */
    public function save(Vinyl $vinyl)
    {
        if ($vinyl->isValid())
        {
            $vinyl->isNew() ? $this->addVinyl($vinyl) : $this->updateVinyl($vinyl);
        }
        else
        {
            throw new \RuntimeException('Le vinyle doit être validé pour être enregistré');
        }
    }

    /**
     * Méthode permettant de supprimer un vinyle.
     * @param $id L'identifiant du vinyle à supprimer
     * @return void
     */
    abstract public function deleteVinyl($id);

    /**
     * Méthode permettant de modifiér les données d'un vinyle.
     * @param $vinyl L'identifiant du vinyle à modifier
     * @return void
     */
    abstract protected function updateVinyl(Vinyl $vinyl);
}