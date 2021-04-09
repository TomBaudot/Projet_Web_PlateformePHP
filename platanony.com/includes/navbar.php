<!-- Navbar bootstrap de base -->
<nav class="sticky-top mb-5 navbar bg-dark navbar-dark navbar-expand-lg container-fluid" style="border: 1px solid black;">

    <a class="navbar-brand" href="<?php ROOT_PATH ?> index.php?controller=accueil&action=home"><img src="<?php ROOT_PATH ?> static/images/logo2.png" alt="chargement échoué" style="border-radius: 15%"></a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse " id="navbarNavDropdown">
        <ul class="navbar-nav mr-auto nav nav-tabs " id="navbar_ul">
            <li class="nav-item nothing">

                <a class="nav-link text-white" href="<?php ROOT_PATH ?> index.php?controller=accueil&action=home"><span lang="eng">Home</span> <span lang="fr">Accueil</span><span class="sr-only">(current)</span></a>

            </li>
            <li class="nav-item nothing admin">

                <a class="nav-link text-white" href="<?php ROOT_PATH ?> index.php?controller=soumission&action=uploadSoumission">
                    <span lang="eng">Upload your submission</span>
                    <span lang="fr">Télécharger votre soumission</span>
                </a>

            </li>
            <li class="nav-item nothing team">

                <a class="nav-link text-white" href="<?php ROOT_PATH ?> index.php?controller=admin&action=displayFfiles">
                    <span lang="eng">The F files</span>
                    <span lang="fr">Les fichiers F</span>
                </a>

            </li>
            <li class="nav-item nothing admin">

                <a class="nav-link text-white" href="<?php ROOT_PATH ?> index.php?controller=distribution&action=search">
                    <span lang="eng">Files to attack</span>
                    <span lang="fr">Fichiers à attaquer</span>
                </a>

            </li>
            <li class="nav-item nothing">

                <a class="nav-link text-white" href="<?php ROOT_PATH ?> index.php?controller=soumission&action=listfiles">
                    <span lang="eng">Files score</span>
                    <span lang="fr">Score des fichiers</span>
                </a>

            </li>
            <li class="nav-item nothing">

                <a class="nav-link text-white" href="<?php ROOT_PATH ?> index.php?controller=team_ranking&action=displayTeamRanking">
                    <span lang="eng">Results</span>
                    <span lang="fr">Résultats</span>
                </a>

            </li>
            <li class="nav-item dropdown nothing team">
                <a class="nav-link dropdown-toggle text-white" href="#" data-toggle="dropdown">
                    Options
                </a>
                <div class="dropdown-menu bg-dark">

                    <a class="nav-link text-white nothing team text-center" href="<?php ROOT_PATH ?> index.php?controller=distribution&action=search">
                        <span lang="eng">Anonymized files from the teams</span>
                        <span lang="fr">Fichiers anonymisés des équipes</span>
                    </a>

                    <a class="dropdown-item team nothing text-white" href="<?php ROOT_PATH ?> index.php?controller=manage&action=home">
                        <span lang="eng">Manage each team</span>
                        <span lang="fr">Gérer les équipes</span>
                    </a>


                    <a class="dropdown-item team nothing text-white" href="<?php ROOT_PATH ?> index.php?controller=admin&action=manageTicket">
                        <span lang="eng">Manage tickets</span>
                        <span lang="fr">Gérer les posts</span>
                    </a>

                    <a class="dropdown-item team nothing text-white" href="<?php ROOT_PATH ?> index.php?controller=admin&action=manageCR">
                        <span lang="eng">Manage the countdown</span>
                        <span lang="fr">Régler le compte à rebours</span>
                    </a>

                    <a class="dropdown-item team nothing text-white" href="<?php ROOT_PATH ?> index.php?controller=checking&action=checkCR">
                        <span lang="eng">Check the countdown</span>
                        <span lang="fr">Vérifier le compte à rebours</span>
                    </a>


                </div>
            </li>
            <li class="nav-item admin team">
                <a class="nav-link text-white" href="<?php ROOT_PATH ?> index.php?controller=admin_auth&action=signin">Admin</a>
            </li>


        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <button id ="lang_but" type="button" class="btn btn-outline-warning" onclick="changeLanguage()"></button>
            </li>
        </ul>
    </div>

</nav>

<script>

    if(!readCookie("lang"))
    {
      document.cookie="lang=fr";
    }


</script>
