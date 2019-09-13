<?php
session_start();
include('connexion.php');
include('gestion_bdd.php');
include('functions.php');
$sens = $_GET['sens'];
$ladateref = new DateTime($_COOKIE['date']);

if ($sens == '1')
{
	$ladateref->modify('+1 month');
}
else if ($sens == '2')
{
	$ladateref->modify('-1 month');
}
$demandes = "";
if ($_SESSION['droits'] == "1")
{
	$CP = getCompteurs($_SESSION['id'])['CP'];
			  $SS = getCompteurs($_SESSION['id'])['SS'];
			  $demandes ='Reserve de jours: <br> CP: '.$CP.' <br> Sans Soldes: '.$SS  ; 
}
			  else
			  {
				  $demandes ='Demandes en attente ce mois-ci: '.getDemandesenAttenteceMois($ladateref->format('m'))['nb_demandes'].' (total: '.getDemandesceMois($ladateref->format('m'))['nb_demandes'].' )';
			  }


setcookie('date', (string)$ladateref->format('Y-m-d'), time() + (86400 * 30), "/");
echo('
    <div class="toolbar">
      <div class="toggle">
       <div class="toggle__option"  onclick="refreshCalendar(2)"><</div> 
        <div class="toggle__option" onclick="refreshCalendar(1)">></div> 
      </div>
      <div class="current-month" >'.$ladateref->format('M').' '.$ladateref->format('Y').'</div>
		  <div class="current-month" >'.$_SESSION['prenom'].' '. $_SESSION['nom'] .'</div>
		  <div class="current-month" >'
	.$demandes.
			 
	'</div>
		  <div class="current-month" >
		  <form action="includes/modele/deconnexion.php" method="get">

				  <input class="input_component" type="submit" value="Se deconnecter">
  
</form>
		  </div>
		  <img src="includes/img/burger.png" class="abecedaire-logo" onclick="openSidebar()" id="burger_menu">

    </div>');

echo('
<div class="calendar" >
<div class="calendar__header">
        <div>lundi</div>
        <div>mardi</div>
        <div>mercredi</div>
        <div>jeudi</div>
        <div>vendredi</div>
        <div>samedi</div>
        <div>dimanche</div>
      </div>');



			echo(dispSemaine($ladateref ));//affiche une ligne en fonction de la semaine dans le moi, et du mois en question (sous forme de date )
			
		
echo('</div>');


?>