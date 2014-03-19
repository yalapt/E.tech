<div class="breadcrumbs">
  <ul>
    <li><a href="/../accueil">Accueil</a></li>
    <li><a href="/../achat">Achat</a></li>
    <li><a href="/../achat/editAdresse">Adresse de livraison</a></li>
    <li><a href="/../achat/editPanier">Panier</a></li>
    <li>Récapitulatif</li>
  </ul>
</div>
<div class="container">
	<h4>Panier</h4>
	<table class="table table-bordered" cellspacing="0">
		<tbody>
			<?php if($articles != false) : ?>
			<?php foreach($articles as $article): ?>
				<tr class="techSpecRow">
					<th class="span9">
						<?php echo $article['nom']; ?>
					</th>
					<td class="span2">
						Quantité : <?php echo $this->Session->read('Panier.'.$article['id']); ?>
					</td>
					<td class="span2">Prix : <?php echo $article['prix']*$this->Session->read('Panier.'.$article['id']); ?> €</td>
				</tr>
			<?php endforeach; ?>
			<?php else : ?>
				<tr class="techSpecRow"><th colspan="2">Aucun article n'a été ajouté au panier</th></tr>
			<?php endif; ?>
				<tr class="techSpecRow">
					<th class="span9">Total</th>
					<td class="span2">Quantité : <?php if(!$this->Session->read('nbArticlePanier.nb')){echo '0';}else{echo $this->Session->read('nbArticlePanier.nb');} ?> articles
					</td>
					<td class="span2">Prix : <?php if(!$this->Session->read('prixArticlePanier.prix')){echo '0';}else{echo $this->Session->read('prixArticlePanier.prix');} ?> €</td>
				</tr>
		</tbody>
	</table>
	<h4>Adresse</h4>
	<table class="table table-bordered" cellspacing="0">
		<tbody>
			<tr class="techSpecRow">
				<th class="span4">Nom</th>
				<td ><?php echo $this->Session->read('Adresse.nom'); ?></td>
			</tr>
			<tr class="techSpecRow">
				<th class="span4">Prenom</th>
				<td ><?php echo $this->Session->read('Adresse.prenom'); ?></td>
			</tr>
			<tr class="techSpecRow">
				<th class="span4">Département</th>
				<td ><?php echo $this->Session->read('Adresse.departement'); ?></td>
			</tr>
			<tr class="techSpecRow">
				<th class="span4">Ville</th>
				<td ><?php echo $this->Session->read('Adresse.ville'); ?></td>
			</tr>
			<tr class="techSpecRow">
				<th class="span4">Adresse</th>
				<td ><?php echo $this->Session->read('Adresse.adresse'); ?></td>
			</tr>
			<tr class="techSpecRow">
				<th class="span4">Téléphone</th>
				<td ><?php echo $this->Session->read('Adresse.telephone'); ?></td>
			</tr>
		</tbody>
	</table>
	<div class="button-compte">
		<a href="/../achat/paiement"><button class="success">Accéder au paiement</button>
	</div>
</div></a>