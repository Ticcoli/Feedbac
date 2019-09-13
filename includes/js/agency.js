
function closeSidebar() { //fermer la barre sur le coté de l'ecrn
	document.getElementById( "burger_menu" ).setAttribute( "onClick", "openSidebar()" );
	var elem = document.getElementById("Sidebar");   
	var div = document.getElementById("conteneur");
  	var pos = 17;	
	var pos0 = 83;

	
	if (elem.style.display != "none")
		{
			var id = setInterval(frame,5);
			var id0=setInterval(frame0,5);
		}
	function frame0() 
	{
		if (pos0 == 97) 
		{
		  clearInterval(id0);
		} 
		else 
		{
		  pos0++; 
		  div.style.width = pos0 + "%"; 
		}
    }
	
	
	function frame() 
	{
		if (pos == 0) 
		{
		  clearInterval(id);
			elem.style.display = "none";
		} 
		else 
		{
		  pos--; 
		  elem.style.width = pos + "%"; 
		}
    }
	
}

function openSidebar() { // ouvrir la barre sur le coté de l'ecran
	document.getElementById( "burger_menu" ).setAttribute( "onClick", "closeSidebar()" );
	var elem = document.getElementById("Sidebar");   
	var div = document.getElementById("conteneur");
	
  	var pos = 0;
  	
	var pos0 = 97
	

	if (elem.style.display == "none")
		{
			elem.style.display = "flex";
			var id = setInterval(frame,5);
			var id0=setInterval(frame0,5);
			
			
		}
	function frame0() 
	{
		if (pos0 == 83) 
		{
		  clearInterval(id0);
		} 
		else 
		{
		  pos0--; 
		  div.style.width = pos0 + "%"; 
		}
    }
	
	function frame() 
	{
		if (pos == 17) 
		{
		  clearInterval(id);
		} 
		else 
		{
		  pos++; 
		  elem.style.width = pos + "%"; 
		}
    }

}


function confirmationRequest() //demander confirmaton avant de créer une demande de demie journée
{
	var firstdate = document.getElementById("startdate");
	var seconddate = document.getElementById("enddate");
   	if(confirm('Êtes vous sur de vouloir créer une demande du '+ firstdate.value + ' au '+ seconddate.value +'?'))	{
            return 1 ;
        }
        else { 
            return 0 ;
        }
}

function onFirstDateChanged()//choses à faire lorsque la date de début de periode commence
{
	
	var firstdate = document.getElementById("startdate");
	var seconddate = document.getElementById("enddate");
	seconddate.disabled = false;
	seconddate.value = firstdate.value;
	seconddate.min = firstdate.value;
	checkDate();
}

function onFirstFilterDateChanged()//choses à faire lorsque la date de début de periode commence
{
	var firstdate = document.getElementById("startdate");
	var seconddate = document.getElementById("enddate");
	var confirmbutton = document.getElementById("confirmerfilter");
	seconddate.disabled = false;
	seconddate.value = firstdate.value;
	seconddate.min = firstdate.value;
	//confirmbutton.disabled = true;
}

function onSecondDateChanged()//chose à faire lorsque la date de fin de periode commence
{
	checkDate();
	var button = document.getElementById("confirmer");
	
	
}

function onSecondFilterDateChanged()//chose à faire lorsque la date de fin de periode commence
{
	var confirmbutton = document.getElementById("confirmerfilter");
	var seconddate = document.getElementById("enddate");
	if(	seconddate.value != "")
		confirmbutton.disabled = false;
}


function checkDate()//eviter les incohérence entre date debut et date fin
{
	var firstdate = document.getElementById("startdate");
	var seconddate = document.getElementById("enddate");
	var firstmoment = document.getElementById("momentbegin");
	var secondmoment = document.getElementById("momentend");
	var button = document.getElementById("confirmer");
	if (firstdate.value == seconddate.value && firstmoment.value == 'Apres-midi' )
		{
			
			secondmoment.value = "Apres-midi";
			secondmoment.disabled = true;
			button.disabled = false;
		}
	else{
		secondmoment.disabled = false;
		if (seconddate.value != "")
			{
				button.disabled = false;
			}
		else
			{
				button.disabled = true;
			}
			
	}

}

//function ConnexionCheck()//call check on database for creentials 
//{
//	var xhttp;
//    var button = document.getElementById("ConnectButton");
//	var login = document.getElementById("login");
//	var password = document.getElementById("password");
//	var wrongpassword = document.getElementById("wrongpassword");
////    return;
//  
//  xhttp = new XMLHttpRequest();
//  xhttp.onreadystatechange = function() {
//    if (this.readyState == 4 && this.status == 200) {
//    if (this.responseText == "1")
//		{
//			wrongpassword.style.display = "none";
//			window.location = 'index.php';
//		}
//		else
//			{
//				wrongpassword.style.display = "block";
//			}
//		console.log(this.responseText);
//		
//    }
//  };
//  xhttp.open("GET", "includes/modele/login.php?login=" +login.value+"&password=" + password.value, true);
//  xhttp.send();
//}

