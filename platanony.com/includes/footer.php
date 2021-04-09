
    <footer id="zone-footer" style=" padding: 2%;">
        <div class="u-wrapper">
            <div class="footer-col">

                <h3 lang="eng">
                    In
                    <span>one click</span>
                </h3>

                <h3 lang="fr">
                    En
                    <span>un clic</span>
                </h3>

                <div class="footerMenu footerMenu--col2">
                    <div class="menu menu--horizontal   default">
                        <ul class="menu-list menu-list--niv1" id="menu-bottom">
                            <li class="menu-item menu-item--niv1">

                                <a href="<?php ROOT_PATH ?> index.php?controller=accueil&action=home" class="menu-link menu-link--niv1">
                                    <span lang="eng">Home</span>
                                    <span lang="fr">Accueil</span>
                                </a>

                            </li>
                            <li class="menu-item menu-item--niv1">
                                <a href="<?php ROOT_PATH ?> index.php?controller=admin_auth&action=signin" class="menu-link menu-link--niv1 ">Admin</a>
                            </li>
                            <li class="menu-item menu-item--niv1">

                                <a href="<?php ROOT_PATH ?> index.php?controller=distribution&action=search" class="menu-link menu-link--niv1 ">
                                    <span lang="eng">Teams summary</span>
                                    <span lang="fr">Résumé des équipes</span>
                                </a>

                            </li>
                            <li class="menu-item menu-item--niv1 ">
                                <a href="<?php ROOT_PATH ?>index.php?controller=team_ranking&action=displayTeamRanking" class="menu-link menu-link--niv1">
                                    <span lang="eng">Team ranking</span>
                                    <span lang="fr">Classement des équipes</span>
                                </a>
                            </li>
                            <li class="menu-item menu-item--niv1">
                                <a href="<?php ROOT_PATH ?> index.php?controller=soumission&action=uploadSoumission" class="menu-link menu-link--niv1" >
                                    <span lang="eng">Upload your submission</span>
                                    <span lang="fr">Télécharger votre soumission</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-col" style=" padding-left: 8%">
                <h3 lang="eng">
                    <span>Contact</span>
                    us
                </h3>
                <h3 lang="fr">
                    Nous
                    <span>contacter</span>
                </h3>
                <ul>
                    <li>darc@gmail.com</li>
                    <li>88 boulevard Lahitolle &nbsp;-&nbsp; 18000&nbsp;Bourges</li>
                </ul>
                <br>
            </div>

        <div class="footer-col" style="padding-top: 10%">
            <p class="copyright-client">&copy; DARC-G1.2 2020</p>
            <p class="copyright-real">
                <span lang="eng">Created by the group 1.2</span>
                <span lang="fr">R&eacute;alis&eacute; par le groupe 1.2</span>
            </p>
            <p class="maj mentions-legales">

                <span lang="eng">Last update : <?php
                    $SCRIPT_FILENAME = "routes/router.php"; // j'ai choisi le routeur parce qu'il est le plus modifié

                    echo date("m/d/Y", filemtime($SCRIPT_FILENAME)) . "   |";
                    ?>
                </span>

                <span lang="fr">Mise &agrave; jour : <?php
                    $SCRIPT_FILENAME = "routes/router.php"; // j'ai choisi le routeur parce qu'il est le plus modifié

                    echo date("d/m/Y", filemtime($SCRIPT_FILENAME)) . "   |";
                    ?>
                </span>

                <a href="#" lang="eng">Terms and conditions</a>&nbsp;
                <a href="#" lang="fr">Mentions l&eacute;gales</a>

            </p>
            <div class="sitemapPrint">
                <p>
                    <script> var NS = (navigator.appName == "Netscape"); </script>
                    <a id="print-link" class="sitemapPrint-link" target="_blank" rel="nofollow" onclick="printout()" style="cursor: pointer;">
                        <span class="sitemapPrint-linkLabel" lang="eng">Print</span>
                        <span class="sitemapPrint-linkLabel" lang="fr">Imprimer</span>
                    </a>
                    &nbsp;|&nbsp;
                    <a class="sitemapPrint-link" href="#"> <!-- tu feras un script php plan_du_site.php -->
                        <span class="sitemapPrint-linkLabel" lang="eng">Website plan</span>
                        <span class="sitemapPrint-linkLabel" lang="fr">Plan du site</span>
                    </a>
                </p>
            </div>


        </div>
      </div>
    </footer>

<!-- Footer -->

    <script>
        var name = <?php
            if (isset($_SESSION['admin_name'])){
                echo json_encode($_SESSION['admin_name']);
            }
            else if (isset($_SESSION['team_name'])){
                echo json_encode($_SESSION['team_name']);
            }
            else{
                echo json_encode(null);
            }
            ?>;
        display_buttons(name);


        function printout()
        {
            if (NS) {
                window.print() ;
            }
            else {
                var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
                document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
                WebBrowser1.ExecWB(6, 2);
            }
        }
        displayLanguage(Cookies.get("lang"));
    </script>

    <script language="JavaScript">
        /* Temps*/
        var dix= 0 ;
        var sc= 5 ;
        var mn= 1 ;
        var hr= 1;
        function chrono()
        {
            dix--;
            if (dix<0) {dix=9;sc--}
            if (sc<0) {sc=59;mn--}
            if (mn<0) {mn=59;hr--}

            time=hr+" hr "+mn+" mn "+sc+" s "+dix;
            document.forme.champ1.value=time;
            if (hr ==0 & mn==0 & sc==0 & dix==0)
                /* J'indique le temps est fini !! */
            {
                alert('Il est trop tard !')
            }
            decompte= setTimeout('chrono()', 100);

        }
        /* A régler ici aussi*/

        function zero()
        {
            clearTimeout(decompte)
            dix= 0;
            sc= 5;
            mn= 1;
            hr= 1;
            time=hr+" hr "+mn+" mn "+sc+" s "+dix;
            document.forme.champ1.value=time;
        }
    </script>



<!-- // container -->
</body>
