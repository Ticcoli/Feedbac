<?php


// fonctions qui n'interragissent pas avec la base de donnée
// les noms de variables qui ont deja utilisés ont leur premiere consonne doublée pour éviter les confusions.
//cette fonction definit le premier lundi du mois courant selon la date reference
		function getPremierLundiDuMois($ladate)
		{
			
			$trouve = false;
			$date = new DateTime();// la date de référence
			$date->setDate($ladate->format('Y'), $ladate->format('m'), '15');
		
		$datepremiere = new DateTime();
		while(!$trouve)
		{
			if ($date->format('d')<=7 and $date->format('w')== 1)
			{
				$datepremiere->setDate($date->format('Y'), $date->format('m'), $date->format('d'));
				$trouve = true;
			}
			else 
			{
				$date->modify("-1 day");
			}
			
			
		}
			return $datepremiere;
		}


		//cette fonction définit le premier jour à afficher sur le calendrier, soit le dernier lundi du mois dernier selon la date de réference
		function getPremierLundiAfficher($laddate)
		{
			$ddate = new DateTime();
			$ddate->setDate($laddate->format('Y'), $laddate->format('m'), $laddate->format('d'));//date de réference au sein de la fonction
			$ttrouve = false;// bool pour faire la durée de la boucle
			$premierdumois = getPremierLundiDuMois($ddate);// le premier lundi du moi grâce à la fonction
			
			if ($premierdumois->format('d') <> 1)
			{
				$premierdumois = $premierdumois->modify("-1 day");
			}
			
					while(!$ttrouve)
			{
				if($premierdumois->format('D')<> "Mon" )
				{
					$premierdumois = $premierdumois->modify("-1 day");
				}
				else
				{
					$ttrouve = true;
				}
			}
			
			return $premierdumois;
		}


		function dispSemaine( $unedate)// renvoie le code HTML d'une semaine pour le calendrier? à exetuer 5 fois. PS: le compteur commence à 0
		{
			
			$lesferies = GetJourFeriesdeLan($unedate->format('Y'));//liste desj ours feriés
			
			$lesrepos = GetAllRequests($unedate->format('Y'));
			$string = '';// contiendra le code html
			$numSemaine = 0;
			while ($numSemaine<6)//affiche une par une les 5 lignes du calendrier
		{
			
			//variables
			
			$datedebut = getPremierLundiAfficher($unedate);
			$today =  new \DateTime("now"); // première date de la semaine
			$dddate = new DateTime(); // la date cache
			$semaine = date_interval_create_from_date_string('7 days'); 	//intervale d'une semaine	
			$datefinsemaine = new DateTime();// ce sera la date de la fin de la semaine 
			
			
			$ferie = false;
			/********************************************************************/
			
			//affectiations
			
		
			
			
			$i = 0;
			
			while ($i < $numSemaine)
			{
				
				date_add($datedebut, $semaine);
				
				$i++;
			}		
			$dddate->setDate($datedebut->format('Y'), $datedebut->format('m'), $datedebut->format('d')); // date cache
			$datefinsemaine->setDate($dddate->format('Y'), $dddate->format('m'), $dddate->format('d')); // date de fin de la semaine
			date_add($datefinsemaine, $semaine);
			/********************************************************************/
			
			//géneration du html
			
				$string .=' <div class="calendar__week"> '; //ligne dans le calendrier
			
			
			//parcours de chaque jour de la semaine
			while ($dddate <> $datefinsemaine ) 
			{
				//ouvrir la div du jour..
				
				//si le jour est ferié, mettre la variable ferie a true
				$ferie = false;
				foreach( $lesferies as $leferie)
				{
					if ($dddate->format('d') == $leferie['jour'] and $leferie['mois'] == $dddate->format('m') )
					{						
						$ferie = true;
					}
				}
				
				// si le jour est aujourd'hui, faire une case de type aujourd'hui
				if ($dddate->format('d-m-y') == $today->format('d-m-y'))
				{
					$string .= ' <div class="calendar__today day"> ' ;
				}
				else//sinon, 
				{
					if ($ferie)// si c'est un jour ferié, faire une case de type ferié
					{
						$string .= ' <div class="calendar__ferie day"> ';
					}
					else//si c'est ni aujourd'hui, ni un jour ferié, c'est un jour normal.
					{
						$string .= ' <div class="calendar__day day"> ' ;
					}
				}
				
				//mettre le numéro du jour
				$string.= ' <div class="calendar__daynumber day">'. $dddate->format('d') . '</div>' ;
				
				//ouvrir le conteneur des deux demies journées/du nom de jour ferier
				$string .= ' <div class="calendar__demiday day">';
				
				//si le jour est ferié, on se contente de mettre le nom de l'évènement et on ne scinde pas le jour 
				if ($ferie)
				{
					foreach( $lesferies as $leferie)
					{
						if ($dddate->format('d') == $leferie['jour'] and $leferie['mois'] == $dddate->format('m') )
						{						
							$string.=  '<div class="calendar__nomferie day">'.$leferie['nom'].'</div>';
						}
					}
					
				}
				else //si le jour n'est pas ferié, on le scinde en deux morceaux.
				{
					if ($_SESSION['droits'] == '0' or $dddate->format('w') == 0 or $dddate->format('w') == 6 or $dddate<$today)
					{
						$string .= ' <div class="calendar__matin day"> ';// on ouvre la div du matin
					}
					else
					{
						$string .= ' <div class="calendar__matin day" style="cursor:pointer;" onclick="directNewDay(\''.$dddate->format('Y').'-'.$dddate->format('m').'-'.$dddate->format('d').'\',0 )" > ';// on ouvre la div du matin
					}
					//on affiche si un jour a été pris ce jour la.
					foreach( $lesrepos as $lerepos)
					{
						if ($dddate->format('d') == $lerepos['jour'] and $lerepos['mois'] == $dddate->format('m') and $lerepos['annee'] == $dddate->format('Y') and $lerepos['moment'] == 0  )
						{
							if ($_SESSION['droits'] == '1')
							{
								if($lerepos['id_utilisateur'] == $_SESSION['id'] )
								{
									if(is_null($lerepos['accepte']))
									{
										$string .='<span  onclick="raiseRequestAnwer('.$lerepos['ID_request'].')" style="color:darkgoldenrod;cursor:pointer;">' .$lerepos['type'].'</span>';
									}
									else if ($lerepos['accepte'] == '0')
									{
										$string .='<span onclick="raiseRequestAnwer('.$lerepos['ID_request'].')" style="color:orange">' .$lerepos['type'].'</span>';
									}
									else if ($lerepos['accepte'] == '1')
									{
										$string .='<span onclick="raiseRequestAnwer('.$lerepos['ID_request'].')" style="color:green">' .$lerepos['type'].'</span>';
									}
										
								}
								
							}
							else
								{
								$curUser = getUserbyID($lerepos['id_utilisateur']);
									if(is_null($lerepos['accepte']))
									{
										$string .='<span style="color:darkgoldenrod;cursor:pointer;" onclick="raiseRequestAnwer('.$lerepos['ID_request'].')">' .substr($curUser['prenom'], 0, 1).'. '.$curUser['nom'].' ('.$lerepos['type'].')</span><br>';
									}
									else if ($lerepos['accepte'] == '0')
									{
										$string .='<span style="color:orange;cursor:pointer;" onclick="raiseRequestAnwer('.$lerepos['ID_request'].')">' .substr($curUser['prenom'], 0, 1).'. '.$curUser['nom'].' ('.$lerepos['type'].')</span><br>';
									}
									else if ($lerepos['accepte'] == '1')
									{
										$string .='<span style="color:green;cursor:pointer;" onclick="raiseRequestAnwer('.$lerepos['ID_request'].')">' .substr($curUser['prenom'], 0, 1).'. '.$curUser['nom'].' ('.$lerepos['type'].')</span><br>';
									}
								}
							 					
						}

					}
					$string .= '</div>'; // on ferme la div de l'après midi
					
					if ($_SESSION['droits'] == '0' or $dddate->format('w') == 0 or $dddate->format('w') == 6 or $dddate<$today)
					{
						$string .= ' <div class="calendar__soir day"> ';// on ouvre la div du matin
					}
					else
					{
						$string .= ' <div class="calendar__soir day" style="cursor:pointer;" onclick="directNewDay(\''.$dddate->format('Y').'-'.$dddate->format('m').'-'.$dddate->format('d').'\',1 )" > ';// on ouvre la div du matin
					}
					//on affiche si un jour a été pris ce jour la.
					foreach( $lesrepos as $lerepos)
					{
						if ($dddate->format('d') == $lerepos['jour'] and $lerepos['mois'] == $dddate->format('m') and $lerepos['annee'] == $dddate->format('Y') and $lerepos['moment'] == 1  )
						{
							if ($_SESSION['droits'] == '1')
							{
								if($lerepos['id_utilisateur'] == $_SESSION['id'] )
								{
									if(is_null($lerepos['accepte']))
									{
										$string .='<span  onclick="raiseRequestAnwer('.$lerepos['ID_request'].')" style="color:darkgoldenrod;cursor:pointer;">' .$lerepos['type'].'</span>';
									}
									else if ($lerepos['accepte'] == '0')
									{
										$string .='<span onclick="raiseRequestAnwer('.$lerepos['ID_request'].')" style="color:orange">' .$lerepos['type'].'</span>';
									}
									else if ($lerepos['accepte'] == '1')
									{
										$string .='<span onclick="raiseRequestAnwer('.$lerepos['ID_request'].')" style="color:green">' .$lerepos['type'].'</span>';
									}
										
								}
								
							}
							else
								{
								$curUser = getUserbyID($lerepos['id_utilisateur']);
									if(is_null($lerepos['accepte']))
									{
										$string .='<span style="color:darkgoldenrod;cursor:pointer;" onclick="raiseRequestAnwer('.$lerepos['ID_request'].')">' .substr($curUser['prenom'], 0, 1).'. '.$curUser['nom'].' ('.$lerepos['type'].')</span><br>';
									}
									else if ($lerepos['accepte'] == '0')
									{
										$string .='<span style="color:orange;cursor:pointer;" onclick="raiseRequestAnwer('.$lerepos['ID_request'].')">' .substr($curUser['prenom'], 0, 1).'. '.$curUser['nom'].' ('.$lerepos['type'].')</span><br>';
									}
									else if ($lerepos['accepte'] == '1')
									{
										$string .='<span style="color:green;cursor:pointer;" onclick="raiseRequestAnwer('.$lerepos['ID_request'].')">' .substr($curUser['prenom'], 0, 1).'. '.$curUser['nom'].' ('.$lerepos['type'].')</span><br>';
									}
								}
							 					
						}

					}
					$string .= '</div>'; // on ferme la div de l'après midi
				}
				
				//fermer le conteneur des demie journées/du nom de jour ferié
				$string .= '</div>';
				
				//fermer la boucle et incrémenter
				$string .=' </div> ';//fermer la div de la journée
				$dddate = $dddate->modify("+1 day");
			}
			
			// fermer la div de la semaine 
      		$string .= ' </div>';
			
			
			
			
			
			
			$numSemaine++;
		}
			return $string;
	}