function raiseRequestAnwer(id)
{
		var xhttp;
    var div = document.getElementById("answer_div");

//    return;
  
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    if (this.responseText != "")
		{
			div.innerHTML = this.responseText;
		}
		else
			{
				alert('Une erreur est survenue.');
			}
	
		
    }
  };
  xhttp.open("GET", "includes/modele/raiseAnswerDay.php?request=" +id, true);
  xhttp.send();
}

function checkCreateUserFields()
{
	var button = document.getElementById("buttonCreateUser");
	var prenom = document.getElementById("prenom");
	var nom = document.getElementById("nom");
	var mail = document.getElementById("mail");
	var droits = document.getElementById("droits");
	var matricule = document.getElementById("matricule");
	if (prenom.value != "" && nom.value != "" && mail.value != "" && matricule.value != "")
		{
			button.disabled = false;
			
		}
	else
		{
			button.disabled = true;
		}
	
	
}



function checkCreateFerieFields()
{
	var date = document.getElementById("dateFerie");
	var desc = document.getElementById("ferieDesc");
	var button = document.getElementById("buttonCreateFerie");
	if (desc.value != "" && date.value != "")
		{
			button.disabled = false;
		}
	else
		{
			button.disabled = true;
		}
}



function updateRequest(id, reponse, comsource)
{
	var com = document.getElementById("Commentaire"+id);
	var groupcom = document.getElementById("groupComment");
	var xhttp;
 	

	var commentaire = "";
	if (comsource == 0)
		{
			commentaire = com.value;
		}
	else if (comsource == 1)
		{
			commentaire = groupcom.value;
		}
	console.log(commentaire);
//    return;
  
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    if (this.responseText == "1")
		{
			if(comsource = 0)
				{
					alert("Votre réponse a été prise en compte.");
				}
			
		}
		else
			{
				alert("Une erreur est survenue.");
				console.log(this.responseText);
			}
		
		
		
    }
  };
  xhttp.open("GET", "includes/modele/reponseDemieJournee.php?request=" + id +"&reponse="+reponse+"&commentaire="+commentaire, true);
  xhttp.send();
	wrapper = document.getElementById("wrapper_requests"); 
	if ( wrapper != null && comsource == 0)
		{
			refreshRequests();
		}
	else if (wrapper == null)
	{
		closeAnswerForm();
		refreshCalendar(5);
	}

}

function deleteRequest(id)
{
	
	
	var xhttp;
 
//    return;
  
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    if (this.responseText == "1")
		{
			alert("La(les) demande(s) de demi-journée(s) a(ont) bien été supprimée(s).");
		}
		else
			{
				alert("Une erreur est survenue.");
				console.log(this.responseText);
			}
		
	}
		
  };
	if (confirm('Voulez vous vraiment supprimer cette demande de demi-journée?'))
		{
			xhttp.open("GET", "includes/modele/deleteDemieJournee.php?request=" + id , true);
  			xhttp.send();
		}
 

	  
	  wrapper = document.getElementById("answer_div"); 
	if ( wrapper != null)
		{
		closeAnswerForm();
    }
	refreshCalendar(5);
}


function refreshUsers()
{
	var wrapper = document.getElementById("wrapper_users");
	wrapper.innerHTML = 'Chargement...';
	
	var xhttp;
    var button = document.getElementById("ConnectButton");
//    return;
  
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    if (this.responseText != "")
		{
			wrapper.innerHTML = this.responseText;
		}
		
		
		
    }
  };
  xhttp.open("GET", "includes/modele/reloadUsers.php", true);
  xhttp.send();
}

function refreshFeries()
{
	var wrapper = document.getElementById("wrapper_feries");
	wrapper.innerHTML = 'Chargement...';
	
	var xhttp;
//    return;
  
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    if (this.responseText != "")
		{
			wrapper.innerHTML = this.responseText;
		}
		
		
		
    }
  };
  xhttp.open("GET", "includes/modele/reloadFeries.php", true);
  xhttp.send();
}

function refreshCalendar(sens)
{
	var wrapper = document.getElementById("conteneur");
	wrapper.innerHTML = 'Chargement...';
	
	var xhttp;
//    return;
  
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    if (this.responseText != "")
		{
			wrapper.innerHTML = this.responseText;
		}
    }
  };
	console.log(sens)
  xhttp.open("GET", "includes/modele/reloadCalendrier.php?sens="+sens, true);
  xhttp.send();
	
	//updaterecap();
}


