<sidebar id="Sidebar" style="display:none;">
    <div class="logo"><?php echo($_SESSION['prenom']. ' '.$_SESSION['nom']); ?> <img src="includes/img/php.png" class="abecedaire-logo" onclick="openSidebar()" id="burger_menu"> </div>
    <div class="avatar">
     <div class="avatar__name"><?php echo($_SESSION['mail']); ?></div>
        <div class="avatar__name">Utilisateur </div>
        <div class="avatar__name"><?php echo($_SESSION['matricule']); ?> </div>
    </div>
	
    <div class="formulaire_ajout_demiejournee">
        <!-- forumaire saisie des congés validé par la fonction JS cinfirmationRequest() -->
        <form action="index.php?uc=user&action=enregistrerConge" method="POST" onsubmit="confirmationRequest()">
            <div class="menu_form_item" >
		<div class="avatar__name">Poser:</div>
                <select id="type_conge" name="type_conge" class="input_component">
                   <option> CP
                   <option> Sans Solde
                </select>
            </div>		
            <div class="menu_form_item" >
                <div class="avatar__name">Du:</div>
                <input type="date" id="startdate" class="input_component" name="debut_periode_date" onchange="onFirstDateChanged()" min="<?php $datemin = date_create('now'); echo($datemin->format('Y-m-d'));?>"  />			
                <select id="momentbegin" name="debut_periode_moment" class="input_component" oninput="checkDate()">
                   <option> MATIN
                   <option> APRES MIDI
                </select>
            </div>
            <div class="menu_form_item" >
                <div class="avatar__name">Au:</div>
                <input type="date" id="enddate" name="fin_periode_date" class="input_component" disabled onchange="onSecondDateChanged()" />		
                <select id="momentend" class="input_component" name="fin_periode_moment">
                   <option> APRES MIDI
                   <option> MATIN
                </select>
            </div>	
		
            <div class="menu_form_item" >		
                <button id="confirmer" class="input_component" type="" onClick="submit()" disabled>Confirmer</button>
            </div>
        </form>

    </div>
    <a class="menu__item" href="index.php?uc=user&action=mdp">
    <i class="menu__icon fa fa-sliders"></i>
    <span class="menu__text" >Changer le mot de passe</span>
    </a>


<!--    <div class="copyright">copyright &copy; 2018</div>-->
  </sidebar>

<div id="change_password_div">	  
</div>