<div class="breadcrumbs">
	<ul>
    	<li><a href="/../accueil">Accueil</a></li>
  	</ul>
</div>
<div class="box-article">
	<h3>Les articles</h3>
	<?php if(isset($articles)): ?>
	<?php foreach($articles as $article): ?>
	<div class="list article shadow span3">
		<a href="/../accueil/article/<?php echo $article['id']; ?>"><?php echo $this->Html->image('articles/min/'.$article['id'].'.jpg', array('class' => 'icon')); ?></a>
		<span class="list-title"><?php echo $article['nom']; ?></span>
		<p><?php echo $article['description']; ?></p>
		<span class="list-remark">Prix : <?php echo $article['prix']; ?> €</span>
		<p>Vue <?php echo $article['vues']; ?> fois</p>
		<a href="/../accueil/article/<?php echo $article['id']; ?>"><button class="info">Voir</button></a>
		<a href="/../accueil/addArticlePanier/<?php echo $article['id']; ?>"><button class="success">Ajouter</button></a>
	</div>
	<?php endforeach; ?>
	<?php else : ?>
	<div>
		<p>Aucun article à afficher</p>
	</div>
	<?php endif; ?>
</div>