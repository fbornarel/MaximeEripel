<?php include('common.php');
$titre='Demande(s) d\'informations';
$emailClient= '';
$infoEmail='';
$infoSujet='';
$infoDemande='';
$errors[]='';
if($_POST)
{	
	$infoSujet = trim($_POST['info_sujet']);
	$infoDemande = trim($_POST['info_demande']);
	$infoEmail= trim($_POST['info_mail']);
	if(empty($infoEmail))
	{
		$errors[]='Veuillez renseigner un Email !';
	}
	if(!filter_var($infoEmail,FILTER_VALIDATE_EMAIL)) {
		$errors[] = "Email invalide !";
	}
	if(empty($infoSujet))
	{
		$errors[]= 'Veuillez indiquer un sujet !';
	}
	if(empty($infoDemande))
	{
		$errors[]= 'Aucun méssage écrit !';
	}
	if(!empty($infoEmail) && !empty(filter_var($infoEmail,FILTER_VALIDATE_EMAIL)) && !empty($infoDemande))
	{
	    $emailTo='fannybornarel@gmail.com';
	   	$infoEmail= $_POST['info_mail'];
	   	$infoSujet= $_POST['info_sujet'];
	   	$infoDemande= $_POST['info_demande'];
	   	$headers = 'MIME-Version: 1.0'."\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
	    mail($emailTo,$infoSujet,$infoDemande,$headers);
	       
 	    $errors[] = 'Demande(s) Envoyée(s)';
	}
	else
	{
		$errors[]= 'Un problème est survenu lors de l\'envoi du mail. Veuillez recommencer !'; 
	}	
}
	if(isset($_SESSION['client_id']))
	{
		$infoEmail= $_SESSION['client_email'];
	}
	else{
		$infoEmail;
	}

$header="headerGlobal";
$template= 'demande';
include('layout.phtml');