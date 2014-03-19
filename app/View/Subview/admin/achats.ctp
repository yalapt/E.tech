<div class="breadcrumbs">
  <ul>
    <li><a href="/../accueil">Accueil</a></li>
    <li><a href="/../admin">Administration</a></li>
    <li>Les achats</li>
  </ul>
</div>
<div class="container">
	<h4>Recherche par utilisateur</h4>
		<form method="post">
			<select name="id_user">
				<option value="0" class="text-muted">Utilisateur</option>
				<?php if(isset($users)) : ?>
				<?php foreach($users as $user): ?>
					<option value="<?php echo $user['id']; ?>" <?php if($user['id'] == $idUser){echo 'selected';} ?>><?php echo $user['username']; ?></option>
				<?php endforeach; ?>
				<?php endif; ?>
			</select>
			<button class="info" type="submit">Rechercher</button>
		</form>
	<h4>Les Achats</h4>
	<table class="table table-bordered" cellspacing="0">
		<tbody>
		<?php if(isset($achats)) : ?>
		<?php foreach($achats as $achat) : ?>
			<tr class="techSpecRow">
				<th class="span4"><a href="/../admin/achat/<?php echo $achat['id']; ?>">Référence : <?php echo $achat['id']; ?></a></th>
				<td >Date : <?php echo AdminController::formateDate($achat['date']); ?></td>
			</tr>
		<?php endforeach; ?>
		<?php else : ?>
			<tr class="techSpecRow">
				<th class="span4">Aucun achat</th>
			</tr>
		<?php endif; ?>
		</tbody>
	</table>
</div>