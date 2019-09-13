<?php /* date.timezone("Europe/Paris");*/  
	$dateref = new DateTime($_COOKIE['date']); ?>
<div class="wrapper">
  <main id="conteneur">
    <div class="toolbar">
      <div class="toggle">
       <div class="toggle__option"  onclick="refreshCalendar(2)"><</div> 
        <div class="toggle__option" onclick="refreshCalendar(1)">></div> 
      </div>
      <div class="current-month" ><?php echo($dateref->format('M').' '.$dateref->format('Y')); ?></div>
		  <div class="current-month" ><?php echo($_SESSION['prenom'].' '. $_SESSION['nom']); ?></div>
		  <div class="current-month" ><?php if ($_SESSION['droits'] == "1")
{
	$CP = getCompteurs($_SESSION['id'])['CP'];
			  $SS = getCompteurs($_SESSION['id'])['SS'];
			  echo('Reserve de demi-journées: <br> CP: '.$CP.' <br> Sans Soldes: '.$SS  ); 
}
			  else
			  {
				  echo('Demandes en attente ce mois-ci: '.getDemandesenAttenteceMois($dateref->format('m'))['nb_demandes'].' (total: '.getDemandesceMois($dateref->format('m'))['nb_demandes'].' )');
			  }
			  ?></div>
		  <div class="current-month" >
		  <form action="includes/modele/deconnexion.php" method="get">

				  <input class="input_component" type="submit" value="Se deconnecter">
  
</form>
		  </div>
		  <img src="includes/img/burger.png" class="abecedaire-logo" onclick="openSidebar()" id="burger_menu">

    </div>
    <div class="calendar" >
      <div class="calendar__header">
        <div>lundi</div>
        <div>mardi</div>
        <div>mercredi</div>
        <div>jeudi</div>
        <div>vendredi</div>
        <div>samedi</div>
        <div>dimanche</div>
      </div>
		<?php
		
		
			echo(dispSemaine( $dateref));//affiche une ligne en fonction de la semaine dans le moi, et du mois en question (sous forme de date )
			
		 ?>
    </div>
  </main>
	  <?php 
	  if($_SESSION['droits'] == "1")
	  {
		 include "v_menu_user.php" ; 
		  
	  }
	  else
	  {
		  
		  include "v_menu_admin.php";
	  }
	  
	   ?>

</div>
	<div id="answer_div">	  
	</div>
	<?php ?>