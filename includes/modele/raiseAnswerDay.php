<?php
session_start();
include('connexion.php');
include('functions.php');
include('gestion_bdd.php');
$request = $_GET['request'];
try
{	
	printAnswerRequest($request);
	//echo("1");// signaler si la requete a reussie
}
catch (Exception $e)
{
	echo($e);//signaler si la requete a echoué 
}



?>