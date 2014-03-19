<div class="breadcrumbs">
  <ul>
    <li><a href="/../accueil">Accueil</a></li>
    <li><a href="/../admin">Administration</a></li>
    <li>Gestion des utilisateurs</li>
  </ul>
</div>
<div class="box-element">
	<h3>Liste des utilisateurs</h3>
	<a href="/admin/createUser/"><i>Créer un utilisateur</i></a>
	<div class="grid">
		<div class="box-content shadow span9">
			<div class="row">
				<h4>Administrateur</h4>
				<hr class="hr-users">
				<?php foreach($users as $user): ?>
				<?php if($user['role']) : ?>
				<div>
					<span class="span4 offset1"><?php echo $user['username']; ?></span>
					<button class="primary"><a href="/../admin/editUser/<?php echo $user['id']; ?>">Modifier</a></button>
					<button class="primary"><a href="/../admin/degradeUser/<?php echo $user['id']; ?>">Rétrograder</a></button>
					<button class="warning"><a href="/../admin/deleteUser/<?php echo $user['id']; ?>">Supprimer</a></button>
				</div>
				<hr class="hr-users">
				<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="box-content shadow span9">
			<div class="row">
				<h4>Utilisateur</h4>
				<hr class="hr-users">
				<?php foreach($users as $user): ?>
				<?php if(!$user['role']) : ?>
				<div>
					<span class="span4 offset1"><?php echo $user['username']; ?></span>
					<button class="primary"><a href="/../admin/editUser/<?php echo $user['id']; ?>">Modifier</a></button>
					<button class="primary"><a href="/../admin/gradeUser/<?php echo $user['id']; ?>">Grader</a></button>
					<button class="warning"><a href="/../admin/deleteUser/<?php echo $user['id']; ?>">Supprimer</a></button>
				</div>
				<hr class="hr-users">
				<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>