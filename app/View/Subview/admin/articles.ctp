<div class="breadcrumbs">
  	<ul>
    	<li><a href="/../accueil">Accueil</a></li>
    	<li><a href="/../admin">Administration</a></li>
    	<li>Gestion des articles</li>
  	</ul>
</div>
<div class="box-element">
	<h3>Les articles</h3>
	<a href="/../admin/createArticle"><i>Créer un article</i></a>
	<div class="grid">
		<div class="box-content shadow span9">
			<?php if($articles != false) : ?>
			<?php foreach($articles as $article): ?>
			<div class="row">
				<a href="/../accueil/article/<?php echo $article['id']; ?>" class="span2 offset1"><?php echo $article['nom']; ?></a>
				<div class="button-edit offset2">
					<a href="/../admin/article/<?php echo $article['id']; ?>"><button class="primary">Modifier</button></a>
					<a href="/../admin/deleteArticle/<?php echo $article['id']; ?>"><button class="warning">Supprimer</button></a>
				</div>
			</div>
			<hr class="hr-users">
			<?php endforeach; ?>
			<?php else : ?>
				<p>Il n'y a aucun article</p>
			<?php endif; ?>
		</div>
	</div>
</div>