function resetFilters()
{
	
	var date1 = document.getElementById("startdate");
	var date2 = document.getElementById("enddate");
	var etat = document.getElementById("etat");
	var type = document.getElementById("type");
	var employe = document.getElementById("employe")
	date1.value = "";
	date2.value = "";
	etat.selectedIndex = 0;
	type.selectedIndex = 0;
	employe.selectedIndex = 0;
	refreshRequests();
	
}

function refreshRequests()
{
	var date1 = document.getElementById("startdate");
	var date2 = document.getElementById("enddate");
	var etat = document.getElementById("etat");
	var type = document.getElementById("type");
	var select = $("#employe option:selected").attr('value');
	var wrapper = document.getElementById("wrapper_requests");
	//var id =  $(this).find('option:employe').
	wrapper.innerHTML = 'Chargement...';
	var xhttp;
//    return;
  
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    if (this.responseText != "")
		{
			wrapper.innerHTML = this.responseText;
		}

		
		
		
    }
  };
  xhttp.open("GET", "includes/modele/refreshRequests.php?date1=" + date1.value + "&date2=" + date2.value + "&employe=" + select + "&etat=" +etat.value + "&type=" + type.value, true);
  xhttp.send();
}

function confirmFilters()
{
	refreshRequests();
}

function checkLoginFields()
{
	    var button = document.getElementById("ConnectButton");
	var login = document.getElementById("login");
	var password = document.getElementById("password");
	if (login.value == '' || password.value == '')
		{
			button.disabled = true;
		}
	else{
			button.disabled = false;
		}
}

function ajouterJour(id)
{
	var user = String(id);
	
	
	var nb = document.getElementById("nb_demiejourne"+user);
	var type = document.getElementById("type_conge"+user);
	
	var xhttp;
 
//    return;
  
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    if (this.responseText.substr(-1) == "1")
		{
			alert(nb.value+" demi-journée(s) ajoutée(s) aux " + type.value + " de l'utilisateur.");
		}
		else
			{
				alert("Echec, les demi-journées n'ont pas été ajoutées.");
				console.log(this.responseText)
			}
		
	
		
    }
  };
  xhttp.open("GET", "includes/modele/addDays.php?user="+user+"&nb="+ nb.value +"&type="+type.value, true);
  xhttp.send();
	
	refreshUsers();
	
}

function deleteUser(id)
{
    if(confirm('Êtes vous sur de vouloir supprimer cet utilisateur?')) {
        document.location.href="index.php?uc=manage&action=deleteUser&id=" + id ;
    }
}
  
function deleteFerie(id)
{

    if(confirm('Êtes vous sur de vouloir supprimer ce jour ferié?')) {
        document.location.href="index.php?uc=manage&action=deleteFerie&ferie=" + id ;
    }
}

function closeForm()
{
	document.location.href="index.php?uc=manage" ;
}

function closeAnswerForm()
{
	var div = document.getElementById('answer_div');
	div.innerHTML = "";
}

function checkModifyUser()
{
	var nom = document.getElementById('modify_user_nom');
	var prenom = document.getElementById('modify_user_prenom');
	var matricule = document.getElementById('modify_user_matricule');
	var mail = document.getElementById('modify_user_mail');
	var compteur_cp = document.getElementById('modify_user_compteur_cp');
	var compteur_ss = document.getElementById('modify_user_compteur_ss');
	var droit = document.getElementById('modify_user_droit');
	var button = document.getElementById('modify_user_confirmer');
	
	if (mail.value != "" /*&& compteur_cp.value != '' && compteur_ss.value != ''*/ && nom.value != "" && prenom.value != "" && matricule.value != "")
		{
			button.disabled = false;
		}
	else {
		button.disabled = true;
	}
}

function confirmModifyUser(id)
{
	var nom = document.getElementById('modify_user_nom');
	var prenom = document.getElementById('modify_user_prenom');
	var matricule = document.getElementById('modify_user_matricule');
	var mail = document.getElementById('modify_user_mail');
	var compteur_cp = document.getElementById('modify_user_compteur_cp');
	var compteur_ss = document.getElementById('modify_user_compteur_ss');
	var droit = document.getElementById('modify_user_droit');
	var button = document.getElementById('modify_user_confirmer');
	
	if (mail.value != "" && parseInt(compteur_cp.value) && parseInt(compteur_ss.value) && nom.value != "" && prenom.value != "" && matricule.value != "")
		{
			xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    if (this.responseText == '1')
		{
			console.log('reussite!');
		}
		else
			{
				
				console.log(this.responseText)
			}
		
	
		
    }
  };
  xhttp.open("GET", "includes/modele/confirmModifierUtilisateur.php?user="+id +"&nom=" + nom.value +"&prenom=" + prenom.value +"&matricule=" + matricule.value +"&mail=" + mail.value +"&compteur_cp=" + compteur_cp.value +"&compteur_ss=" + compteur_ss.value +"&droit=" + droit.value, true);
  xhttp.send();
			
		}
	else
		{
			alert("Une erreur est survenue");
		}
	
	
	refreshUsers();
	closeForm();
}

