<sidebar id="Sidebar" style="display:none;">
    <div class="logo"><?php echo($_SESSION['prenom']. ' '.$_SESSION['nom']); ?> <img src="includes/img/php.png" class="abecedaire-logo" onclick="openSidebar()" id="burger_menu"> </div>
    <div class="avatar">
        <div class="avatar__name"><?php echo($_SESSION['mail']); ?></div>
            <div class="avatar__name">
                <?php 
                if ($_SESSION['droits'] == "1")
                {
                        echo('Utilisateur');
                }
                else
                {
                        echo('Administrateur');
                }
                $ajd = new DateTime('now');
                ?> 
            </div>
            <div class="avatar__name"><?php echo($_SESSION['matricule']); ?> </div>
		
    </div>
	
    <div class="avatar" id="recap">
        <div class="logo">Recapitulatif de  <?php echo($ajd->format('M'). ' : '); ?> </div>
    </div>
   
    <a class="menu__item" href="index.php">
    <i class="menu__icon fa fa-home"></i>
    <span class="menu__text">Accueil</span>
    </a>

    <a class="menu__item" href="index.php?uc=manage">
    <i class="menu__icon fa fa-cogs"></i>
    <span class="menu__text">Gérer le site</span>
    </a>

    <a class="menu__item" href="index.php?uc=manage&action=gererdemande">
    <i class="menu__icon fa fa-envelope-open"></i>
    <span class="menu__text">Gerer les demandes</span>
    </a>

    <a class="menu__item" href="index.php?uc=manage&action=mdp">
        <i class="menu__icon fa fa-sliders"></i>
        <span class="menu__text" >Changer le mot de passe</span>
    </a>
    </nav>
<!--    <div class="copyright">copyright &copy; 2018</div>-->
  </sidebar>

<div id="change_password_div">	  
</div>