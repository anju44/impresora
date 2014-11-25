<!-- Ce code a été écrit par Julie Meunier dans le cadre d'un stage au Lycée Livet
Pour me contacter en cas de besoin : julie_meunier44@yahoo.fr -->

<div id="entete">
  <p class="nom_site">Impresora</p>
	<h1>
		<img alt="" src="picto/04.png" />
		Lycée Livet
	</h1>
	<p class="sous-titre">
		Suivi de consommation des imprimantes
	</p>
  
</div><!-- #entete -->
	
<div id="navigation">
	<!-- Début du formulaire, liste déroulante des imprimantes-->
	<!-- La page de traitement est l'index lui-même -->
	<form action="index.php" method="POST">
		<table>
			<tr>
				<td>Choisissez une imprimante :</td>
			</tr>
			<tr>
				<td>
					<?php
					// Connexion à MySQL
					mysql_connect("localhost", "root", "" );
					mysql_select_db("nom_base" );
	
					// Requête sur la table choisie
					$reponse = mysql_query("SELECT * FROM imprimantes ORDER BY nom_imprimante" ); // Requête pour faire appel à la table "imprimantes", et trier par ordre alphabétique

					echo'<select name="imprimante">'; // Début du select, intégration de html dans du php

					// Boucle pour intégrer toutes les imprimantes dans la liste
					while ($donnees = mysql_fetch_array($reponse))
					{
					?>

					<!-- Intégration des options de la liste, recherche par identifiant d'imprimantes, mais affichage du nom -->
					<option value="<?php echo $donnees['id_imprimante']; ?>"><?php echo $donnees['nom_imprimante']; ?></option> 
     
					<?php
					}

					echo'</select>'; // Fin du select

					// Déconnexion de la base
					mysql_close();
					?>
				</td>
			</tr>
			<tr>
				<td>
					<!-- Bouton permettant l'envoi du formulaire-->
					<input type="submit" value="Afficher le graphique" />
				</td>
			</tr>
		</table>
	</form>	

	<ul id="menu-vertical">
		<li><a href="index.php">Accueil</a>
		<li><a href="#">Formulaires</a>
			<ul>
				<li><a href="page_formulaire_ajout.php">Ajouter une imprimante</a></li>
				<li><a href="page_formulaire_suppression.php">Suppressions</a></li>
			</ul>
		</li>
	</ul>
</div><!-- #navigation -->
