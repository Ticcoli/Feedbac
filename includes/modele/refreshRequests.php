<?php
session_start();
include('connexion.php');
include('gestion_bdd.php');
include('functions.php');
$date1 = $_GET['date1'];
$date2 = $_GET['date2'];
$employe = $_GET['employe'];
$etat = $_GET['etat'];
$type = $_GET['type'];
$paramdate = "";
$paramemploye = "";
$parametat = "";
$paramtype = "";
$parametat = "";

if ($date1 <> "")// definition du where de la date
{
	$paramdate = ' and date between "'.$date1.'" and "'.$date2.'" ';
}
if (substr($employe, 0, 1) <> "0")
{
	$paramemploye = " and id_utilisateur = ".substr($employe, 0, 1).' ';
}
switch ($etat)
{
		case "En attente" : { 
            $parametat = " and accepte is null ";
            break ;   }	
		case "Accepté" : { 
            $parametat = " and accepte = 1 ";
            break ;   }	
		case "Refusé" : { 
            $parametat = " and accepte  = 0 ";
            break ;   }	
}

if ($type == "CP")
{
	$paramtype = 'and type = "cp" ';
}
else if ($type == "Sans solde")
{
	$paramtype = 'and type = "ss" ';
}

try
{
	
	printAwaitingRequests($paramdate, $parametat,$paramemploye, $paramtype );
}
catch (Exception $e)
{
	echo($e);//signaler si la requete a echoué 
}



?>