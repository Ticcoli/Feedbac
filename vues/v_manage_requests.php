<div class="wrapper">
    <main>
	<div class="toolbar">
            <div class="current_month">Gérer les demandes.</div>
            <div class="current-month" >
		<form action="includes/modele/deconnexion.php" method="get">
                    <input class="input_component" type="submit" value="Se deconnecter">
		</form>
            </div>
            <div class="current-month" ><?php echo($_SESSION['prenom'].' '. $_SESSION['nom']); ?></div>
            <div class="current-month" >
                <?php 
                $dateref = new DateTime("now");
		
		?>
            </div>
            <img src="includes/img/burger.png" class="abecedaire-logo" onclick="openSidebar()" id="burger_menu">
	</div>
	<div class="requestcontainer">
            <div class="wrapper_manage_requests" id="wrapper_requests">
            <?php 
            printAwaitingRequests('', ' and accepte is null ', '', '') 
            ?>		
            </div>
            <div class="wrapper_feries" >
		<span>Trier par :</span>
		<div class="filtre">
                    <span>Date : </span> <br><br>
                    <span>du :  </span><input type="date" id="startdate" class="input_component" onChange="onFirstFilterDateChanged()" /><br><br>
                    <span>au : </span><input type="date" id="enddate" class="input_component" onChange="onSecondFilterDateChanged()" disabled /><br><br>			
		</div>
		<div class="filtre" >
                    <span>Etat </span> <br><br>
                    <select class="input_component" id="etat">
			<option>En attente</option>
			<option>tous</option>
			<option>Accepté</option>
			<option>Refusé</option>
                    </select>		
		</div>
                <div class="filtre" >
                    <span>Baccalauréat </span> <br><br>
                    <select class="input_component" id="type">
                        <option>tous</option>
                        <option>Scientifique</option>
                        <option>Littéraire</option>
                    </select>		
                </div>
		<div class="input_div">
                    <input type="button" onclick="confirmFilters(1)" id="confirmerfilter" class="input_component" value="Confirmer"/>
                    <input type="button" onclick="resetFilters()" class="input_component" value="Retirer filtres"/>
                </div>
                <div class="filtre" >
                    <span>Repondre à toutes les demandes affichées. </span> <br><br>
                        <input type="button" onclick="answerall(1)" id="confirmerfilter" class="input_component" value="Accepter"/>
                        <input type="text" id="groupComment" class="input_component"/>
                        <input type="button" onclick="answerall(0)" class="input_component" value="Refuser"/>	
		</div>
            </div>
	</div>
    </main>
    <?php 
    if($_SESSION['droits'] == "1") {
        include "v_menu_user.php" ; 
    }
    else {
        include "v_menu_admin.php";
    }
    ?>
</div>  	  
	
	

	 