//inserer une nouvelle demande de demie journée dans la BDD a partir des parametres donnés par l'interface 
function newRequest($typeconge, $debut_date, $debut_moment, $fin_date, $fin_moment)
{
	//variables
	$finished = false;//les demies journées ont toutes été posées? 
	$ddatedebut = date_create($debut_date);//debut de la periode de repos
	$datefin = date_create($fin_date);//fin de la periode de repos	
	$momentdebut = null;
	$momentfin = null;
	$congetype = null;
	$toggle = null;
	$interval = null;//intervalle entre les dates de debut et de fin
	$possible = false;
	$datecache = new DateTime();
	$demijoursArray = array();
	$i = 0;
	
	/********************************************************************/
			
			//affectiations
	$intervalle = null;
	
	//donner les bonnes valeurs aux moments de la journée
	if($debut_moment == "MATIN")
	{
		$momentdebut = 0;
	}
	else 
	{
		$momentdebut = 1;
	}
	
	if($fin_moment == "MATIN")
	{
		$momentfin = 0;
	}
	else 
	{
		$momentfin = 1;
	}
	//attribution de la variable de type de congé
	if ($typeconge == "Sans Solde")
	{
		$congetype = "SS";
	}
	else
	{
		$congetype = "CP";
	}	
	
	//mettre la date cache au debut	
	$datecache->setDate($ddatedebut->format('Y'), $ddatedebut->format('m'), $ddatedebut->format('d'));
	
	$toggle = $momentdebut;
	/********************************************************************/

	while(!$finished)
	{	
		if ($datecache->format('Y-m-d') == $datefin->format('Y-m-d') and $toggle == $momentfin )
		{
			$finished = true;
		}
		
		if (!isset(getFeriebyDate($datecache->format('m'),$datecache->format('d'))['commentaire']) and $datecache->format('w') <> 0 and $datecache->format('w') <> 6 and !isset(getDemiJourneebyDateandUser($datecache->format('m'),$datecache->format('d'), $_SESSION['id'])['ID_request']))
		{
			$demijourSousArray = array();
			$demijourSousArray[0] = $datecache->format('Y-m-d');
			$demijourSousArray[1] = $toggle;
			$demijourSousArray[2] = $congetype;
			$demijoursArray[$i] =  $demijourSousArray;
		
		}
		
		
		if ($toggle == 1)
		{
			$datecache->modify('+1 day');
			$toggle-=1; 
		}
		else
		{
			$toggle+=1;
		}	
		$i++;
	}
	
	if (count($demijoursArray)<= getCompteurs($_SESSION['id'])[$congetype] )
	{
		
		foreach($demijoursArray as $lejour)
		{
			insertNewRequest($lejour[0], $lejour[1], $lejour[2], $_SESSION['id']);
			
		}	
		if (count($demijoursArray) == 0)
		{
			return "Aucune demi-journée n'a pu être posée dans cette intervalle.";
		}
		else
			{
				return 'La(les) '.count($demijoursArray).' demi-journée(s) a(ont) bien été ajoutée(s).';
			}
		
	}
	else
	{
		return 'Votre reserve n\'est pas suffisante.';
	}
	
	
	
}

