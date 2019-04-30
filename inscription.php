<?php include('common.php');
 
$name= '';
$lastName='';
$email='';
$password1='';
$password='';
if($_POST)
{	
	$name= trim($_POST['name']);
	$lastName= trim( $_POST['lastName']);
	$email= trim($_POST['email']);
	$password1= $_POST['password1'];
	$password= $_POST['password'];
	if($name == null)
	{
		$errors[]="Veuillez indiquer un Nom";
	}
	if($lastName == null)
	{
		$errors[]="Veuillez indiquer un Prénom";
	}
	if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
		$errors[] = "Email invalide !";
		$email='';
	}
	$query = $pdo->prepare('SELECT COUNT(*) FROM clients WHERE email= ?');
	$query->execute([$email]);
	$nbEmail = $query->fetchColumn();
	if($nbEmail != 0)
	{
		$errors[] = 'Email déjà existant !';
	}
	$passwordlenght = strlen($password1);
	if($passwordlenght < 8) 
	{  
    	$errors[] = "Votre mot de passe doit faire 8 caractères minimum";
  	}
  	if($password1 != $password)
  	{
  		$errors[] = "Les mots de passe ne correspondent pas !";
  	}
	if(empty($errors))
	{
		$hashedPassword = password_hash($password , PASSWORD_BCRYPT);
		$query = $pdo->prepare('INSERT INTO clients (nom, prénom, email, password) 
								VALUES (:register_name, :register_lastName, :register_email, :register_password)');
		$query->execute(['register_name' => $name, 
						 'register_lastName' => $lastName, 
						 'register_email' => $email, 
						 'register_password' => $hashedPassword]);
		header('Location: connexion.php');	
		exit;					
	}
	else
	{
		$name= trim($_POST['name']);
		$lastName= trim( $_POST['lastName']);	
	}
}

$header="headerGlobal";
$template = "inscription";  
include('layout.phtml');