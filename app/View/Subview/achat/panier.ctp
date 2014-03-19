<div class="breadcrumbs">
  <ul>
    <li><a href="/../accueil">Accueil</a></li>
    <li><a href="/../achat">Achat</a></li>
    <li><a href="/../achat/editAdresse">Adresse de livraison</a></li>
    <li>Panier</li>
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
						<a href="/../accueil/article/<?php echo $article['id']; ?>"><?php echo $article['nom']; ?></a>
					</th>
					<td class="span3">
						Quantité : 
						<a href="/../achat/deleteArticlePanier/<?php echo $article['id']; ?>" title="Soustraire"><img class="icon-plus" src="/img/moins.png"> </a>
						[ <?php echo $this->Session->read('Panier.'.$article['id']); ?> ]
						<a href="/../achat/addArticlePanier/<?php echo $article['id']; ?>" title="Ajouter"> <img class="icon-plus" src="/img/plus.png"></a>
						-
						<a href="/../achat/deleteArticlesPanier/<?php echo $article['id']; ?>" title="Supprimer"> <img class="icon-plus" src="/img/croix.png"></a>
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
	<div class="button-compte">
	<?php if($this->Session->read('nbArticlePanier.nb')) : ?>
		<a href="/../achat/recap"><button class="primary">Continuer</button></a>
	<?php endif; ?>
	</div>
</div>