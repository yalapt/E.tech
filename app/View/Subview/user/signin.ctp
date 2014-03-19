<div class="breadcrumbs">
  	<ul>
    	<li><a href="/../accueil">Accueil</a></li>
    	<li>Inscription</li>
  	</ul>
</div>
<div class="inscription offset5 span5 shadow">
	<form class="form-login-signin" method="post" name="signinForm" onsubmit="return signinValidation();">
		<h2 class="form-login-signin-heading">Inscription</h2>
		<div class="input-control text size4">
			<input type="text" id="username" class="form-control" name="username" placeholder="Nom d'utilisateur" onkeyup="call(readName, 'username', 'ajaxSigninName');" onchange="call(readName, 'username', 'ajaxSigninName');" autofocus>
			<span id="usernameAlert"></span>
			<input type="email" id="email" class="form-control" name="email" placeholder="Adresse email" onkeyup="call(readEmail, 'email', 'ajaxSigninEmail');" onchange="call(readEmail, 'email', 'ajaxSigninEmail');">
			<span id="emailAlert"></span>
			<input type="password" id="password" class="form-control" name="password" placeholder="Mot de passe">
			<input type="text" id="nom" class="form-control" name="nom" placeholder="Nom">
			<input type="text" id="prenom" class="form-control" name="prenom" placeholder="Prénom">
			<select id="departement" class="form-control" onchange="call(readVilles, 'departement', 'ajaxSigninVilles');">
				<option value="0" class="text-muted">Département</option>
				<?php
				foreach($listDepartement as $value):
				?>
				<option value="<?php echo $value['departement']; ?>"><?php echo $value['departement']; ?></option>
				<?php
				endforeach;
				?>
			</select>
			<select name="ville" id="showVilles" class="form-control">
				<option value="0" class="text-muted">Ville</option>
			</select>
			<input type="text" id="adresse" class="form-control" name="adresse" placeholder="Adresse">
			<input type="text" id="telephone" class="form-control" name="telephone" placeholder="Téléphone">
			<button class="success valid-btn" type="submit">Inscription</button>
		</div>
		<div class="input-control lien-box">
			<a href="/user/login">Déjà membre ?</a>
		</div>
	</form>
</div>