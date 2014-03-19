<div class="breadcrumbs">
  	<ul>
    	<li><a href="/../accueil">Accueil</a></li>
    	<li><a href="/../admin">Administration</a></li>
    	<li><a href="/../admin/articles">Gestion des articles</a></li>
    	<li>Modification d'article</li>
  	</ul>
</div>
<?php if($article != false) : ?>
	<?php foreach($article as $info) : ?>
		<h2><?php echo $info['nom']; ?></h2>
		<p><?php echo $this->Html->image('articles/display/'.$info['id'].'.jpg'); ?></p>
		<form method="post" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $info['id']; ?>">
			<select id="categorie" class="form-control span4" name="id_categorie" onchange="call(readSousCategories, 'categorie', 'ajaxSousCategories');">
				<option value="0" class="text-muted">Catégorie</option>
				<?php foreach($categories as $categorie) : ?>
					<option value="<?php echo $categorie['id']; ?>" <?php if($categorie['id'] == $info['id_categorie']){echo 'selected';} ?>><?php echo $categorie['nom']; ?></option>
				<?php endforeach; ?>
			</select>
			<select id="showSousCategorie" class="form-control span4" name="id_sous_categorie">
				<option value="0" class="text-muted">Sous-catégorie</option>
				<?php foreach($sousCategories as $sousCategorie) : ?>
					<option value="<?php echo $sousCategorie['id']; ?>" <?php if($sousCategorie['id'] == $info['id_sous_categorie']){echo 'selected';} ?>><?php echo $sousCategorie['nom']; ?></option>
				<?php endforeach; ?>
			</select>
			<input type="text" class="form-control span4" name="nom" placeholder="Nom" value="<?php echo $info['nom']; ?>">
			<input type="text" class="form-control span4" name="prix" placeholder="Prix" value="<?php echo $info['prix']; ?>">
			<input type="text" class="form-control span4" name="description" placeholder="Description" value="<?php echo $info['description']; ?>">
			<input type="hidden" name="MAX_FILE_SIZE" value="10000000">
			<input type="file" class="form-control span4" name="data[image]">
			<input type="text" class="form-control span4" name="reference" placeholder="Référence" value="<?php echo $info['reference']; ?>">
			<input type="text" class="form-control span4" name="marque" placeholder="Marque" value="<?php echo $info['marque']; ?>">
			<input type="text" class="form-control span4" name="poids" placeholder="Poids" value="<?php echo $info['poids']; ?>">
			<br />
			<button class="success" type="submit">Modifier l'article</button>
			<a href="/../admin/deleteArticle/<?php echo $info['id']; ?>"><button class="warning">Supprimer l'article</button></a>
		</form>
	<?php endforeach; ?>
<?php else : ?>
	<p>Il n'y a aucun article à afficher</p>
<?php endif; ?>