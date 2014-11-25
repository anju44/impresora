<?php

// Ce code a été écrit par Julie Meunier dans le cadre d'un stage au Lycée Livet
// Pour me contacter en cas de besoin : julie_meunier44@yahoo.fr 

mysql_connect('localhost', 'root', '');
mysql_select_db('nom_base');

mysql_query("TRUNCATE TABLE compteurs");

$repertoire = '/examples/'; // Aller chercher le répertoire où se trouve les fichiers csv

// On récupère tous les fichiers du dossier passé dans la variable repertoire
$MesFichiers = scandir($repertoire);

// $MesFichiers est un tableau contenant tous les fichiers du répertoire $repertoire
foreach($MesFichiers as $unfichier)
{
	if($unfichier != ".." && $unfichier != ".")
	{
		// Affiche seulement le nom des fichiers
		$ip = substr($unfichier, 0, -4);
		$cmd = "SELECT id_imprimante FROM imprimantes WHERE adresse_ip='$ip'";
		$impr = mysql_query($cmd);
		$row = mysql_fetch_array($impr);
		$result = $row['id_imprimante'];

		// $unfichier contient le nom du fichier, on le concatène avec $repertoire pour avoir le chemin complet
		if (($handle = fopen($repertoire . $unfichier, "r")) !== FALSE)
		{
			while ($data = fgetcsv($handle, 1000, ";"))
			{
				//$data correspond à une ligne complète, nous n'avons plus qu'à la couper pour tout récupérer
				$explode = explode('/', $data[0]);
				$date = $explode[2] . $explode[1] . $explode[0];				

				// On l'insert dans la base
				mysql_query("INSERT INTO compteurs (id_compteur, id_imprimante, date_releve, compteur) 
						VALUES ('', '.$result.', '$date', '$data[1]');") or die(mysql_error());
			}
		
			// On ferme les fichiers
			fclose($handle);
		}		
	}
}

$date_jour = date("d-m-Y");
$heure = date("H:i");
print("Coucou c'est Julie ! Le script s'est bien effectué le $date_jour à $heure ! Bonne journée !" . "\n")

?>
