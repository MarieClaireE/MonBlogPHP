<?php
  include('./include/autoloadEntity.php');
  include('./class/manager/UserManager.php');

//mon adresse e-mail
$monAdresseEmail = 'mcemma.974@gmail.com';

// si l'internaute clique sur le bouton Envoyer
if (isset($_POST['envoyer'])) {
    // on vérifie que les champs nom, prénom, mail sont bien remplis
    if (empty($_POST['name']) && empty($_POST['firstname']) && empty($_POST['email'])) {
        echo 'Pour envoyer votre message, veuillez remplir tous les champs marqués d\'une étoile';
    } else {
        // on vérifie que l'adresse est correcte
        if (!preg_match("#^[a-z0-9_-]+((\.[a-z0-9_-]+){1,})?@[a-z0-9_-]+((\.[a-z0-9_-]+){1,})?\.[a-z]{2,}$#i", $_POST['email'])) {
            echo '<div class="bg-warning text-white-50">L\'e-mail entrée est incorrecte </div>';
        } else {
            // on vérifie si les champs sont remplis
            if (empty($_POST['sujet'])) {
                echo '<div class="bg-danger text-white-40">Le sujet est vide!</div>';
            } else {
                if (empty($_POST['message'])) {
                    echo '<div class="bg-danger text-white-40">Veuillez entrer un message!</div>';
                } else {
                    // tout est correctement renseigné, on envoie le mail
                    //on renseigne les entêtes de la fonction mail de PHP
                    $entetes = "MIME-Version: 1.0\r\n";
                    $entetes .= "Content-type: text/html; charset=UTF-8\r\n";
                    $entetes .= "From: Mon Blog PHP <" .$_POST['email']. ">\r\n";
                    $entetes .= "Reply To: Mon Blog PHP <".$_POST['email'].">\r\n";

                    // on prépare les champs
                    $mail = $_POST['email'];
                    $sujet = '=?UTF-8?B?'. base64_encode($_POST['sujet']).'?=';
                    //cet encodage (base64_encode) permet aux informations binaires d'être manipulées par les systèmes qui ne gèrent pas correctement les 8bits
                    $message = htmlentities($_POST['message'], ENT_QUOTES, "UTF-8");
                    // htmlentities() convertit tous les accents en entités html, ENT_QUOTES convertit en + les guillemets doubles et les guillemets simples en entités html.

                    //envoie du mail
                    $Email = mail($monAdresseEmail, $sujet, nl2br($message), $entetes);
                    if ($Email) {
                        $envoie = '<div class="bg-info text-white-50">Le mail a été envoyé avec succès!</div>';
                    } else {
                        $envoie = '<div class="bg-info text-white-50">Une erreur est survenue, veuillez réessayer !</div>';
                    }
                }
            }
        }
    }
}
?>

<form action="#about-section" method="post">
  <label for="name" class="form-label">Insérer votre nom </label>
   <input id="name" name="nom" type="text" placeholder="ex: EMMA" class="form-control" required>

  <label for="firstName" class="form-label">Insérer votre prénom </label>
  <input id="firstName" name="firstname" type="text" placeholder="ex:Marie" class="form-control" required>

  <label for="email" class="form-label">Insérer votre adresse e-mail</label>
  <input type="email" name="email" id="email" placeholder="ex: email@email.com" class="form-control" required>

  <label for="sujet" class="form-label">Insérer le sujet de votre message</label>
  <input type="text" name="sujet" id="sujet" placeholder="Demande de renseignement">

  <label for="message" class="form-label">Insérer votre message</label>
  <textarea name="message" id="message" cols="60" rows="10" placeholder="Votre message" class="form-text"></textarea>

  <div class="row ">
    <div class="col text-center">
      <input id="envoyer" class="w-50 btn btn-light btn-sm mt-3" name="envoyer" type="submit" value="Envoyer">
    </div>
  </div>
</form>

<div class="p">
  <?php
  if (isset($_POST['envoyer'])) {
      echo $envoie;
  }
 ?>
</div>

