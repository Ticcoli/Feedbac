<?php
session_start();
include('connexion.php');
include('gestion_bdd.php');
$request = $_GET['request'];
try
{	
	$demiej = getDemiJourneebyID($request);
	deleteRequestbyID($request);
	if (isset($demiej['accepte']))
	{
		addDemieJournee($demiej['type'], 1, $demiej['id_utilisateur']);
	}
	
	
	echo("1");// signaler si la requete a reussie
}
catch (Exception $e)
{
	echo($e);//signaler si la requete a echoué 
}



?>