
<div class ="container">
<form class="" id="centered" action="<?php ROOT_PATH ?>index.php?controller=admin&action=submitTicket" method="post">
    <div>
        <div class="form-group text-center text-white">
            <label for="name" class="h2">
                <span lang="eng">Title</span>
                <span lang="fr">Titre</span>
            </label>
            <input id="title_ticket_input" type="text" class="form-control" id="name" name="title" placeholder="Saisir le titre" required >
            <div class="help-block with-errors"></div>
        </div>

        <div class="form-group text-white  text-center">
            <label for="message" class="h2">Message</label>
            <textarea id="message" class="form-control h4" name="data"  rows="5" placeholder="Entrez votre message" required></textarea>
        </div>
            <button id="ticket_sub_btn" type="submit" id="form-submit" class="btn btn-success btn-lg pull-right m-5">Envoyer</button>

            <!--<div id="msgSubmit" class="h3 text-center hidden">Message Submitted!</div>-->
    </div>
</form>
</div>
<?php
    if($ticketsAlreadySaved != NULL && sizeof($ticketsAlreadySaved)>0)
    {
      foreach ($ticketsAlreadySaved as $ticket) {
          echo ('
                      <div class="card m-5">
                      <h2 style="color:#FF8C00 ; background-color:#000" class="text-center card-header">
                      '.$ticket->title.'
                      </h2>
                      <div class="text-center bg-dark card-body">
                      <h4 style="color:orange" class="card-title pt-5">'.$ticket->data.' </h4>
                      <h6 style="color:orange" class="card-text pt-5">'.$ticket->date.'</h6>
                      </div>
                      <a href="index.php?controller=admin&action=deleteTicket&id_ticket='.$ticket->id_ticket.'" class="btn btn-danger">
                          <span lang="eng">Remove the ticket</span>
                          <span lang="fr">Supprimer l\'information</span>
                      </a>
                      </div>
              ');

    }
  }




 ?>

<script>
    if (readCookie("lang") === "eng"){
        $('#title_ticket_input').attr('placeholder', "Message title");
        $('#message').attr('placeholder', "Message content");
        $('#ticket_sub_btn').text("Upload");
    }
</script>
