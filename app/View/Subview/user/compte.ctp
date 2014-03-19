<div class="breadcrumbs">
  <ul>
    <li><a href="/../accueil">Accueil</a></li>
    <li><a href="/../user">Mon compte</a></li>
    <li>Mes informations</li>
  </ul>
</div>
<div class="box-element">
	<form class="form-compte" method="post" name="compteForm" onsubmit="return compteValidation();">
		<h3 class="form-compte-heading"><?php echo ucfirst(AuthComponent::user('username')); ?></h3>
		<div class="box-content shadow span6">
			<div class="input-control text size4">
				<input type="email" id="email" class="form-control modifEmail" name="email" placeholder="Adresse email" value="<?php echo AuthComponent::user('email'); ?>" onkeyup="call(readEmail, 'email', 'ajaxSigninEmail');" onchange="call(readEmail, 'email', 'ajaxSigninEmail');" autofocus>
				<input type="hidden" id="userEmail" value="<?php echo AuthComponent::user('email'); ?>">
				<span id="emailAlert"></span>
				<input type="text" id="userNom" class="form-control" name="nom" placeholder="Nom" value="<?php echo AuthComponent::user('nom'); ?>">
				<input type="text" id="userPrenom" class="form-control" name="prenom" placeholder="Prénom" value="<?php echo AuthComponent::user('prenom'); ?>">
				<input type="text" id="userTelephone" class="form-control" name="telephone" placeholder="Téléphone" value="<?php echo AuthComponent::user('telephone'); ?>">
				<input type="text" id="userAdresse" class="form-control" name="adresse" placeholder="Adresse" value="<?php echo AuthComponent::user('adresse'); ?>">
				<select id="departement" class="form-control" onchange="call(readVilles, 'departement', 'ajaxSigninVilles');">
					<option value="0" class="text-muted">Département</option>
					<?php
						foreach($listDepartement as $value):
					?>
					<option value="<?php echo $value['departement']; ?>" <?php if($value['departement'] == $departement){echo 'selected';} ?>><?php echo $value['departement']; ?></option>
					<?php
						endforeach;
					?>
				</select>
				<select name="ville" id="showVilles" class="form-control">
					<option value="0" class="text-muted">Ville</option>
					<?php
						foreach($listVille as $value):
					?>
					<option value="<?php echo $value['id']; ?>" <?php if($value['id'] == AuthComponent::user('ville')){echo 'selected';} ?>><?php echo $value['nom_ville']; ?></option>
					<?php
						endforeach;
					?>
				</select>
				<input type="password" id="password" class="form-control" name="password" placeholder="Nouveau mot de passe (Optionnel)">
			</div>
			<div class="button-compte">
				<button class="info" type="submit" onclick="return confirmModifierCompte()">Modifier mes informations</button>
				<a href="../user/delete" onclick="return confirmSupprimerCompte()"><button class="warning">Supprimer mon compte</button></a>
			</div>
		</div>
	</form>
</div>