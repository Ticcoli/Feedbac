<?php
if (!isset($_REQUEST['action']))
	$action = "" ;
else
	$action = $_REQUEST['action'] ;
switch ($action)
{
    //enregistrement d'une demande de congé
    case "enregistrerConge" : { 
        $debut_date = $_REQUEST["debut_periode_date"];
        $fin_date = $_REQUEST["fin_periode_date"];
        $debut_moment = $_REQUEST["debut_periode_moment"];
        $fin_moment = $_REQUEST["fin_periode_moment"];
        $type = $_REQUEST["type_conge"];

        echo newRequest($type, $debut_date, $debut_moment, $fin_date, $fin_moment);

        require "vues/v_accueil.php" ; 
        break ;              
    }
     
    //affichage formulaire de modification du mot de passe
    case "mdp" : {
            require "vues/v_mdp_change.php" ; 
        break ;  
    }

    //modification du mot de passe
    case "modifierMdp" : {
        $oldPswrd = $_REQUEST['oldPassword'];
        $newPswrd = $_REQUEST['newPassword'];

        if (getUserbyMail($_SESSION['mail'])['password'] == md5($oldPswrd))
        {
            updatePassword(md5($newPswrd));
            echo("Changement reussi");// signaler si la requete a reussie
            require "vues/v_accueil.php" ;
        }
        else 
            echo('Erreur sur l\'ancien mot de passe.');         
    }        
}
?>