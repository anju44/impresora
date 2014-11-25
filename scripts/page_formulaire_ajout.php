<!-- Ce code a été écrit par Julie Meunier dans le cadre d'un stage au Lycée Livet
Pour me contacter en cas de besoin : julie_meunier44@yahoo.fr -->

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<?php
 		include 'header.php';
 	?>
	<body>
		<div id="global">
			<?php
 				include 'menu.php';
 			?>

			<div id="contenu">
				<?php
          //Connexion à la BDD
          try
          {
            $bdd = new PDO('mysql:host=localhost;dbname=imprimantes_livet', 'root', '');
          }
          catch (Exception $e)
          {
            die('Erreur : ' . $e->getMessage());
          }
        ?>

				<!-- Début du formulaire d'ajout d'imprimante -->
				<form action = "" method="POST">
					<fieldset>
						<legend> Identité </legend>
						<table>
							<tr>
								<td><p>Nom : <font color=#FF0000>*</color></p></td>
								<td><input type="text" name="nom" required></td>
							</tr>
							<tr>
								<td><p>IP : <font color=#FF0000>*</color></p></td>
								<td> <input type="text" name="ip" required></td>
							</tr>
							<tr>
								<td><p>ISO : <font color=#FF0000>*</color></p></td>
								<td><input type="text" name="iso" required></td>
							</tr>
						</table>
					</fieldset>
					<fieldset>
						<legend> Caractéristiques </legend>
						<table>
							<tr>
								<td><p>Marque : <font color=#FF0000>*</color></p></td>
								<td>
									<?php
									  // Requête sur la table choisie
									  $req = $bdd->query('SELECT id_marque, marque FROM marque_imprimante');

									  echo'<select name="marqueList">';
									  echo'<option value="0" />';
     
									  while ($donnees = $req->fetch())
									  {     
									    echo '<option value=\'' . $donnees['id_marque'] . '\'>' . $donnees['marque'] . '</option>';
                    }
									     
									  echo'</select>';

									  // Fin de requête
									  $req->closeCursor();
									?>
								</td>
								<td><p>Ou entrer une nouvelle marque :</p></td>
								<td><input type="text" name="marqueFree"></td>						
							</tr>
							<tr>
								<td><p>Modèle : <font color=#FF0000>*</color> </p></td>
								<td>
									<?php
									  // Requête sur la table choisie
									  $req = $bdd->query('SELECT id_modele, modele FROM modele_imprimante');

									  echo'<select name="modeleList">';
									  echo'<option value="0" />';
     
									  while ($donnees = $req->fetch())
									  {     
									    echo '<option value=\'' . $donnees['id_modele'] . '\'>' . $donnees['modele'] . '</option>';
                    }
									     
									  echo'</select>';

									  // Fin de requête
									  $req->closeCursor();
									?>
								</td>
								<td><p>Ou entrer un nouveau modèle :</p></td>
								<td><input type="text" name="modeleFree"></td>
							</tr>
							<tr>
								<td><p>Type : <font color=#FF0000>*</color> </p></td>
								<td>
									<?php
									  // Requête sur la table choisie
									  $req = $bdd->query('SELECT id_type, type FROM type_imprimante');

									  echo'<select name="typeList">';
									  echo'<option value="0" />';
     
									  while ($donnees = $req->fetch())
									  {     
									    echo '<option value=\'' . $donnees['id_type'] . '\'>' . $donnees['type'] . '</option>';
                    }
									     
									  echo'</select>';

									  // Fin de requête
									  $req->closeCursor();
									?>
								</td>
								<td><p>Ou entrer un nouveau type :</p></td>
								<td><input type="text" name="typeFree"></td>
							</tr>
							<tr>
								<td><p>Format : <font color=#FF0000>*</color></p></td>
								<td>
									<?php
									  // Requête sur la table choisie
									  $req = $bdd->query('SELECT id_format, format FROM format_imprimante');

									  echo'<select name="formatList">';
									  echo'<option value="0" />';
     
									  while ($donnees = $req->fetch())
									  {     
									    echo '<option value=\'' . $donnees['id_format'] . '\'>' . $donnees['format'] . '</option>';
                    }
									     
									  echo'</select>';

									  // Fin de requête
									  $req->closeCursor();
									?>
								</td>
								<td><p>Ou entrer un nouveau format :</p></td>
								<td><input type="text" name="formatFree"></td>
							</tr>
						</table>
					</fieldset>
					<fieldset>
						<legend> Localisation </legend>
						<table>
							<tr>
								<td><p>Bâtiment : </p></td>
								<td>
									<select name="batiment">
										<option value="0" />
										<option value="A"> A </option>
										<option value="B"> B </option>
										<option value="D"> D </option>
										<option value="G"> G </option>
										<option value="L"> L </option>
										<option value="R"> R </option>
										<option value="S"> S </option>
										<option value="T"> T </option>
									</select>
								</td>
							</tr>
							<tr>
								<td><p>Salle : </p></td>
								<td><input type="text" name="salle"></td>
							</tr>
						</table>
					</fieldset>
					<input type="hidden" name="essaiEnvoi" value="1" />
					<input type="reset" value="Recommencer" />
					<input type="submit" value="Ajouter" />
				</form>
				<!-- Fin du formulaire d'ajout d'imprimante -->	

				<!-- Début du traitement d'ajout d'imprimante -->
				<?php
					$nom = $_POST['nom'];
					$ip = $_POST['ip'];
					$iso = $_POST['iso'];
					$batiment = $_POST['batiment'];
					$salle = $_POST['salle'];

          $mess = '';

          if(isset($_POST['essaiEnvoi']))
          {
            //Traitement des différents champs
						//Traitement de la marque
            $marque = '';
            if(!empty($_POST['marqueList']))
            {
              $marque = $_POST['marqueList'];
            }
            elseif(!empty($_POST['marqueFree']))
            {
              $marque = htmlspecialchars($_POST['marqueFree']);

              $req = $bdd->prepare('INSERT INTO marque_imprimante (marque) VALUES(:marque)');
              $req->execute(array('marque' => $marque));

              $marque = $bdd->lastInsertId();
            }
            else
            {
              $mess .= 'Marque manquante. <br />';
            }

						//Traitement du modèle
						$modele = '';
            if(!empty($_POST['modeleList']))
            {
              $modele = $_POST['modeleList'];
            }
            elseif(!empty($_POST['modeleFree']))
            {
              $modele = htmlspecialchars($_POST['modeleFree']);

              $req = $bdd->prepare('INSERT INTO modele_imprimante (modele) VALUES(:modele)');
              $req->execute(array('modele' => $modele));

              $modele = $bdd->lastInsertId();
            }
            else
            {
              $mess .= 'Modèle manquant. <br />';
            }

						//Traitement du type
						$type = '';
            if(!empty($_POST['typeList']))
            {
              $type = $_POST['typeList'];
            }
            elseif(!empty($_POST['typeFree']))
            {
              $type = htmlspecialchars($_POST['typeFree']);

              $req = $bdd->prepare('INSERT INTO type_imprimante (type) VALUES(:type)');
              $req->execute(array('type' => $type));

              $type = $bdd->lastInsertId();
            }
            else
            {
              $mess .= 'Type manquant. <br />';
            }

						//Traitement du format
						$format = '';
            if(!empty($_POST['formatList']))
            {
              $format = $_POST['formatList'];
            }
            elseif(!empty($_POST['formatFree']))
            {
              $format = htmlspecialchars($_POST['formatFree']);

              $req = $bdd->prepare('INSERT INTO format_imprimante (format) VALUES(:format)');
              $req->execute(array('format' => $format));

              $format = $bdd->lastInsertId();
            }
            else
            {
              $mess .= 'Format manquant. <br />';
            }

            //Si mess ne contient rien
            if(empty($mess))
            {
              $req = $bdd->prepare('INSERT INTO imprimantes (nom_imprimante, adresse_ip, iso, batiment, salle, type_imprimante, marque_imprimante, modele_imprimante, format_imprimante) VALUES(:nom, :ip, :iso, :batiment, :salle, :type, :marque, :modele, :format)');
              $req->execute(array('nom' => $nom,
																	'ip' => $ip,
																	'iso' => $iso,
																	'batiment' => $batiment,
																	'salle' => $salle,
																	'type' => $type,
																	'marque' => $marque, 
																	'modele' => $modele,
																	'format' => $format));
              $mess .= 'L\'imprimante a bien été ajoutée.';
            }

            //Affichage du message
            echo $mess;				
           }
				?>
				<!-- Fin du traitement du formulaire d'ajout -->

			</div><!-- #contenu -->

			<p id="copyright">
				Développé par Julie Meunier &copy; 2014<br />
				Mise en page &copy; 2008
				<a href="http://www.elephorm.com">Elephorm</a> et
				<a href="http://www.alsacreations.com">Alsacréations</a>
			</p>

		</div><!-- #global -->
		
	</body>
</html>
