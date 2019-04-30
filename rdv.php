<?php
include('common.php');
class Date
{
    var $days = array("Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche");
    var $months = array('Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre');
    var $months_num = array('1','2','3','4','5','6','7','8','9','10','11','12');
    var $times = array('10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00');
    
    function getAll($year)
    {
        $r = array();
        $date = strtotime($year.'-01-01');
        while(date('Y',$date) <= $year)
        {
            $w = str_replace('0','7',date('w',$date));
            $d = date('j',$date);
            $m = date('n',$date);
            $y = date('Y',$date);       
            $r[$y][$m][$d] = $w;
            $date = strtotime(date('Y-m-d',$date).'+1 DAY');
        }
        return $r;
    }
}
$date= new Date;
$months_comb = array_combine($date->months, $date->months_num);
$year = strftime('%Y');
$prestation ='';
$date_month ='';
$date_day ='';
$date_rdv='';
$time = '';
$client = '';
$mail='';
$adresse='';
$infoAd='';
$tel='';
if(isset($_SESSION['client_id']))
{
    $client=$_SESSION['client_nom'].' ' .$_SESSION['client_prénom'];
    $mail =$_SESSION['client_email'];
    
    if ($_POST)
    {
        $prestation = $_POST['prestation_option'];
        $date_month = $_POST['months'];
        $date_day = $_POST['day_option'];
        $time = $_POST['time_option'];
        $adresse = $_POST['adresse'];
        $infoAd = $_POST['infoAd'];
        $tel = $_POST['phone'];
        if($date_month == 'null')
        {
            $errors[] = 'Veuillez indiquer un mois';
        }
        else
        {
            $date_month = $months_comb[$date_month];
        }
        if($prestation == 'null')
        {
            $errors[] = 'Veuillez indiquer une prestation';
        }
        if($date_day == null)
        {
            $errors[] = 'Veuillez indiquer un jour';
        }
        if($time == 'null')
        {
            $errors[] = 'Veuillez indiquer une heure';
        }
        if($adresse == null)
        {
            $errors[] = 'Veuillez indiquer une adresse de rdv';
        }
        if($tel == null)
        {
            $errors[] = 'Veuillez indiquer un numéro de téléphone';
        }
        if(strlen($tel)<10)
        {
            $errors[]='Erreur dans le numéro de téléphone';
        }
        
       
        $dateRdvTime = $date_rdv.$time;
        
        $queryRdv = $pdo->prepare('SELECT CONCAT(daterdv, heure) FROM rdv');
        $queryRdv->execute();
        $nbqueryRdv = $queryRdv->fetchColumn();
            
        if($dateRdvTime == $nbqueryRdv)
        {
            $errors[]='Rdv indisponible';
        }
        $date_rdv = $year.'-'.$date_month.'-'.$date_day;
        if(empty($errors))  
        {
            $query = $pdo->prepare('INSERT INTO rdv (client, email, prestation, daterdv, heure, adresse, infoAd, tel)
                                    VALUES ( :client, :email, :prestation_option, :date_rdv, :time_option, :adresse, :infoAd, :phone)');
            
            $query->execute(['client' => $client,
                             'email' => $mail,
                             'prestation_option' => $prestation,
                             'date_rdv' => $date_rdv,
                             'time_option' => $time,
                             'adresse' => $adresse,
                             'infoAd' => $infoAd,
                             'phone' => $tel]);
            $emailTo='fannybornarel@gmail.com';
            $infoEmail= $mail;
            $infoSujet= 'Nouveau RDV';
            $infoDemande= 'Tu as rendez-vous avec '.$client.' ('.$tel.'), le '.$date_rdv.' à '.$time.' pour un '.$prestation.' au '.$adresse.' ('.$infoAd.')';
            $headers = 'MIME-Version: 1.0'."\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
            mail($emailTo,$infoSujet,$infoDemande,$headers);
            $emailTo= $mail;
            $infoEmail= 'fannybornarel@gmail.com';
            $infoSujet= 'Confirmation de votre RDV';
            $infoDemande= 'Vous avez pris rendez-vous avec Maxime le '.$date_rdv.' à '.$time.' pour un '.$prestation.' au '.$adresse.' ('.$infoAd.').' ;
            $headers = 'MIME-Version: 1.0'."\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
            mail($emailTo,$infoSujet,$infoDemande,$headers);
            $errors[]='Votre rendez-vous a bien été enregistré. Un mail de confirmation vous a été envoyé';
        }
    }
}
else
{
    $errors[] = 'Vous devez être connecté pour prendre rendez-vous';
}

$header="headerGlobal";
$template='rdv';
include('layout.phtml');