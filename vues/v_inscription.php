<form method="post">
    <div>
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="user_nom">
    </div>
    <div>
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="user_prenom">
    </div>
    <div>
        <label for="mail">e-mail?:</label>
        <input type="email" id="mail" name="mail">
    </div>
    <div>
        <label for="portable">Téléphone portable (optionnel) :</label>
        <input type="text" id="portable" name="portable">
    </div>
    <div>
        <label for="serie">Baccalauréat série :</label>
        <input type="text" id="serie" name="serie">
    </div>
    <div>
        <label for="session">Année d'obtention :</label>
        <input type="string" id="session" name="session">
    </div>

    <div>
        <label for="msg">Message :</label>
        <textarea id="msg" name="user_message"></textarea>
    </div>
    <div>
        <label for="password">Mot de passe :</label>
        <input type=password id="password" name="password">
    </div>
    <div>
        <input type="password" name="repeatPassword">
        <input type=password id="password" name="repeatPassword">
        <br><br>

        <input type="submit" name="submit" value="Valider">
    </div>
</form>

<?php
    session_start();
    include('modele/connexion.php');

    if(!empty($_POST)){
        extract($_POST);
        $valid = true;

        // On se place sur le bon formulaire grâce au "name" de la balise "input"
        if (isset($_POST['inscription'])){
            /*$nom  = htmlentities(trim($nom)); // On récupère le nom
            $prenom = htmlentities(trim($prenom)); // on récupère le prénom
            $mail = htmlentities(strtolower(trim($mail))); // On récupère le mail
            $mdp = trim($mdp); // On récupère le mot de passe 
            $confmdp = trim($confmdp); //  On récupère la confirmation du mot de passe*/

            $nom=$_POST['nom'];
            $prenom=trim($_POST['prenom']);
            $mail=trim($_POST['mail']);
            $portable=trim($_POST['portable']);
            $serie=trim($_POST['serie']);
            $session=trim($_POST['session']);
            $msg=$_POST['msg'];
            $password=md5($_POST["password"]);
            $repeatPassword=md5($_POST["repeatPassword"]);

            //  Vérification du nom
            if(empty($nom)){
                $valid = false;
                $er_nom = ("Le nom d' utilisateur ne peut pas être vide");
            }       

            //  Vérification du prénom
            if(empty($prenom)){
                $valid = false;
                $er_prenom = ("Le prenom d' utilisateur ne peut pas être vide");
            }       

            // Vérification du mail
            if(empty($mail)){
                $valid = false;
                $er_mail = "Le mail ne peut pas être vide";

                // On vérifit que le mail est dans le bon format
            }elseif(!preg_match("/^[a-z0-9\-_.]+@[a-z]+\.[a-z]{2,3}$/i", $mail)){
                $valid = false;
                $er_mail = "Le mail n'est pas valide";

            }else{
                // On vérifit que le mail est disponible
                $req_mail = $DB->query("SELECT mail FROM utilisateur WHERE mail = ?",
                    array($mail));

                $req_mail = $req_mail->fetch();

                if ($req_mail['mail'] <> ""){
                    $valid = false;
                    $er_mail = "Ce mail existe déjà";
                }
            }

            //Le numero de téléphone n'est pas obligatoire on ne vérifie que le format
            if(!empty($portable)){
                preg_match("#^0[1-68]([-. ]?[0-9]{2}){4}$#", $portable);
            }
            else
	        echo "$portable n'est pas un numéro valide";

            // Vérification du mot de passe
            if(empty($password)) {
                $valid = false;
                $er_password = "Le mot de passe ne peut pas être vide";

            }elseif($password != $repeatPassword){
                $valid = false;
                $er_password = "La confirmation du mot de passe est incorrecte";
            }

            // Si toutes les conditions sont remplies alors on fait le traitement
            if($valid){
                $date_creation_compte = date('Y-m-d H:i:s');

                // insertion dans la table utilisateur
                $DB->insert("INSERT INTO utilisateur (nom, prenom, mail, 2, portable , serie, msg,  password, date_creation_compte) VALUES 
                    (?, ?, ?, ?, ?)", 
                    array($nom, $prenom, $mail, $password, $date_creation_compte));

                header('Location: index.php');
                exit;
            }
        }
    }

    
?>