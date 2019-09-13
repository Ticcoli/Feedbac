
<?php
$reponse2 = $bdd->query('SELECT count(*) as nb_article FROM article ');
$donnees2 = $reponse2->fetchAll();

if (isset($_GET['news']))
{
	$_GET['news'] = (int) $_GET['news'];
	if($_GET['news'] > 0)
	{
		$reponse = $bdd->query('SELECT * FROM article WHERE id =\'' .$_GET['news']. '\'');
		$donnees = $reponse->fetch();
		if($donnees['id'] != $_GET['news'])
		{
			header('Location: 404.php');
			exit();
		}
	}
	else
	{
		header('Location: 404.php');
		exit();
	}
	echo(
	'
		<section id="bongrac">
<div id="cont" >
	<h2 id="titre_section"  style="color:#FED136 ;" > Article '.$donnees['type'. $_SESSION['language']] .'</h2>
	<div class="sep"></div>
	<h1 id="titre_article" style="color: black;">'. $donnees['titre'. $_SESSION['language']] .'</h1>
	<h3  class="resume_arti" ; >'. $donnees['date'] .'</h3>
	<img id="banniere" width="90%" height="auto" style="border-width: thin;
	border-color: #FED136;border-style: solid;" src="'. $donnees['image'].'" />
	</br>
	<div class="resume_arti" >
		<p>'. $donnees['texte'. $_SESSION['language']] .'
		</p>
	</div>
	<div class="sep"></div>
	<a href="index.php?uc=article&foreign=1" ><h3 class="link_art">Retour à la liste des articles<h3></a>
</div>
</section>
	'
	);
}
elseif( !isset($_GET['news']) )
{
	if (isset($_GET['type']))
	{
		$_GET['type'] = (string) $_GET['type'];
		$reponse = $bdd->query('SELECT * FROM article WHERE type= \'' .$_GET['type']. '\' ORDER BY date DESC');
	}
	else
	{
		$reponse = $bdd->query('SELECT * FROM article ORDER BY date DESC');
	}
	echo(
	'
		<section id="bongrac">
<div id="cont">
	<h2 id="titre_section">Actualités</h2>
	<h4 id="desc">Développement Digital Audio Workstation</h4>
	<div id="trie">
		<ul class="list_art">
			<li style="color: black"><h4>Trier par :</h4></li>
			<li><a href="index.php?uc=article&foreign=1"><h4 class="list_art_el">TOUS</h4></a></li>
			<li><div class="sep_a"></div></li>
			<li><a href="index.php?uc=article&foreign=1&type=vst"><h4 class="list_art_el">VST</h4></a></li>
			<li><div class="sep_a"></div></li>
			<li><a href="index.php?uc=article&foreign=1&type=daw"><h4 class="list_art_el">DAW</h4></a></li>
			<li><div class="sep_a"></div></li>
			<li><a href="index.php?uc=article&foreign=1&type=autres"><h4 class="list_art_el">AUTRES</h4></a></li>
		</ul>
	</div>');
	 
	while ($donnees = $reponse->fetch())
	{
	echo('
		<a id="link_el" href="index.php?uc=article&news='.$donnees['id'] .'&foreign=1">
		<div class="actu_el">
			<img src="'. $donnees['image'] .'" class="background_art" class="actu" />
			<div class="actu">
				<h2 class="titre_arti" >'. $donnees['titre'. $_SESSION['language']] .'</h2>
				<h4 class="date_arti"   >'. $donnees['date'] .'</h4>
				<p class="resume_arti"   >'. $donnees['resume'. $_SESSION['language']] .'</p>
				<h4 >LIRE LA SUITE ></h4>
			</div>
		</div>
	</a>
	<div class="sep"></div>
	
	');}
	$reponse->closeCursor();
	echo(
	'<a " href="index.php?uc=accueil" ><h3 class="link_art">Retour<h3></a>
</section>
	'
	);
}
	
?>



    <script src="js/agency.min.js"></script>
	
	
	    <!-- Bootstrap core CSS -->
    <link href="includes/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="includes/font/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="includes/css/agency.min.css" rel="stylesheet">
	
	<link rel="stylesheet" href="includes/css/style.css">

