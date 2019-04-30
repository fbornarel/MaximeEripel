<?php include('common.php');
$titre='Connexion';
$prénom='';
$email='';
$password='';
$errors[]='';
if($_POST)
{ 
	$email = trim($_POST['email']);
	$password = $_POST['password'];
	
	$query = $pdo->prepare('SELECT COUNT(*) FROM clients WHERE email= ?');
	$query->execute([$email]);
	$nbEmail = $query->fetchColumn();
	if($nbEmail == 0)
	{
		$errors[] = 'Email inexistant !';
	} 
	$query = $pdo->prepare('SELECT id, prénom, nom, password FROM clients WHERE email= ?');
	$query->execute([$email]);
	$clientData = $query->fetch();
	$hashedPassword =  $clientData['password'];//mot de passe crypté du client qui cherche à se connecter
	if(password_verify($_POST['password'], $hashedPassword))
	{
		$_SESSION['client_id'] = $clientData['id'];  // stockage de l'id du client connecté
        $_SESSION['client_email'] = $email; // stockage de l'email du client connecté
        $_SESSION['client_prénom'] = $clientData['prénom'];
        $_SESSION['client_nom'] = $clientData['nom'];
        $errors[] = 'Bonjour '.$clientData['prénom'].' !';
    }
     else
    {     
        $errors[] = "Identifiants incorrects"; 
    }    
}
	else
	{
		$errors[] = 'Connectez-vous !';
	}

$header="headerGlobal";
$template = "connexion";
include('layout.phtml');
?>