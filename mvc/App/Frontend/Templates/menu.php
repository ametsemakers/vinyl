<div class="row">
  
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="width: 100%;">
      <!-- <a class="navbar-brand" href="#">Navbar</a> -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="/">Accueil <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Vinyles
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="/tous-les-vinyles/page=1.html">Liste</a>
              <?php if ($user->isAuthenticated()) { ?>
                <a class="dropdown-item" href="/admin/insert-vinyl.html">Ajouter</a>
              <?php } ?>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Something else here</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Morceaux
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">Liste</a>
              <a class="dropdown-item" href="#">#</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Something else here</a>
            </div>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="/admin/page=1.html">Espace admin<span class="sr-only">(current)</span></a>
          </li>

          <?php if ($user->isAuthenticated()) { ?>   
            <li class="nav-item active">
              <a class="nav-link" href="#">Déconnexion<span class="sr-only">(current)</span></a>
            </li>
          <?php } ?>
          
        </ul>
        <form action="/admin/search.html" method="post" class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="text" name="query" id="query" placeholder="Votre recherche ..." aria-label="Search">
          <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Chercher !</button>
        </form>
      </div>
    </nav>
  
</div>