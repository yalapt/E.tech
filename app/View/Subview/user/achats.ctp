<div class="breadcrumbs">
  <ul>
    <li><a href="/../accueil">Accueil</a></li>
    <li><a href="/../user">Mon compte</a></li>
    <li>Mes achats</li>
  </ul>
</div>
<div class="container">
	<h4>Mes Achats</h4>
	<table class="table table-bordered" cellspacing="0">
		<tbody>
		<?php if(isset($achats)) : ?>
		<?php foreach($achats as $achat) : ?>
			<tr class="techSpecRow">
				<th class="span4"><a href="/../user/achat/<?php echo $achat['id']; ?>">Référence : <?php echo $achat['id']; ?></a></th>
				<td >Date : <?php echo UserController::formateDate($achat['date']); ?></td>
			</tr>
		<?php endforeach; ?>
		<?php else : ?>
			<tr class="techSpecRow">
				<th class="span4">Vous n'avez effectué aucun achat</th>
			</tr>
		<?php endif; ?>
		</tbody>
	</table>
</div>