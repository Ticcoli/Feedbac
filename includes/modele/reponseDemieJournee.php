<?php
session_start();
include('connexion.php');
include('gestion_bdd.php');
$request = $_GET['request'];
$reponse = $_GET['reponse'];
$commentaire = $_GET['commentaire'];
try
{	
	$demiej = getDemiJourneebyID($request);
	reponseDemieJournee($request, $reponse, $commentaire);
	addDemieJournee($demiej['type'], -1, $demiej['id_utilisateur']);
	echo("1");// signaler si la requete a reussie
	
	
	$message = "La demande de ".GetRequestbyID($request)["type"]." pour le ". GetRequestbyID($request)["date"]." a ete ";
	if ($reponse)
	{
		$message .= 'accepté avec le commentaire : "';
	}
	else
	{
		$message .= 'refusé avec le commentaire : "';
	}
	$message .= $commentaire . '" par '. $_SESSION['nom']. ' '. $_SESSION['prenom'];

$headers = "";
$headers .= "From: no-reply@planning-platform.fr \r\n";
$headers .= "X-Mailer: PHP/" . phpversion();
$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Dans le cas où nos lignes comportent plus de 70 caractères, nous les coupons en utilisant wordwrap()
$message = wordwrap($message, 70, "\r\n");

// Envoi du mail
$dest = getUserbyID($demiej['id_utilisateur']) ;
mail($dest['mail'], 'App planning', $message, $headers, '-fno-reply@plateforme-planning.fr');

decreaseHorraireByID($horraire, $nbpart);

echo(getHorraireByID($horraire)['nom']);
	
	
	
}
catch (Exception $e)
{
	echo($e);//signaler si la requete a echoué 
}



?>