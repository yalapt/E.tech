<div class="breadcrumbs">
  <ul>
    <li><a href="/../accueil">Accueil</a></li>
    <li><a href="/../admin">Administration</a></li>
    <li><a href="/../admin/users">Gestion des utilisateurs</a></li>
    <li>Modification d'utilisateur</li>
  </ul>
</div>
<?php foreach ($infos as $info): ?>

<form class="form-compte" method="post" name="compteForm" onsubmit="return compteValidation();">
	<h2 class="form-compte-heading"><?php echo ucfirst($info['username']); ?></h2>
	<input type="email" id="email" class="form-control span4 modifEmail" name="email" placeholder="Adresse email" value="<?php echo $info['email']; ?>" onkeyup="call(readEmail, 'email', 'ajaxSigninEmail');" onchange="call(readEmail, 'email', 'ajaxSigninEmail');" autofocus>
	<input type="hidden" id="userEmail" value="<?php echo $info['email']; ?>">
	<span id="emailAlert"></span>
	<input type="text" id="userNom" class="form-control span4" name="nom" placeholder="Nom" value="<?php echo $info['nom']; ?>">
	<input type="text" id="userPrenom" class="form-control span4" name="prenom" placeholder="Prénom" value="<?php echo $info['prenom']; ?>">
	<input type="text" id="userTelephone" class="form-control span4" name="telephone" placeholder="Téléphone" value="<?php echo $info['telephone']; ?>">
	<input type="text" id="userAdresse" class="form-control span4" name="adresse" placeholder="Adresse" value="<?php echo $info['adresse']; ?>">
	<select id="departement" class="form-control span4" onchange="call(readVilles, 'departement', 'ajaxSigninVilles');">
		<option value="0" class="text-muted">Département</option>
		<?php
			foreach($listDepartement as $value):
		?>
		<option value="<?php echo $value['departement']; ?>" <?php if($value['departement'] == $departement){echo 'selected';} ?>><?php echo $value['departement']; ?></option>
		<?php
			endforeach;
		?>
	</select>
	<select name="ville" id="showVilles" class="form-control span4">
		<option value="0" class="text-muted">Ville</option>
		<?php
			foreach($listVille as $value):
		?>
		<option value="<?php echo $value['id']; ?>" <?php if($value['id'] == $info['ville']){echo 'selected';} ?>><?php echo $value['nom_ville']; ?></option>
		<?php
			endforeach;
		?>
	</select>
	<br />
	<input type="password" id="password" class="form-control span4" name="password" placeholder="Nouveau mot de passe (Optionnel)">
	<br />
	<button class="primary" type="submit" onclick="return confirmModifierCompte()">Modifier les informations</button>
	<a href="/../admin/deleteUser/<?php echo $info['id']; ?>" onclick="return confirmSupprimerCompte()"><button class="warning">Supprimer le compte</button></a>
</form>
<?php endforeach; ?>