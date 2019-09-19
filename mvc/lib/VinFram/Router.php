<?php
namespace VinFram;

class Router
{
    protected $routes = [];

    const NO_ROUTE = 1;

    public function addRoute(Route $route)
    {
        if (!in_array($route, $this->routes))
        {
            $this->routes[] = $route;
        }
    }

    public function getRoute($url)
    {
        //var_dump($this->routes);
        //exit();

        // vérifier les routes s'il y a une non trouvée.
        // foreach ($this->routes as $route)
        // {
        //     var_dump($route);
        //     var_dump($route->match($url));
        // }
        // exit();            

        foreach ($this->routes as $route)
        {
            //var_dump($route);
            //exit();
            // Si la route correspond à l'URL
            if (($varsValues = $route->match($url)) !== false)
            {
                // Si elle a des variables
                if ($route->hasVars())
                {
                    $varsNames = $route->varsNames();
                    $listVars = [];

                    // On crée un nouveau tableau clé/valuer
                    // (clé = nom de la variable, valeur = sa valeur)
                    foreach ($varsValues as $key => $match)
                    {
                        // La première valeur contient entièrement la chaine capturée (voir la doc sur preg_match)
                        if ($key !== 0)
                        {
                            $listVars[$varsNames[$key - 1]] = $match;
                        }
                    }

                    // On assigne ce tableau de variables à la route
                    $route->setVars($listVars);
                }
                //var_dump($route);
                //exit();
                
                return $route;
            }
        }

        throw new \RuntimeException('Aucune route ne correspond à l\'URL', self::NO_ROUTE);
    }
}