<div class="breadcrumbs">
  <ul>
    <li><a href="/../accueil">Accueil</a></li>
    <li><a href="/../achat">Achat</a></li>
    <li>Adresse de livraison</li>
  </ul>
</div>
<div class="box-element">
	<form class="form-compte" method="post" name="adresseForm" onsubmit="return compteValidation();">
		<h3 class="form-compte-heading"><?php echo ucfirst(AuthComponent::user('username')); ?></h3>
		<div class="box-content shadow span6">
			<div class="input-control text size4">
				<input type="text" id="userNom" class="form-control" name="nom" placeholder="Nom" value="<?php if($this->Session->read('Adresse')){echo $this->Session->read('Adresse.nom');}else{echo AuthComponent::user('nom');} ?>">
				<input type="text" id="userPrenom" class="form-control" name="prenom" placeholder="Prénom" value="<?php if($this->Session->read('Adresse')){echo $this->Session->read('Adresse.prenom');}else{echo AuthComponent::user('prenom');} ?>">
				<input type="text" id="usertelephone" class="form-control" name="telephone" placeholder="Téléphone" value="<?php if($this->Session->read('Adresse')){echo $this->Session->read('Adresse.telephone');}else{echo AuthComponent::user('telephone');} ?>">
				<input type="text" id="userAdresse" class="form-control" name="adresse" placeholder="Adresse" value="<?php if($this->Session->read('Adresse')){echo $this->Session->read('Adresse.adresse');}else{echo AuthComponent::user('adresse');} ?>">
				<select name="departement" id="departement" class="form-control" onchange="call(readVilles, 'departement', 'ajaxSigninVilles');">
					<option value="0" class="text-muted">Département</option>
					<?php
						foreach($listDepartement as $value):
					?>
					<option value="<?php echo $value['departement']; ?>" <?php if($this->Session->read('Adresse')){if($value['departement'] == $this->Session->read('Adresse.departement')){echo 'selected';}}else{if($value['departement'] == $departement){echo 'selected';}} ?>><?php echo $value['departement']; ?></option>
					<?php
						endforeach;
					?>
				</select>
				<select name ="ville" id="showVilles" class="form-control">
					<option value="0" class="text-muted">Ville</option>
					<?php
						foreach($listVille as $value):
					?>
					<option value="<?php echo $value['id']; ?>" <?php if($this->Session->read('Adresse')){if($value['nom_ville'] == $this->Session->read('Adresse.ville')){echo 'selected';}}else{if($value['id'] == AuthComponent::user('ville')){echo 'selected';}} ?>><?php echo $value['nom_ville']; ?></option>
					<?php
						endforeach;
					?>
				</select>
			</div>
			<div class="button-compte">
				<a href="/../achat/editAdresse"><button class="primary">Continuer</button></a>
			</div>
		</div>
	</form>
</div>