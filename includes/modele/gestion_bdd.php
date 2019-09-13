<?php
/*
 * Ici les requete pour la bdd
 */

/*
 * Obtenir toutes les demandes des utilisateurs.
 */


function GetAllRequests($year) // obtenir toutes les requêtes de demie journée d'un mois donné en parametre 
{
	$connect = new connexion();
	$bdd = $connect->getInstance();
	$lesdemandes = $bdd->query(' select ID_request, date, id_utilisateur, year(date) as annee,  day(date) as jour, month(date) as mois, moment, type, accepte   from demie_journee where year(date) = ' . $year );
	$rawdata = $lesdemandes->fetchAll();
		
    return $rawdata;
}

function GetRequestbyID($ID) // obtenir toutes les requêtes de demie journée d'un mois donné en parametre 
{
	$connect = new connexion();
	$bdd = $connect->getInstance();
	$lesdemandes = $bdd->query(' select *   from demie_journee where ID_request = ' . $ID);
	$rawdata = $lesdemandes->fetch();
		
    return $rawdata;
}

function GetJourFeriesdeLan($year) //obtenir tous les jours feriés du mois en parametre.
{
	
	$connect = new connexion();
	$bdd = $connect->getInstance();
	$lesdemandes = $bdd->query(' select date, day(date) as jour, nom, month(date) as mois  from jours_feries where year(date)  = ' . $year ); // ça bloque.. pourquoi !?
	//var_dump($year);
	$rawdata = $lesdemandes->fetchAll();
		
    return $rawdata;
}

function GetJourReposduMoisparUser($mois) //obtenir tous les jours feriés du mois en parametre.
{
	$connect = new connexion();
	$bdd = $connect->getInstance();
	$lesdemandes = $bdd->query(' SELECT count(*) as nb, `id_utilisateur`, nom, prenom, accepte  FROM `demie_journee` inner join utilisateur on utilisateur.ID=`id_utilisateur` where  month(date) =  '.$mois.'  group by `id_utilisateur`, accepte' );
	$rawdata = $lesdemandes->fetchAll();
		
    return $rawdata;
}

function insertNewRequest($date, $moment, $type, $utilisateur)//inserer une nouvelle requête de demie journée dans la base de donnée.
{
	$connect = new connexion();
	$bdd = $connect->getInstance();
	

	$bdd->exec('insert into demie_journee(date, moment, type, id_utilisateur) values ( "'.$date.'" , '.$moment.' , "'.$type.'" , '.$utilisateur.' );  ');

}

function getUserbyName($name, $surname) //retourne l'utilisateur
{
	$connect = new connexion();
	$bdd = $connect->getInstance();
	$luser = $bdd->query(' select * from utilisateur where nom = "'.$surname.'" and prenom = "'.$name.'" ;'  );
	$rawdata = $luser->fetch();
		
    return $rawdata;
}

function getDemiJourneebyDateandUser($month, $day, $user) //retourne l'utilisateur
{
	$connect = new connexion();
	$bdd = $connect->getInstance();
	$luser = $bdd->query(' select * from demie_journee where month(date) = "'.$month.'" and day(date) = "'.$day.'" and id_utilisateur = '.$user.';'  );
	$rawdata = $luser->fetch();
		
    return $rawdata;
}

function getDemiJourneebyID($id) //retourne l'utilisateur
{
	$connect = new connexion();
	$bdd = $connect->getInstance();
	$luser = $bdd->query(' select * from demie_journee where ID_request = '.$id.' ;'  );
	$rawdata = $luser->fetch();
		
    return $rawdata;
}

function getUserbyMail($mail) //retourne l'utilisateur
{
	$connect = new connexion();
	$bdd = $connect->getInstance();
	$luser = $bdd->query(' select * from utilisateur where mail = "'.$mail.'";'  );
	$rawdata = $luser->fetch();
		
    return $rawdata;
}

function getUserbyID($id) //retourne l'utilisateur
{
	$connect = new connexion();
	$bdd = $connect->getInstance();
	$luser = $bdd->query(' select * from utilisateur where ID = '.$id.';'  );
	$rawdata = $luser->fetch();
		
    return $rawdata;
}

function getCompteurs($userid)//retourne les compteurs 
{
	$connect = new connexion();
	$bdd = $connect->getInstance();
	$compteurs = $bdd->query(' select compteur_dj_cp as CP, compteur_dj_ss as SS from utilisateur where ID = "'.$userid.'";'  );
	$rawdata = $compteurs->fetch();
	return $rawdata;
}

function getDemandesenAttenteceMois($mois)//retourne les compteurs 
{
	$connect = new connexion();
	$bdd = $connect->getInstance();
	$compteurs = $bdd->query(' select count(*) as nb_demandes from demie_journee where month(date) = '.$mois.' and accepte is null;'  );
	$rawdata = $compteurs->fetch();
	return $rawdata;
}

