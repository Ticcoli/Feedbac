<?php
$droits = "";
$compteurs = "";
if ($user['droits'] == 0)
{
        $droits = '<option> Admin
                        <option> Standards' ;
}
else
{
        $droits = '<option> Standards
                        <option> Admin' ;
        $compteurs = '<span class="element">CP: 
                <input class="input_component" id="modify_user_compteur_cp" name="modify_user_compteur_cp" value="'.$user['compteur_dj_cp'].'" type="number" oninput="checkModifyUser()"/></span>
                <span class="element">Sans soldes:
                <input class="input_component" id="modify_user_compteur_ss" name="modify_user_compteur_ss" value="'.$user['compteur_dj_ss'].'" type="number" oninput="checkModifyUser()"/></span>';
}
?>
<div class="bottomhider"> 
    <div class="wrapper_modify_user">
	<div class="toolbar">
            <div class="current_month">Gérer l'utilisteur.</div>	  
            <img src="includes/img/close.png" class="abecedaire-logo" onclick="closeForm()" id="burger_menu">
	</div>
        <form action="index.php?uc=manage&action=updateUser&id=<?php echo $id; ?>" method="POST">
	<div class="sous_wrapper_modify_user">
            <div class="column_wrapper_modify_user" >
                <span class="element">Nom : 
                <input class="input_component" id="modify_user_nom" name="modify_user_nom" type="text" value="<?php echo $user['nom']; ?>" oninput="checkModifyUser()"/></span>
                <span  class="element" >Prenom : 
                <input class="input_component" id="modify_user_prenom" name="modify_user_prenom" type="text" value="<?php echo $user['prenom']; ?>" oninput="checkModifyUser()"/></span>
                <span class="element">Matricule : 
                <input class="input_component" id="modify_user_matricule" name="modify_user_matricule" type="text" value="<?php echo $user['Matricule']; ?>" oninput="checkModifyUser()"/></span>
                <span class="element">Mail : 
                <input class="input_component" id="modify_user_mail" name="modify_user_mail" type="email" value="<?php echo $user['mail']; ?>" oninput="checkModifyUser()"/></span>
            </div>
            <div class="column_wrapper_modify_user" >
                <?php echo $compteurs ; ?>

                <span class="element">Droit : 
                <select id="modify_user_droit" name="modify_user_droit" class="input_component" oninput="checkModifyUser()">
                <?php echo $droits ; ?>
                </select></span>
                <button id="modify_user_confirmer" class="input_component" type="" onClick="confirmModifyUser('.$id.')" disabled>Confirmer</button>
	
            </div>
	</div>
        </form>
    </div>	
</div>