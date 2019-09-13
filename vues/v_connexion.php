
<div class="wrapper_login">
  <div class="main_login">
    <form class="formulaire_login" method="POST" action="index.php?uc=accueil&action=verifier">

<fieldset>
    <legend>Login : </legend>
    <input class="input_component" id="login" type="text" name="login" oninput="checkLoginFields()"/>
</fieldset>
        
<fieldset>
    <legend>Mot de passe : </legend>
    <input class="input_component" id="password" type="password" name="password" oninput="checkLoginFields()"/>
</fieldset>
        
<input type="button" value="Se connecter" id="ConnectButton" onclick="submit()" class="input_component" disabled>

<?php
if (isset($erreur) && $erreur==1) {
echo '<div class="wrongpassword">L\'adresse mail et/ou le mot de passe ne sont pas corrects</div>' ;
}
?>

    </form>
	  
  </div> 
</div>