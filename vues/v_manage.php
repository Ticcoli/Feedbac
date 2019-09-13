<div class="wrapper">
  <main id="conteneur">
    <div class="toolbar">
        <div class="current_month">Gérer le site.</div>
		  
	<div class="current-month" ><?php echo($_SESSION['prenom'].' '. $_SESSION['nom']); ?></div>
	<div class="current-month" >
            <?php
            $dateref = new DateTime("now");
            if ($_SESSION['droits'] == "1") {
                $CP = getCompteurs($_SESSION['id'])['CP'];
                $SS = getCompteurs($_SESSION['id'])['SS'];
		echo('Reserve de jours: <br> CP: '.$CP.' <br> Sans Soldes: '.$SS  ); 
            }
            else {
                echo('Demandes en attente ce mois-ci: '.getDemandesenAttenteceMois($dateref->format('m'))['nb_demandes'].' (total: '.getDemandesceMois($dateref->format('m'))['nb_demandes'].' )');
            }
            ?>
        </div>
	<div class="current-month" >
            <form action="includes/modele/deconnexion.php" method="get">
                <input class="input_component" type="submit" value="Se deconnecter">
            </form>
        </div>
	<img src="includes/img/burger.png" class="abecedaire-logo" onclick="openSidebar()" id="burger_menu">
    </div>
    <div class="wrapper_manage" id="wrapper_users">
		  
    <?php  
        printUsers(); 
    ?>  
		  
    </div>
	  
    <div class="wrapper_feries" >
        <div class="sous_wrapper_create_feries">
            <form method="POST" action="index.php?uc=manage&action=createFerie">
		<input type="button" value="Créer ferié" id="buttonCreateFerie" onClick="submit()" class="input_component" disabled>
		date : <input class="input_component" id="dateFerie" type="date" name="dateFerie" oninput="checkCreateFerieFields()" min="1000-01-01" max="1000-12-31" value="1000-01-01"/>
		description : <input class="input_component" id="ferieDesc" name="ferieDesc" type="text" oninput="checkCreateFerieFields()"/> (Ne modifier que le mois et le jour)
            </form>
		
	</div>
	<div class="sous_wrapper_feries"id="wrapper_feries">
	<?php 
            printFerie();
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
	  
<div id="manage_user_div">	  
	</div>