<div class="breadcrumbs">
  	<ul>
   		<li><a href="/../accueil">Accueil</a></li>
    	<li><a href="/../admin">Administration</a></li>
    	<li><a href="/../admin/articles">Gestion des articles</a></li>
    	<li>Création d'article</li>
  	</ul>
</div>
<div class="box-element">
	<h3>Créer un article</h3>
	<div class="box-content shadow span8">
		<div class="input-control text size5">
			<form method="post" enctype="multipart/form-data">
				<select id="categorie" class="form-control" name="id_categorie" onchange="call(readSousCategories, 'categorie', 'ajaxSousCategories');">
					<option value="0" class="text-muted">Catégorie</option>
					<?php foreach($categories as $categorie) : ?>
						<option value="<?php echo $categorie['id']; ?>"><?php echo $categorie['nom']; ?></option>
					<?php endforeach; ?>
				</select>
				<select id="showSousCategorie" class="form-control" name="id_sous_categorie">
					<option value="0" class="text-muted">Sous-catégorie</option>
				</select>
				<input type="text" class="form-control" name="nom" placeholder="Nom">
				<input type="text" class="form-control" name="prix" placeholder="Prix">
				<input type="text" class="form-control" name="description" placeholder="Description">
				<input type="hidden" name="MAX_FILE_SIZE" value="10000000">
				<input type="file" class="form-control" name="data[image]">
				<input type="text" class="form-control" name="reference" placeholder="Référence">
				<input type="text" class="form-control" name="marque" placeholder="Marque">
				<input type="text" class="form-control" name="poids" placeholder="Poids">
				<button class="info" type="submit">Créer l'article</button>
			</form>
		</div>
	</div>
</div>