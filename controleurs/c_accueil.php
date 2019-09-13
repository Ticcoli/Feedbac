<?php
//Mettre la date courrante
if (!isset($_COOKIE['date']))
{
	$unedate =  date_create('now');
	$dateref = new DateTime();
	$dateref->setDate($unedate->format('Y'), $unedate->format('m'), '15');
	setcookie('date', (string)$dateref->format('Y-m-d'), time() + (86400 * 30), "/"); // 86400 = 1 day

}


	//action
if (!isset($_REQUEST['action']))
	$action = "afficher" ;
else
	$action = $_REQUEST['action'] ;
	
switch ($action)
{
	//page d'accueil du site	
	case "afficher" : { 
            //Affichage du formulaire de connexion si aucun utilisateur authentifié sur le site
            if (!isset($_SESSION['nom']))
            {
                require "vues/v_connexion.php" ; 
            }
            //sinon, affichage du formulaire d'accueil
            else {
                require "vues/v_accueil.php" ; 
                break ;             
            }
            break ;
	}
        
        //authentification
        case "verifier" : {
            //Récupération des login et mots de passe du formulaire
            $lelogin = $_REQUEST['login'];
            $lepassword = $_REQUEST['password'];
            //recherche dans la base de données de la personne grâce à son login
            $luser = getUserbyMail($lelogin);
            if ($luser['nom'] <> '' and (md5($lepassword) == $luser['password']) )
            {
                //login et mot de passe corrects
                $_SESSION['id'] = $luser['ID'];
                $_SESSION['nom'] = $luser['nom'];
                $_SESSION['prenom'] = $luser['prenom'];
                $_SESSION['mail'] = $luser['mail'];
                $_SESSION['matricule'] = $luser['Matricule'];
                $_SESSION['droits'] = $luser['droits'];
                
                //redirection vers la page d'accueil
                require "vues/v_accueil.php" ;    
            }
            else
            {
                //login et mot de passe incorrects
                $erreur = 1 ;
                require "vues/v_connexion.php" ;
            }
            break ;
        }
}


?>