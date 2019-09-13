<?php
session_start();
date_default_timezone_set("Europe/Paris");
include "includes/header.php" ;
include "includes/modele/connexion.php" ;
include "includes/modele/gestion_bdd.php" ;
include "includes/modele/functions.php";
include "controleurs/c_principal.php" ;
include "includes/footer.php" ;
?>