function modifyUser(id)
{
    document.location.href="index.php?uc=manage&action=modifyUser&id=" + id ;	
}

function directNewDay(jour, toggle)
{
	var sidebar = document.getElementById("Sidebar");
	if (sidebar.style.display == "none")
		{
			openSidebar();
		}
		
	
	var firstdate = document.getElementById("startdate");
	var seconddate = document.getElementById("enddate");
	var firstmoment = document.getElementById("momentbegin");
	var secondmoment = document.getElementById("momentend");
	var type_conge = document.getElementById("type_conge");
	var button = document.getElementById("confirmer");
	firstdate.value = jour;
	if (toggle == 1)
		{
				firstmoment.value = "APRES MIDI";
		}
	else
		{
			firstmoment.value = "MATIN";
		}
	onFirstDateChanged();
	onSecondDateChanged();
}


function showChangePassword()
{
	var div = document.getElementById("change_password_div");
	var xhttp;

//    return;
  
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    if (this.responseText != "")
		{
			div.innerHTML = this.responseText;
		}
		else
			{
				alert('Une erreur est survenue.');
			}
	
		
    }
  };
  xhttp.open("GET", "includes/modele/raiseChangerMdp.php", true);
  xhttp.send();
}

//function updatePassword()
//{
//	var oldPassword = document.getElementById("oldPassword");
//	var newPassword = document.getElementById("newPassword");
//	var confirmnewPassword = document.getElementById("confirmNewPassword");
//	var div = document.getElementById("change_password_div");
//	var xhttp;
//
////    return;
//  
//  xhttp = new XMLHttpRequest();
//  xhttp.onreadystatechange = function() {
//    if (this.readyState == 4 && this.status == 200) {
//    if (this.responseText != "")
//		{
//			alert(this.responseText);
//		}
//		else
//			{
//				alert('Une erreur est survenue.');
//			}
//	
//		
//    }
//  };
//  xhttp.open("GET", "includes/modele/updatePassword.php?oldPswrd=" +oldPassword.value+"&newPswrd="+newPassword.value  , true);
//  xhttp.send();
//	
//	div.innerHTML = "";
//}

function closePasswordForm()
{
	document.location.href = "index.php?uc=accueil" ;
}

function checkChangePassword()
{
	var oldPassword = document.getElementById("oldPassword");
	var newPassword = document.getElementById("newPassword");
	var confirmnewPassword = document.getElementById("confirmNewPassword");
	var btUpdatePassword = document.getElementById("btUpdatePassword");
	var wrongpassword = document.getElementById("wrongpassword");
	var test = false;
	if (newPassword.value == confirmnewPassword.value)
		{
			test = true;
			wrongpassword.style.display = "none";
		}
	else
		{
			wrongpassword.style.display = "block";
		}
	
	if (newPassword.value.length >= 8 && test && oldPassword.value != "")
		{
			btUpdatePassword.disabled = false;
		}
	else
		{
			btUpdatePassword.disabled = true;
		}
}


function updaterecap()
{
	var div = document.getElementById("recap");
	var xhttp;

//    return;
  
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    if (this.responseText != "")
		{
			div.innerHTML = this.responseText;
		}
		else
			{
				alert('Une erreur est survenue.');
				
			}
	
		
    }
  };
  xhttp.open("GET", "includes/modele/reloadRecapitulatif.php", true);
  xhttp.send();
}

function answerall(answer)
{
	
	var elements = document.getElementsByTagName("button")
	var div = document.getElementById("wrapper_requests");
	console.log( elements.length);
	if (confirm('Etes vous sur de vouloir répondre à toutes ces requêtes ?'))
		{
			nbmax = elements.length;
for (var i = 0; i < nbmax ; i++) {
    if(elements[i].disabled == false && typeof elements[i].attributes['value'] !== 'undefined') {
		

		
        updateRequest(elements[i].attributes['value'].value, answer, 1);
		console.log('test');
    }
		}
alert("Traitement terminé!");
}
	refreshRequests();
}


function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}

