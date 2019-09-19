<?php
namespace VinFram;

use \VinFram\BackController;
use \VinFram\HttpRequest;
use \Entity\Vinyl;
use \Entity\Song;

class Paginator
{
    /**
     * Le nombre de page actuel
     * 
     * @var numeric 
     */
    protected $page;

    /**
     * Le nombre des pages à visualiser en totale
     * 
     * @var numeric 
     */
    protected $total;

    /**
     * La requête MYSQL
     * 
     * @var string 
     */
    protected $query;

    /**
     * Le nombre de résultats par page
     * 
     * @var numeric 
     */
    protected $limit;

    public function __construct($page, $limit, $total, $customCss = "")
    {
        $this->setPage($page);
        $this->setLimit($limit);
        $this->setTotal($total);
        $this->setCustomCss($customCss);
    }

    /**
     * Méthode construisant les liens.
     * Les classes sont des classes Twitter Bootstrap.
     * 
     */
    public function getHtml($path = "")
    {
        $next = $this->page + 1;
        $prev = $this->page -1;

        $lastPage = ceil($this->total / $this->limit);

        $paginate = "<nav>";

        // Si la requête envoie plus de résultats que la limite par page
        if ($lastPage > 1)
        {
            $paginate .= "<ul class='pagination ".$this->customCss."'>";
        
            // Si nous sommes sur la première page, le lien "previous" devient non actif.
            if ($this->page > 1)
            {
                $paginate .= "<li class='page-item'><a class='page-link' href='".$path.$prev.".html'>Previous</a></li>";
            }
            else
            {
                $paginate .= "<li class='page-item disabled'><a class='page-link' href='".$path.$prev.".html'>Previous</a></li>";
            }

            // S'il y moins que 6 pages à générer
            if ($lastPage < 6)
            {
                for ($i = 1; $i <= $lastPage; $i++)
                {
                    if ($i == $this->page)
                    {
                        $paginate .= "<li class='page-item active' aria-current='page'><a class='page-link' href='".$path.$i.".html'>".$i."<span class='sr-only'>(current)</span></a></li>";
                    }
                    else
                    {
                        $paginate .= "<li class='page-item'><a class='page-link' href='".$path.$i.".html'>".$i."</a></li>";
                    }
                    
                }
            }
            else
            {
                $spaceBetween = 2;

                if ($this->page < 3)
                {
                    for ($i = 1; $i <= 3; $i++)
                    {
                        if ($i == $this->page)
                        {
                            $paginate .= "<li class='page-item active' aria-current='page'><a class='page-link' href='".$path.$i.".html'>".$i."<span class='sr-only'>(current)</span></a></li>";
                        }
                        else
                        {
                            $paginate .= "<li class='page-item'><a class='page-link' href='".$path.$i.".html'>".$i."</a></li>";
                        }
                    }
                    $paginate .= "<li class='page-item disabled'><span class='page-link'>...</span></li>";

                    $paginate .= "<li class='page-item'><a class='page-link' href='".$path.$lastPage.".html'>".$lastPage."</a></li>";
                }
                else if ($this->page > ($lastPage - 3))
                {
                    $paginate .= "<li class='page-item'><a class='page-link' href='".$path."1.html'>1</a></li>";

                    $paginate .= "<li class='page-item disabled'><span class='page-link'>...</span></li>";

                    if ($this->page == $lastPage)
                    {
                        $paginate .= "<li class='page-item'><a class='page-link' href='".$path.($this->page - 2).".html'>".($this->page - 2)."</a></li>";
                    }
                    $paginate .= "<li class='page-item'><a class='page-link' href='".$path.$prev.".html'>".$prev."</a></li>";
                    $paginate .= "<li class='page-item active' aria-current='page'><a class='page-link' href='".$path.$this->page.".html'>".$this->page."<span class='sr-only'>(current)</span></a></li>";
                    
                    if ($this->page != $lastPage)
                    {
                        $paginate .= "<li class='page-item'><a class='page-link' href='".$path.$next.".html'>".$next."</a></li>";
                    }
                    
                    if ($this->page == ($lastPage - 2))
                    {
                        $paginate .= "<li class='page-item'><a class='page-link' href='".$path.$lastPage.".html'>".$lastPage."</a></li>";
                    }
                    
                }
                else
                {
                    $paginate .= "<li class='page-item'><a class='page-link' href='".$path."1.html'>1</a></li>";

                    if ($this->page > 3)
                    {
                        $paginate .= "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                    }
                    
                    $paginate .= "<li class='page-item'><a class='page-link' href='".$path.$prev.".html'>".$prev."</a></li>";
                    $paginate .= "<li class='page-item active' aria-current='page'><a class='page-link' href='".$path.$this->page.".html'>".$this->page."<span class='sr-only'>(current)</span></a></li>";
                    $paginate .= "<li class='page-item'><a class='page-link' href='".$path.$next.".html'>".$next."</a></li>";

                    $paginate .= "<li class='page-item disabled'><span class='page-link'>...</span></li>";

                    $paginate .= "<li class='page-item'><a class='page-link' href='".$path.$lastPage.".html'>".$lastPage."</a></li>";
                }
                
            }

            if ($this->page < $lastPage)
            {
                $paginate .= "<li class='page-item'><a class='page-link' href='".$path.$next.".html'>Next</a></li>";
            }
            else
            {
                $paginate .= "<li class='page-item disabled'><a class='page-link' href='".$path.$next.".html'>Next</a></li>";
            }
        }
        $paginate .= "</nav>";

        return $paginate;
    
    }

    public function getCounter()
    {
        if ($this->page == 1)
        {
            $counter = 1;
        }
        else if ($this->page == 2)
        {
            $counter = ($this->limit + 1);
        }
        else
        {
            $counter = $this->limit * ($this->page - 1) + 1;
        }
        return $counter;
    }

    public function page()
    {
        return $this->page;
    }

    public function setPage($page)
    {
        $page = (int) $page;

        $this->page = $page;
    }

    public function total()
    {
        return $this->total;
    }

    public function setTotal($total)
    {
        $total = (int) $total;

        $this->total = $total;
    }

    public function query()
    {
        return $this->query;
    }

    public function setQuery($query)
    {
        $this->query = $query;
    }

    public function limit()
    {
        return $this->limit;
    }

    public function setLimit($limit)
    {
        $limit = (int) $limit;

        $this->limit = $limit;
    }

    public function customCss()
    {
        return $this->customCss;
    }

    public function setCustomCss($customCss)
    {
        $this->customCss = $customCss;
    }
}