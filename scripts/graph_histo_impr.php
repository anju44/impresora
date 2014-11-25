<?php

// Ce code a été écrit par Julie Meunier dans le cadre d'un stage au Lycée Livet
// Pour me contacter en cas de besoin : julie_meunier44@yahoo.fr 

include ("./jpgraph/src/jpgraph.php");
include ("./jpgraph/src/jpgraph_bar.php");

define('MYSQL_HOST', 'localhost');
define('MYSQL_USER', 'root');
define('MYSQL_PASS', '');
define('MYSQL_DATABASE', 'imprimantes_livet');

// Création des tableaux Date et Compteurs
$tableauDate = array();
$tableauCompteurs = array();

// ************************************************
// Extraction des données dans la base de données *
// ************************************************

// Récupération de l'identifiant d'imprimante choisi dans le formulaire du menu
$id_impr = $_GET['imprimante'];

// Requête permettant de récupérer les compteurs et les dates en fonction de l'imprimante choisie
$sql = <<<EOF
	SELECT	compteur AS COMPT,
		date_releve AS JOUR
	FROM compteurs
	WHERE id_imprimante = '$id_impr'
	ORDER BY date_releve DESC
	LIMIT 0,30
EOF;

// Requête permettant de récupérer le nom de l'imprimante choisie
$nom = <<<EOF
	SELECT nom_imprimante
	FROM imprimantes
	WHERE id_imprimante = '$id_impr'
EOF;

// Requête permettant de récupérer l'adresse ip de l'imprimante choisie
$ip = <<<EOF
	SELECT adresse_ip
	FROM imprimantes
	WHERE id_imprimante = '$id_impr'
EOF;

// Requête récupérant le dernier compteur de chaque imprimante
$compteur = <<<EOF
	SELECT compteur
	FROM compteurs
	WHERE id_imprimante = '$id_impr'
	AND date_releve = (SELECT MAX(date_releve)
			   FROM compteurs)
EOF;

// Connexion à la base de donnée
$mysqlCnx = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS) or die('Problème de connexion mysql');

@mysql_select_db(MYSQL_DATABASE) or die('Problème de sélection de la base');

// Récupération des données de la requête $sql
$mysqlQuery = @mysql_query($sql, $mysqlCnx) or die('Problème de requête');

// Récupération des données de la requête $nom
$result = mysql_query($nom, $mysqlCnx) or die('Problème de requête');
$result2 = mysql_fetch_assoc($result);
$nom_impr = $result2['nom_imprimante'];

// Récupération des données de la requête $ip
$result_ip = mysql_query($ip, $mysqlCnx) or die('Problème de requête');
$result2_ip = mysql_fetch_assoc($result_ip);
$adresse_ip = $result2_ip['adresse_ip'];

// Récupération des données de la requête $compteur
$result_compteur = mysql_query($compteur, $mysqlCnx) or die('Problème de requête');
$result2_compteur = mysql_fetch_assoc($result_compteur);
$dernier_compteur = $result2_compteur['compteur'];

// Boucle sur les dates et compteurs de la table compteurs, en fonction de $sql
while ($row = mysql_fetch_array($mysqlQuery,  MYSQL_ASSOC)) 
{
	$tableauDate[] = ' ' . $row['JOUR'];
	$tableauCompteurs[] = $row['COMPT'];
	$i++;
}


// Calcul de la différence entre les compteurs
$i = 0;
$j = array();

while ($i < (count($tableauCompteurs)-1))
{
	$j[$i] = $tableauCompteurs[$i] - $tableauCompteurs[$i+1];
	$i++;
}


// ***********************
// Création du graphique *
// ***********************


// Construction du conteneur
// Spécification largeur et hauteur
$graph = new Graph(800,500);

// Réprésentation linéaire
$graph->SetScale("textlin");

// Ajouter une ombre au conteneur
$graph->SetShadow();

// Fixer les marges
$graph->img->SetMargin(50,30,70,100); // Gauche, droit, haut, bas

// Création du graphique histogramme
$bplot = new BarPlot($j);

// Spécification des couleurs des barres
$bplot->SetFillGradient('#088A08', '#F5FBEF', GRAD_LEFT_REFLECTION);

// Une ombre pour chaque barre
$bplot->SetShadow();

// Fixer l'aspect de la police
$bplot->value->SetFont(FF_ARIAL,FS_NORMAL,9);

// Ajouter les barres au conteneur
$graph->Add($bplot);

// Afficher les valeurs pour chaque barre
$bplot->value->Show();
$bplot->value->SetFormat('%d'); // Enlève les décimales sur les valeurs

// Le titre
$graph->title->Set("Nom de l'imprimante : " . $nom_impr . "\n Adresse IP : " . $adresse_ip . "\n Dernier compteur : " . $dernier_compteur);
$graph->title->SetFont(FF_FONT1,FS_BOLD);

// Titre pour l'axe horizontal(axe x) et vertical (axe y)
$graph->xaxis->title->Set("Date");
$graph->yaxis->title->Set("Impressions par jour");

$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

// Légende pour l'axe horizontal
$graph->xaxis->SetTickLabels($tableauDate);
$graph->xaxis->SetLabelAngle(45); // Change l'inclinaison de la date


// Afficher le graphique
$graph->Stroke();

?>


