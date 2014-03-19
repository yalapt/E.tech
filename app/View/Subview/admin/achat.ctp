<div class="breadcrumbs">
  <ul>
    <li><a href="/../accueil">Accueil</a></li>
    <li><a href="/../admin">Administration</a></li>
    <li><a href="/../admin/achats">Les achats</a></li>
    <li>Achat</li>
  </ul>
</div>
<div class="container">
	<?php foreach($achat as $info) : ?>
	<h4>Informations sur la commande</h4>
	<table class="table table-bordered" cellspacing="0">
		<tbody>
			<tr class="techSpecRow">
				<th class="span4">Référence</th>
				<td ><?php echo $info['id']; ?></td>
			</tr>
			<tr class="techSpecRow">
				<th class="span4">Date</th>
				<td ><?php echo AdminController::formateDate($info['date']); ?></td>
			</tr>
		</tbody>
	</table>
	<h4>Panier</h4>
	<table class="table table-bordered" cellspacing="0">
		<tbody>
			<?php foreach($articleAssocs as $nom => $quantite) : ?>
				<tr class="techSpecRow">
					<th class="span9">
						<?php echo $nom; ?>
					</th>
					<td class="span2">
						Quantité : <?php echo $quantite; ?>
					</td>
					<td class="span2">
					<?php foreach($prixAssocs as $nomArticle => $prix) : ?>
						<?php if($nom == $nomArticle) : ?>
						Prix : <?php echo $prix; ?> €
						<?php endif; ?>
					<?php endforeach; ?>
					</td>
				</tr>
			<?php endforeach; ?>
				<tr class="techSpecRow">
					<th class="span9">Total</th>
					<td class="span2">Quantité : <?php echo $nbArticleTotal; ?> articles
					</td>
					<td class="span2">Prix : <?php echo $prixTotal; ?> €</td>
				</tr>
		</tbody>
	</table>
	<h4>Adresse</h4>
	<table class="table table-bordered" cellspacing="0">
		<tbody>
			<tr class="techSpecRow">
				<th class="span4">Nom</th>
				<td ><?php echo $info['nom']; ?></td>
			</tr>
			<tr class="techSpecRow">
				<th class="span4">Prénom</th>
				<td ><?php echo $info['prenom']; ?></td>
			</tr>
			<tr class="techSpecRow">
				<th class="span4">Département</th>
				<td ><?php echo $info['departement']; ?></td>
			</tr>
			<tr class="techSpecRow">
				<th class="span4">Ville</th>
				<td ><?php echo $info['ville']; ?></td>
			</tr>
			<tr class="techSpecRow">
				<th class="span4">Adresse</th>
				<td ><?php echo $info['adresse']; ?></td>
			</tr>
			<tr class="techSpecRow">
				<th class="span4">Téléphone</th>
				<td ><?php echo $info['telephone']; ?></td>
			</tr>
		</tbody>
	</table>
	<h4>Paiement</h4>
	<table class="table table-bordered" cellspacing="0">
		<tbody>
			<tr class="techSpecRow">
				<th class="span4">Paiement par carte bancaire</th>
				<td ><?php echo AdminController::formateCB($info['cb']); ?></td>
			</tr>
		</tbody>
	</table>
	<?php endforeach; ?>
</div>