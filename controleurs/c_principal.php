<?php
if (!isset($_REQUEST['uc'])) {
    $uc = "accueil" ;
}
else {
    $uc = $_REQUEST['uc'] ;
}

switch ($uc)
{
    case 'accueil' : { 
        include "c_accueil.php" ; 
        break ;
    }
    case 'prof' : { 
        if ($_SESSION['droits'] == "1") {
            include "c_prof.php" ; 
        }
        break ;        
    }
    case 'manage' : { 
        if ($_SESSION['droits'] == "0") {
            include "c_manage.php";            
        }
        break; 
    }
    case 'eleve';{
         if ($_SESSION['droits'] == "2") {
            include "c_eleve.php";            
        }
        break;
    }
	
}
?>