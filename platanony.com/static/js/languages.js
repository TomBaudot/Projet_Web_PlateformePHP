function setCookie(name, value, days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString() + ";secure";
    }
    else var expires = "";
    document.cookie = name + "=" + value + expires + ";";
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function eraseCookie(name) {
    setCookie(name,"",-1);
}

function displayLanguage(lang){
    /**
     * Affiche la langue passée en param seulement
     * @param lang: L'acronyme de la langue à utiliser -> soit "fr" soit "eng"
     */
    if(lang !== "fr" && lang !== "eng"){
        return;
    }

    if (lang === "fr"){
        $('#lang_but').text("Français");
        $('[lang="eng"]').hide();
    }
    else{
        $('#lang_but').text("English");
        $('[lang="fr"]').hide();
    }

}

function changeLanguage(){
    /**
     * Change la langue du site dans la langue donnée en param
     * @type {HTMLLIElement}
     */
    var lang = readCookie("lang");

    if(lang !== "fr" && lang !== "eng"){
        return;
    }


    if (lang === "fr"){
        eraseCookie("lang");
        document.cookie="lang=eng";
        $('#lang_but').text("English");
    }
    else{
        eraseCookie("lang");
        document.cookie="lang=fr";
        $('#lang_but').text("Français");

    }

    $('[lang="fr"]').toggle();
    $('[lang="eng"]').toggle();
}