function getDemandes($date, $etat, $employe, $type)//retourne les compteurs 
{
	$connect = new connexion();
	$bdd = $connect->getInstance();
	$compteurs = $bdd->query(' select * from demie_journee
								inner join utilisateur on demie_journee.id_utilisateur = utilisateur.ID
								where 1=1 '.$date.$etat.$employe.$type.'
								order by date desc;'  );
	$rawdata = $compteurs->fetchAll();
	return $rawdata;
}

function getDemandesceMois($mois)//retourne les compteurs 
{
	$connect = new connexion();
	$bdd = $connect->getInstance();
	$compteurs = $bdd->query('  select count(*) as nb_demandes from demie_journee where month(date) = '.$mois.';'  );
	$rawdata = $compteurs->fetch();
	return $rawdata;
}

function getAllUsers()//retourne les utilisaterus
{
	$connect = new connexion();
	$bdd = $connect->getInstance();
	$compteurs = $bdd->query('  select * from utilisateur order by ID desc'  );
	$rawdata = $compteurs->fetchAll();
	return $rawdata;
}

function getAllRegularUsers()//retourne les utilisaterus
{
	$connect = new connexion();
	$bdd = $connect->getInstance();
	$compteurs = $bdd->query('  select * from utilisateur where droits = 1'  );
	$rawdata = $compteurs->fetchAll();
	return $rawdata;
}

function addNewUser($prenom, $nom, $mail, $matricule, $droits)
{
	$statut = null;
	if ($droits == "Utilisateur")
	{
		$statut = '1';
	}
	else
	{
		$statut = '0';
	}
	$connect = new connexion();
	$bdd = $connect->getInstance();
	

	if ($bdd->exec('insert into utilisateur(nom, prenom, mail, Matricule, droits, password) values ( "'.$nom.'" , "'.$prenom.'" , "'.$mail.'" , "'.$matricule.'", "'.$statut.'", "'.md5('password').'"  );  ')) {
           return 1 ;
        }
        else {
            return 0;
        }
}

function addNewFerie($date, $desc)
{
	$connect = new connexion();
	$bdd = $connect->getInstance();
	

	if ($bdd->exec('insert into jours_feries(date, nom) values ( "'.$date.'" , "'.$desc.'") ')) {
            return 1 ;
        }
        else {
            return 0;
        }
        
}

function addDemieJournee($type, $nb, $user)//ajouter un certain nombe de demires journées à un utilisateur
{
	$letype = "";
	if ($type == "Sans Solde")
	{
		$letype = "ss";
	}
	else
	{
	$letype = "cp"	;
	}
	$initial = getCompteurs($user)[strtoupper($letype)];//nombre initial de jours
	$demij = $initial + $nb;
	$connect = new connexion();
	$bdd = $connect->getInstance();
	

	if($bdd->exec('update utilisateur set compteur_dj_'.$letype.' = '.  $demij.' where ID = '.$user.' ;')) {
            return 1 ;
        }
        else {
            return 0 ;
        }
	
}

function reponseDemieJournee($id, $reponse, $commentaire)//repondre à une demie journée
{
	$connect = new connexion();
	$bdd = $connect->getInstance();
	$bdd->exec('update demie_journee set accepte = '.  $reponse .', commentaire = "'.  $commentaire . '" where ID_request = '.$id.'  ;');
	
}

function deleteUser($user)//supprimer un utilisateur et ses journées de congéaddNewUser
{
	$connect = new connexion();
	$bdd = $connect->getInstance();	
	if ($bdd->exec('delete from demie_journee where id_utilisateur = '.$user.';
	delete from utilisateur where ID = '.$user.' ;')) {
            return 1 ;
        }
        else {
            return 0;
        }
}

function deleteFerie($ferie)//supprimer un jour férié
{
	$connect = new connexion();
	$bdd = $connect->getInstance();	
	if ($bdd->exec('delete from jours_feries where ID = '.$ferie.' ;')) {
            return 1 ;
        }
        else {
            return 0;
        }	
}

function getAllFeries()
{
	$connect = new connexion();
	$bdd = $connect->getInstance();
	
	$luser = $bdd->query(' select * from jours_feries order by date; '  );

	$rawdata = $luser->fetchAll();
		
    return $rawdata;
	
}

function modifyUser($id, $nom, $prenom, $mail, $droit,$matricule, $cp, $ss )
{
	$strdroit = "";
	if ($droit == "Admin" )
	{
		$strdroit = 0;
		deleteRequests($id);
	}
	else
	{
		$strdroit = 1;
	}
	
	
	$connect = new connexion();
	$bdd = $connect->getInstance();	
	if ($bdd->exec('update utilisateur set nom = "'.$nom .'" , prenom = "'.$prenom.'" , mail="'.$mail.'",droits ='.$strdroit .', Matricule = "'.$matricule.'", compteur_dj_cp = '.$cp.', compteur_dj_ss = '.$ss.' where  ID = '.$id.';   ')) {
                return 1 ;
        }
        else {
            return 0 ;       
        }	
}

function deleteRequests($id)
{
	$connect = new connexion();
	$bdd = $connect->getInstance();	
	$bdd->exec('delete from demie_journee where id_utilisateur = '.$id.';');
}

function deleteRequestbyID($id)
{
	$connect = new connexion();
	$bdd = $connect->getInstance();	
	$bdd->exec('delete from demie_journee where ID_request = '.$id.';');
}


function getFeriebyDate($month, $day)
{
	$connect = new connexion();
	$bdd = $connect->getInstance();
	$luser = $bdd->query(' select * from jours_feries where month(date) = '.$month.' and day(date) = '.$day.';'  );
	$rawdata = $luser->fetch();
		
    return $rawdata;
}

function updatePassword($password)
{
	$connect = new connexion();
	$bdd = $connect->getInstance();
	$luser = $bdd->exec(' update utilisateur set `password` = "'.$password .'" where ID= '.$_SESSION['id'].' ;'  );
	
}


?>
