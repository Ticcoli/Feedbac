<?php
if (!isset($_REQUEST['action']))
	$action = "gerer" ;
else
	$action = $_REQUEST['action'] ;
switch ($action)
{
    //page d'accueil de l'administrateur
    case "gerer" : { 
        require "vues/v_manage.php" ; 
        break ;   }		
    
    //page d'accueil de la gestion des demandes
    case "gererdemande" : {
            require "vues/v_manage_requests.php" ; 
        break ;  
    }
       
    //gestion du site : ajouter des demi-journées de congé à un employé
    case "ajouterJour" : {
        $id = $_REQUEST['id'];
        $type = $_REQUEST['type_conge'.$id];
        $nb = $_REQUEST['nb_demiejourne'.$id];

        if (addDemieJournee($type, $nb, $id)) {
            echo("Ajout réalisé avec succès");
        }
        else {
            echo("Echec ajout demi-journées");
        }
        require "vues/v_manage.php" ; 
        break ;  
    }
    
    //gestion du site : affichage formulaire de modification de l'employé choisi
    case "modifyUser" : {
        $id = $_REQUEST['id'];
        $user = getUserbyID($id);
        require "vues/v_manage_modify_user.php" ; 
        break ;  
    }

    //gestion du site : mise à jour des données de l'employé choisi
    case "updateUser" : {
        $id = $_REQUEST['id'];
        $nom = $_REQUEST['modify_user_nom'] ;
        $prenom = $_REQUEST['modify_user_prenom'] ;
        $matricule = $_REQUEST['modify_user_matricule'] ;
        $mail = $_REQUEST['modify_user_mail'] ;
        $cp = $_REQUEST['modify_user_compteur_cp'] ;
        $ss = $_REQUEST['modify_user_compteur_ss'] ;
        $droit = $_REQUEST['modify_user_droit'] ;
        if (modifyUser($id, $nom, $prenom, $mail, $droit,$matricule, $cp, $ss )) {
            echo 'Utilisateur modifié avec succès' ;
        }
        else {
            echo 'Echec dans la mise à jour de l\'utilisateur' ;
        }
        $user = getUserbyID($id);
        require "vues/v_manage.php" ; 
        break ;  
    }
	
    //gestion du site : suppression d'un employé et de ses demandes de congés
    case "deleteUser" : {
        $id = $_REQUEST['id'];
        if (deleteUser($id)) {
            echo 'Utilisateur supprimé avec succès' ;
        }
        else {
            echo 'Echec dans la suppression de cet utilisateur' ;
        }
        $user = getUserbyID($id);
        require "vues/v_manage.php" ; 
        break ;  
    }
        
    //gestion du site : création d'un utilisateur
    case "createUser" : {
        $nom = $_REQUEST['nom'];
        $prenom = $_REQUEST['prenom'];
        $droits = $_REQUEST['droits'];
        $mail = $_REQUEST['mail'];
        $matricule = $_REQUEST['matricule'];
        if (!isset(getUserbyMail($mail)['nom'])) {
            addNewUser($prenom, $nom, $mail, $matricule, $droits);
            echo('Utilisateur ajouté avec succès avec le mot de passe suivant : password');
        }
        else {
                echo('Cette adresse est deja utilsée par un autre utilisateur!');
        }

        require "vues/v_manage.php" ; 
        break ;  
    }
       
    //gestion du site : ajout d'un jour férié
    case "createFerie" : {
        $date = $_REQUEST['dateFerie'];
        $desc = $_REQUEST['ferieDesc'];

        $lesferies = getAllFeries();//verifier que ce jour est libre
        $pris = false;
        foreach ($lesferies as $leferie)
        {
            if (substr($leferie['date'], -2, -1) == substr($date, -2, -1) 
               and substr($leferie['date'], 5, 6) == substr($date, 5, 6) )
            {
                    $pris = true;
            }
        }

        if (!$pris)
        {
            if (addNewFerie($date, $desc)) {                 
            echo 'Jour férié ajouté avec succès' ;
            }
            else {
                echo 'Echec dans l\'ajout de ce jour' ;
            }
        }

        require "vues/v_manage.php" ; 
        break ;  
    }
    
    //gestion du site : suppression d'un jour férié     
    case "deleteFerie" : {
        $id = $_REQUEST['ferie'];
        if (deleteFerie($id)) {
            echo 'Jour supprimé avec succès' ;
        }
        else {
            echo 'Echec dans la suppression de ce jour' ;
        }
        require "vues/v_manage.php" ; 
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