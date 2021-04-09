function display_buttons(name) {
    /**
     * Affiche le bouton 'Sign in' si l'utilisateur est authentifié sinon affiche le bouton 'Sign out'
     * @type {HTMLLIElement}
     */

    var container = document.createElement('li');
    var container2 = document.createElement('li');


    container.setAttribute('class', 'nav-item');
    container2.setAttribute('class', 'menu-item menu-item--niv1');


    var navbar_ul = document.getElementById('navbar_ul');
    var footer_ul = document.getElementById('menu-bottom');
    let NULL;
    if (footer_ul !== NULL)
        footer_ul.appendChild(container2);

    navbar_ul.appendChild(container);


    if (name === 'null'){

        var signin_anchor_eng = document.createElement('a');
        var signin_anchor_fr = document.createElement('a');
        var signin_anchor2_eng = document.createElement('a');
        var signin_anchor2_fr = document.createElement('a');


        signin_anchor_eng.setAttribute('class', 'nav-link text-white');
        signin_anchor_eng.setAttribute('lang', 'eng');
        signin_anchor_fr.setAttribute('class', 'nav-link text-white');
        signin_anchor_fr.setAttribute('lang', 'fr');

        signin_anchor2_eng.setAttribute('class', 'menu-link menu-link--niv1');
        signin_anchor2_eng.setAttribute('lang', 'eng');
        signin_anchor2_fr.setAttribute('class', 'menu-link menu-link--niv1');
        signin_anchor2_fr.setAttribute('lang', 'fr');


        signin_anchor_eng.setAttribute('href', "index.php?controller=auth&action=signin");
        signin_anchor2_eng.setAttribute('href', "index.php?controller=auth&action=signin");
        signin_anchor_fr.setAttribute('href', 'index.php?controller=auth&action=signin');
        signin_anchor2_fr.setAttribute('href', 'index.php?controller=auth&action=signin');


        signin_anchor_eng.textContent = 'Sign in';
        signin_anchor2_eng.textContent = 'Sign in';
        signin_anchor_fr.textContent = "S'authentifier";
        signin_anchor2_fr.textContent = "S'authentifier";


        container.appendChild(signin_anchor_eng);
        container.appendChild(signin_anchor_fr);
        container2.appendChild(signin_anchor2_eng);
        container2.appendChild(signin_anchor2_fr);

    }
    else{
        var signout_anchor_eng = document.createElement('a');
        var signout_anchor_fr = document.createElement('a');
        var signout_anchor2_eng = document.createElement('a');
        var signout_anchor2_fr = document.createElement('a');


        signout_anchor_eng.setAttribute('class', 'nav-link text-white');
        signout_anchor_eng.setAttribute('lang', 'eng');
        signout_anchor_fr.setAttribute('class', 'nav-link text-white');
        signout_anchor_fr.setAttribute('lang', 'fr');

        signout_anchor2_eng.setAttribute('class', 'menu-link menu-link--niv1');
        signout_anchor2_eng.setAttribute('lang', 'eng');
        signout_anchor2_fr.setAttribute('class', 'menu-link menu-link--niv1');
        signout_anchor2_fr.setAttribute('lang', 'fr');


        signout_anchor_eng.setAttribute('href', "index.php?controller=auth&action=signout");
        signout_anchor2_eng.setAttribute('href', "index.php?controller=auth&action=signout");
        signout_anchor_fr.setAttribute('href', 'index.php?controller=auth&action=signout');
        signout_anchor2_fr.setAttribute('href', 'index.php?controller=auth&action=signout');


        signout_anchor_eng.textContent = 'Sign out';
        signout_anchor2_eng.textContent = 'Sign out';
        signout_anchor_fr.textContent = "Se déconnecter";
        signout_anchor2_fr.textContent = "Se déconnecter";


        container.appendChild(signout_anchor_eng);
        container.appendChild(signout_anchor_fr);
        container2.appendChild(signout_anchor2_eng);
        container2.appendChild(signout_anchor2_fr);

    }

}

function display_team(){
    $(document).ready(function () {
        $("#teams_dropdown").change(function () {

            var id = $(this).find(":selected").val();

            var dataString = "filetype=Ffile&team_id=" + id;

            $.ajax({
                type: "GET",
                url: "controllers/controller_files.php",
                data: dataString,
                cache: false,
                success: function (r) {
                    $("#link_file_container").html(r);
                }


            });

        })

    });
}

function display_Afile(){
    $(document).ready(function () {
        $("#teams_dropdown_A").change(function () {

            var id = $(this).find(":selected").val();

            var dataString = "filetype=Afile&team_id=" + id;

            $.ajax({
                type: "GET",
                url: "controllers/controller_files.php",
                data: dataString,
                cache: false,
                success: function (r) {
                    // $("#link_Afile_container").html(r);
                    var result = r.split("|");
		    var i;

		    $("#link_Afile_container").html('');
		    $("#score_attack").html('');
		    
		    for (i = 0; i < result.length; i++){
			    if ((i % 2) == 0){
                    		$("#link_Afile_container").append(result[i]);
			    }
			    else{
                    		$("#score_attack").append(result[i]);
			    }
		    }
                }


            });

        })

    });
}

function dynamic_nav(name, type) {
    if(name === 'null') {
        var useless = document.getElementsByClassName('nothing');
        for(var i=0; i<useless.length;i++) {
            useless[i].style.display = "none";
        }
    }
    else if(type === 'team') {
        var useless = document.getElementsByClassName('team');
        for(var i=0; i<useless.length;i++) {
            useless[i].style.display = "none";
        }
    }
    else {

        var useless = document.getElementsByClassName('admin');
        for(var i=0; i<useless.length;i++) {
            useless[i].style.display = "none";
        }
    }
}
