<div class="breadcrumbs">
 	<ul>
    	<li><a href="/../accueil">Accueil</a></span></li>
    	<li><a href="/../admin">Administration</a></span></li>
    	<li><a href="/../admin/users">Gestion des utilisateurs</a></span></li>
    	<li>Création d'utilisateur</li>
  	</ul>
</div>
<div class="box-element">
	<h3>Créer un utilisateur</h3>
	<div class="box-content shadow span9">
		<form class="form-login-signin" method="post" name="signinForm" onsubmit="return signinValidation();">
			<h2 class="form-login-signin-heading"></h2>
			<input type="text" id="username" class="form-control span4" name="username" placeholder="Nom d'utilisateur" onkeyup="call(readName, 'username', 'ajaxSigninName');" onchange="call(readName, 'username', 'ajaxSigninName');" autofocus>
			<span id="usernameAlert"></span>
			<input type="email" id="email" class="form-control span4" name="email" placeholder="Adresse email" onkeyup="call(readEmail, 'email', 'ajaxSigninEmail');" onchange="call(readEmail, 'email', 'ajaxSigninEmail');">
			<span id="emailAlert"></span>
			<input type="password" id="password" class="form-control span4" name="password" placeholder="Mot de passe">
			<input type="text" id="nom" class="form-control span4" name="nom" placeholder="Nom">
			<input type="text" id="prenom" class="form-control span4" name="prenom" placeholder="Prénom">
			<select id="departement" class="form-control span4" onchange="call(readVilles, 'departement', 'ajaxSigninVilles');">
				<option value="0" class="text-muted">Département</option>
				<?php
					foreach($listDepartement as $value):
				?>
				<option value="<?php echo $value['departement']; ?>"><?php echo $value['departement']; ?></option>
				<?php
					endforeach;
				?>
			</select>
			<select name="ville" id="showVilles" class="form-control span4">
					<option value="0" class="text-muted">Ville</option>
			</select>
			<input type="text" id="adresse" class="form-control span4" name="adresse" placeholder="Adresse">
			<input type="text" id="telephone" class="form-control span4" name="telephone" placeholder="Téléphone">
			<br />
			<button class="info" type="submit">Créer un utilisateur</button>
			<br />
		</form>
	</div>
</div>