<div class="bottomhider"> 
    <div class="wrapper_modify_user">
	<div class="toolbar">
            <div class="current_month">Changer de mot de passe :</div>	  
            <img src="includes/img/close.png" class="abecedaire-logo" onclick="closePasswordForm()" id="burger_menu">
	</div>
        <?php
        if ($_SESSION['droits'] == 0)
            echo '<form method="POST" action="index.php?uc=manage&action=modifierMdp">' ;
        else
            echo '<form method="POST" action="index.php?uc=user&action=modifierMdp">' ;
        ?>
	<div class="sous_wrapper_modify_user">
            <div class="column_wrapper_modify_user" >
                <span class="element">Utilisateur : <?php echo $_SESSION['prenom'].' '.$_SESSION['nom']?></span>
                <span class="element">Ancien mot de passe: </span>
		<span class="element"><input type="password" id="oldPassword"  name="oldPassword" class="input_component" href="#" oninput="checkChangePassword()" ></span>
						
		</div>
		<div class="column_wrapper_modify_user" >
                    <span class="element">nouveau mot de passe (au moins 8 caractères) :  </span>
                    <span class="element"><input type="password" id="newPassword"  name="newPassword" class="input_component" href="#" oninput="checkChangePassword()" ></span>
                    <span class="element">Confirmer le nouveau mot de passe :  </span>
                    <span class="element"><input type="password" id="confirmNewPassword"  class="input_component" href="#" oninput="checkChangePassword()" ></span>
                    <span class="element"><button id="btUpdatePassword" class="input_component" href="#" onClick="submit()">Confirmer</button></span>
                    <div class="wrongpassword" id="wrongpassword">!!! Les deux champs ne sont pas identiques pour le nouveau mot de passe !!!</div>
		</div>
	</div>
        </form>
    </div>	
</div>