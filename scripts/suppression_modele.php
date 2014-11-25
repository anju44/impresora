<!-- Ce code a été écrit par Julie Meunier dans le cadre d'un stage au Lycée Livet
Pour me contacter en cas de besoin : julie_meunier44@yahoo.fr -->

<!-- Début du formulaire de suppression d'un modèle d'imprimante -->
<!-- L'action se fait sur la page elle-même, le traitement étant à la fin -->
<form action="page_formulaire_suppression.php" method="POST">
	<fieldset>
		<legend>Suppression d'un modèle d'imprimante</legend>
		<table>
			<tr>
				<td>Choisissez le modèle à supprimer :</td>
				<td>
					<?php
						// Connexion à MySQL
						mysql_connect("localhost", "root", "" );
						mysql_select_db("nom_base" );
	
						// Requête sur la table choisie
						$reponse = mysql_query("SELECT * FROM modele_imprimante ORDER BY modele" ); // Requête pour faire appel à la table "modele_imprimante", et trier par ordre alphabétique

						echo'<select name="modele_suppr">'; // Début du select, intégration de html dans du php
						echo'<option value="0" />';

						// Boucle pour intégrer tous les modèles dans la liste
						while ($donnees = mysql_fetch_array($reponse))
						{
					?>

					<!-- Intégration des options de la liste, recherche par identifiant des modèles, mais affichage du nom -->
					<option value="<?php echo $donnees['id_modele']; ?>"><?php echo $donnees['modele']; ?></option>
     
					<?php
						}

						echo'</select>'; // Fin du select

						// Déconnexion de la base
						mysql_close();
					?>
				</td>
			</tr>
		</table>
	</fieldset>
	<input type="submit" value="Valider la suppression du modèle" />
</form>
<!-- Fin du formulaire de suppression d'un modèle d'imprimante -->

<!-- Début du traitement du formulaire de suppression d'un modèle d'imprimante -->
<?php
	if(isset($_POST['modele_suppr']))
	{
		// Parametres mysql
		define('DB_SERVER', 'localhost'); // serveur mysql
		define('DB_SERVER_USERNAME', 'root'); // nom d utilisateur
		define('DB_SERVER_PASSWORD', ''); // mot de passe
		define('DB_DATABASE', nom_base); // nom de la base

		// Connexion au serveur mysql
		$connect = mysql_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD) or die('Impossible de se connecter : ' . mysql_error());
		// sélection de la base de données
		mysql_select_db(DB_DATABASE, $connect);

		// vérification du remplissage des champs
		$msg_erreur = "Erreur. Les champs suivants doivent être obligatoirement remplis :<br/><br/>";
		$msg_ok = "Le modèle a bien été supprimé."; // confirme l'envoi du formulaire
		$message = $msg_erreur;

		$modele_suppr = $_POST['modele_suppr']; // Récupération du choix de la liste
		// Suppression des données du formulaire dans la base
		$sql = "
   			DELETE FROM modele_imprimante
    		WHERE id_modele = ".$modele_suppr;

		$res = mysql_query($sql);
		if ($res)
		{
			$message=$msg_ok;
		}
		else
		{
			echo mysql_error();
		}
 		echo $message;

	}
?>
<!-- Fin du traitement du formulaire de suppression d'un modèle d'imprimante -->