function printUsers()
{
	//vars
	$users = null;
	$droits = '';
	/********************************************************************/
	//attributions
	$users = getAllUsers();
	$reserves = "";
	
	/********************************************************************/
	echo('<div class="wrapper_users">');
	//print
	foreach ($users as $user)
	{
		if ($user['ID'] != $_SESSION['id'])
		{
		//definir les compteurs
		$CP = getCompteurs($user['ID'])['CP'];
		$SS = getCompteurs($user['ID'])['SS'];
		//définir le niveau de droit de l'utilisateur
			if ($user['droits'] == "1")
		{
			$droits = " standards ";
		}
		else 
		{
			$droits = " administrateur ";
		}
		$reserves = "";
		$form = "";
		if ($user['droits'] == 1)
		{
			$reserves = '<div class="utilisateur_barre">
				Demi-journée(s) à poser: <br> <br> '.$CP.' CP <br> <br> '.$SS.' sans soldes
			</div>';
			$form = '<form class="utilisateur_sous_div" method="POST" action="index.php?uc=manage&action=ajouterJour&id='.$user['ID'].'">
					Ajouter 
					<input type="number" min="0" id="nb_demiejourne'.$user['ID'].'" name="nb_demiejourne'.$user['ID'].'" class="input_component"> demi-journées à 
					<select id="type_conge'.$user['ID'].'"  name="type_conge'.$user['ID'].'" class="input_component">
					   <option> CP
					   <option> Sans Solde
					</select>
					<button id="add_confirmer'.$user['ID'].'" class="input_component" onClick="submit()">Confirmer</button>
				</form>';
		}
		else
		{
			$reserves = '<div class="utilisateur_barre"></div>';
				
		}

		
		
		echo('
	
	<div class="utilisateur">
			<div class="utilisateur_barre_1">
				<div class="utilisateur_sous_div">'. $user['prenom'].' '.$user['nom']   .' Matricule: '. $user['Matricule'].' </div> <div class="utilisateur_sous_div" > Mail: '. $user['mail'].'</div>
				
			</div>
			<div class="utilisateur_barre_form">
			
				'.$form.'
				
				<div class="utilisateur_sous_div" > Droits: '.$droits.'</div>
				
			</div>
			'.$reserves.'
			<div class="utilisateur_barre">
				<button id="modifier'.$user['ID'].'" class="input_component" onClick="modifyUser('.$user['ID'].')" >Modifier</button>
			</div>
			<div class="utilisateur_barre">
				<button id="supprimer'.$user['ID'].'" class="input_component" onClick="deleteUser('.$user['ID'].')">Supprimer</button>
			</div>
		  
		  </div>  
	
	');
		
	}
	}
	echo('</div>
	<form method="POST" action="index.php?uc=manage&action=createUser">
            <input type="button" value="Créer Utilisateur" id="buttonCreateUser" onClick="submit()" class="input_component" disabled >
            Prénom : <input class="input_component" id="prenom" type="text" name="prenom" oninput="checkCreateUserFields()"/>
            Nom : <input class="input_component" id="nom" type="text" name="nom" oninput="checkCreateUserFields()"/>
            Adresse Mail : <input class="input_component" id="mail" type="text" name="mail" oninput="checkCreateUserFields()"/>
           Statut : <select id="droits" name="droits" class="input_component" oninput="checkCreateUserFields()">
             <option> Utilisateur
             <option> Administrateur
          </select>
            Matricule : <input class="input_component" id="matricule" type="text" name="matricule" oninput="checkCreateUserFields()"/>
	</form>');
}

function printFerie()
{
	$lesjours = getAllFeries();
	
	foreach ($lesjours as $lejour)
	{
			
		
		$date = new DateTime($lejour['date']);
		
		echo('
		<div class="ferie">
			<div class="ferie_sous_div" >'.
			$date->format('d').' '.$date->format('M')
			.'</div>
			<br>
			<div class="ferie_sous_div" >'.
			$lejour['nom']
			.'</div>
			<button id="supprimerferie'.$lejour['ID'].'" class="input_component" onClick="deleteFerie('.$lejour['ID'].')">Supprimer</button>
		  
		</div> 
	');
	
	}
	
	

}

function printAwaitingRequests($date, $etat, $employe, $type) // generation html des demandes
{
	$demandes = getDemandes($date, $etat, $employe, $type);
	if (count($demandes)> 0 ) {
            foreach ($demandes as $lademande)
            {
		$disabled = '';
		if (is_null($lademande['accepte']) )
		{
			$letat = 'en attente';
		}
		else if ($lademande['accepte'] == '0')
		{
			$letat = 'refusé';
			$disabled = 'disabled';
		}
		else if ($lademande['accepte'] == '1')
		{
			$letat = 'accepté';
			$disabled = 'disabled';
		}
		$ladate = new DateTime($lademande['date']);
		$letype = "";
		if ($lademande["type"] == 'ss')
		{
			$letype = "Sans solde";
		}
		else
		{
			$letype =strtoupper($lademande['type']);
		}
		
		$moment = "";
                if ($lademande['moment'] == 1)
                {
                        $moment = "Après-midi";
                }
                else{
                        $moment = "Matin";
                }
			
				
		echo('
			<div class="utilisateur" name="utilisateur" value="'.$lademande['ID_request'].'">
					<div class="utilisateur_barre_1">
						<div class="utilisateur_sous_div">Requête de '.$letype.' pour le '.$ladate->format('D d M Y').' '.$moment.' </div> 
						<div class="utilisateur_sous_div" > Par '.$lademande['nom'] .' '.$lademande['prenom'].' (Matricule = '.$lademande['Matricule'].') </div>
						<div class="utilisateur_sous_div" > Etat: '.$letat.' </div>
					</div>
					<div class="utilisateur_barre">
						Demi-journées à poser: <br> <br> CP : '.getCompteurs($lademande['id_utilisateur'])['CP'].' <br> <br> Sans soldes : '.getCompteurs($lademande['id_utilisateur'])['SS']  .'
					</div>
					<div class="utilisateur_barre">
						
						<button id="Accepter'.$lademande['ID_request'].'"  class="input_component" href="#" '.$disabled.' onClick="updateRequest('.$lademande['ID_request'].', 1, 0 )"  value="'.$lademande['ID_request'].'" >Accepter</button>
						Commentaire : <input type="text" id="Commentaire'.$lademande['ID_request'].'"  class="input_component" href="#" '.$disabled.' value="'.$lademande['commentaire'].'" >
						<button id="Refuser'.$lademande['ID_request'].'" class="input_component" href="#" '.$disabled.' onClick="updateRequest('.$lademande['ID_request'].', 0, 0 )"  >Refuser</button>
					</div>
				</div>
		');
	}
		}
	else
	{
		echo('Aucune demande ne correspond aux critères.');
	}
	
}

function printAnswerRequest($id)
{
	$request = getRequestbyID($id);
	$user = getUserbyID(getRequestbyID($id)['id_utilisateur']);
	$type = "";
	if ($request['type'] == "ss")
	{
		$type = "Sans solde";
	}
	else
	{
		$type = "CP";
	}
	$ladate = date_create($request['date']);
	$moment = "";
	if ($request['moment'] == 0)
	{
		$moment = "Matin";
	}
	else
	{
		$moment = "Après-midi";
	}
	$disabled = "";
	if (isset($request['accepte']) or $_SESSION['droits'] == 1)
		{
			$disabled = "disabled";
		}
	
	echo('
	<div class="bottomhider"> 
<div class="wrapper_modify_user">
	<div class="toolbar">
		<div class="current_month">Modifier la requête</div>	  
		<img src="includes/img/close.png" class="abecedaire-logo" onclick="closeAnswerForm()" id="burger_menu">
	</div>
	<div class="sous_wrapper_modify_user">
		<div class="column_wrapper_modify_user" >
			<span class="element">Utilisateur : '.$user['prenom'].' '.$user['nom'].'</span>
			<span class="element">Date : '.$ladate->format('D'). ' '.$ladate->format('d'). ' '.$ladate->format('M'). ' '.$ladate->format('Y').'</span>
			<span class="element">Moment : '.$moment.'</span>
			<span class="element">type de congé: '.$type.' </span>
			
			
			
		</div>
		<div class="column_wrapper_modify_user" >
			
			
			
						<span class="element">Compteur CP :'.getCompteurs($user['ID'])['CP'].' </span>
						<span class="element">Compteur Sans solde : '.getCompteurs($user['ID'])['SS'].' </span>
						Commentaire : <input type="text" id="Commentaire'.$request['ID_request'].'"  class="input_component" href="#" '.$disabled.' value="'.$request['commentaire'].'" >');
	if ($_SESSION['droits'] == 0)
	{
		
	if (isset($request['accepte']))
			{
				if ($request['accepte'] == 1 )
				{
					echo('<span >Requête acceptée. </span>
		<span class="element"><button id="Accepter'.$request['ID_request'].'"  class="input_component" href="#" '.$disabled.' onClick="updateRequest('.$request['ID_request'].', 1 , 0)" >Accepter</button>
						<button id="Refuser'.$request['ID_request'].'" class="input_component" href="#" '.$disabled.' onClick="updateRequest('.$request['ID_request'].', 0 ,0 )"  >Refuser</button>
						</span>');
				}
				else
				{
					echo('<span >Requête refusée. </span>
		<span class="element"><button id="Accepter'.$request['ID_request'].'"  class="input_component" href="#" '.$disabled.' onClick="updateRequest('.$request['ID_request'].', 1 , 0)" >Accepter</button>
						<button id="Refuser'.$request['ID_request'].'" class="input_component" href="#" '.$disabled.' onClick="updateRequest('.$request['ID_request'].', 0 ,0 )"  >Refuser</button>
						</span>');

				}
				
			}
			else{
				echo('<span >Requête en attente. </span>
		<span class="element"><button id="Accepter'.$request['ID_request'].'"  class="input_component" href="#" '.$disabled.' onClick="updateRequest('.$request['ID_request'].', 1 , 0)" >Accepter</button>
						<button id="Refuser'.$request['ID_request'].'" class="input_component" href="#" '.$disabled.' onClick="updateRequest('.$request['ID_request'].', 0 ,0 )"  >Refuser</button>
						</span>');
			}
		
	}
	else
	{
		if (isset($request['accepte']))
			{
				if ($request['accepte'] == 1 )
				{
					echo('
						<span class="element"><button id="Modifier'.$request['ID_request'].'" class="input_component" href="#" onClick="deleteRequest('.$request['ID_request'].')" disabled >Requête acceptée</button></span>');
				}
				else
				{
					echo('
						<span class="element"><button id="Modifier'.$request['ID_request'].'" class="input_component" href="#" onClick="deleteRequest('.$request['ID_request'].')" disabled >Requête refusée</button></span>');

				}
				
			}
			else{
				echo('
						<span class="element"><button id="Modifier'.$request['ID_request'].'" class="input_component" href="#" onClick="deleteRequest('.$request['ID_request'].')"  >Annuler cette requête</button></span>');
			}
			
	}
						
	echo('					
	
		</div>
	</div>
</div>	
	</div>
	');
}
function printModifyPassword()
{
	
	
	echo('
	<div class="bottomhider"> 
<div class="wrapper_modify_user">
	<div class="toolbar">
		<div class="current_month">Changer de mot de passe :</div>	  
		<img src="includes/img/close.png" class="abecedaire-logo" onclick="closePasswordForm()" id="burger_menu">
	</div>
	<div class="sous_wrapper_modify_user">
		<div class="column_wrapper_modify_user" >
			<span class="element">Utilisateur : '.$_SESSION['prenom'].' '.$_SESSION['nom'].'</span>
			<span class="element">Ancien mot de passe: </span>
						<span class="element"><input type="password" id="oldPassword"  class="input_component" href="#" oninput="checkChangePassword()" ></span>
						
			
			
			
		</div>
		<div class="column_wrapper_modify_user" >
			
			
			
						
						<span class="element">nouveau mot de passe :  </span>
						<span class="element"><input type="password" id="newPassword"  class="input_component" href="#" oninput="checkChangePassword()" ></span>
						<span class="element">Confirmer le nouveau mot de passe :  </span>
						<span class="element"><input type="password" id="confirmNewPassword"  class="input_component" href="#" oninput="checkChangePassword()" ></span>
						<span class="element"><button id="btUpdatePassword" class="input_component" href="#" onClick="updatePassword()"  disabled >Confirmer</button></span>
						<div class="wrongpassword" id="wrongpassword">!!! Les deux champs ne sont pas identiques pour le nouveau mot de passe !!!</div>');

						
	echo('					
	
		</div>
	</div>
</div>	
	</div>
	');
}

function printRecapitulatif()
{
		$date = new DateTime($_COOKIE['date']);
		$data =  GetJourReposduMoisparUser($date->format('m'));
		$i = 0;
		
		$anarray = array();
	if ($data == null)
	{
		echo('Aucune demi-journée posée ce mois ci.');
	}
		
		foreach($data as $entree)
		{
			$user = array();
			
			if (!isset($anarray[$entree['id_utilisateur']]))
			{
				
				$anarray[$entree['id_utilisateur']] = $user;
				$anarray[$entree['id_utilisateur']]['id'] = $entree['id_utilisateur'];
			$anarray[$entree['id_utilisateur']]['nom'] = $entree['nom'];
			$anarray[$entree['id_utilisateur']]['prenom'] = $entree['prenom'];
			}
			
			if ($entree['accepte'] == null)
			{
				if (isset($entree['nb']) )
				{
					$anarray[$entree['id_utilisateur']]['ea'] = $entree['nb'];
				}
				else
				{
					$anarray[$entree['id_utilisateur']]['ea'] = 0;
				}
				
			}
			else if ($entree['accepte'] == 1)
			{
				if (isset($entree['nb']) )
				{
					$anarray[$entree['id_utilisateur']]['a'] = $entree['nb'];
				}
				else
				{
					$anarray[$entree['id_utilisateur']]['a'] = 0;
				}
			}
			else if ($entree['accepte'] == 0)
			{
				if (isset($entree['nb']) )
				{
					$anarray[$entree['id_utilisateur']]['r'] = $entree['nb'];
				}
				else
				{
					$anarray[$entree['id_utilisateur']]['r'] = 0;
				}
			}
			$i++;
		}
		
		$ea = "";
		$a = "";
		$r = "";

		foreach($anarray as $dispuser)
		{
			if (isset($dispuser['ea']) )
				{
					$ea = $dispuser['ea'];
				}
				else
				{
					$ea = 0;
				}
			if (isset($dispuser['a']) )
				{
					$a = $dispuser['a'];
				}
				else
				{
					$a = 0;
				}
			if (isset($dispuser['r']) )
				{
					$r = $dispuser['r'];
				}
				else
				{
					$r = 0;
				}
			echo('<div class="menu__item" href="index.php?uc=manage">'.
			$dispuser['prenom']. ' '.$dispuser['nom'].' '
			.'<i class="fa fa-clock-o"></i>'.' '.
			$ea
			.'			
			<i class="fa fa-check"></i>'.' '.
			$a
			.'
			<i class="fa fa-times"></i>'. ' '.
			$r
			.'	
			</div> ');
		}
}
?>