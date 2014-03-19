<div class="breadcrumbs">
  	<ul>
    	<li><a href="/../accueil">Accueil</a></li>
    	<li><a href="/../admin">Administration</a></li>
    	<li>Gestion des catégories</li>
  	</ul>
</div>
<div class="box-element">
	<div class="box-content shadow span9">
		<div class="text size4">
			<h3>Créer une catégorie</h3>
			<form class="categorie" method="post">
				<input type="hidden" name="createCategorie" value="createCategorie">
				<input type="text" class="form-control" name="nom" placeholder="Catégorie">
				<button class="info" type="submit">Créer la catégorie</button>
			</form>
			<h3>Créer une sous-catégorie</h3>
			<form class="sous-categorie" method="post">
				<input type="hidden" name="createSousCategorie" value="createSousCategorie">
				<select name="id_categorie" class="form-control">
					<option value="0" class="text-muted">Catégorie</option>
					<?php if(isset($categories)) : ?>
					<?php foreach($categories as $categorie): ?>
						<option value="<?php echo $categorie['id']; ?>"><?php echo $categorie['nom']; ?></option>
					<?php endforeach; ?>
					<?php endif; ?>
				</select>
				<input type="text" class="form-control span4" name="nom" placeholder="Sous-catégorie">
				<button class="info" type="submit">Créer la sous-catégorie</button>
			</form>
			<div>
				<h3>Liste des catégories</h3>
				<?php if(isset($categories)) : ?>
				<?php foreach($categories as $categorie): ?>
					<form class="categorie" method="post">
						<input type="hidden" name="createCategorie" value="createCategorie">
						<input type="hidden" name="id" value="<?php echo $categorie['id']; ?>">
						<input type="text" class="form-control" name="nom" placeholder="Catégorie" value="<?php echo $categorie['nom']; ?>">
						<button class="primary" type="submit">Modifier</button>
						<button class="warning"><a href="/../admin/deleteCategorie/<?php echo $categorie['id']; ?>">Supprimer</a></button>
					</form>
				<?php endforeach; ?>
				<?php endif; ?>
			</div>
			<div>
				<h3>Liste des sous-catégories</h3>
				<?php if(isset($sousCategories)) : ?>
				<?php foreach($sousCategories as $sousCategorie): ?>
					<form class="sous-categorie" method="post">
						<input type="hidden" name="createSousCategorie" value="createSousCategorie">
						<input type="hidden" name="id" value="<?php echo $sousCategorie['id']; ?>">
						<select name="id_categorie" class="form-control">
							<option value="0" class="text-muted">Catégorie</option>
							<?php if(isset($categories)) : ?>
							<?php foreach($categories as $categorie): ?>
								<option value="<?php echo $categorie['id']; ?>" <?php if($categorie['id'] == $sousCategorie['id_categorie']){echo 'selected';} ?>><?php echo $categorie['nom']; ?></option>
							<?php endforeach; ?>
							<?php endif; ?>
						</select>
						<input type="text" class="form-control" name="nom" placeholder="Sous-catégorie" value="<?php echo $sousCategorie['nom']; ?>">
						<button class="primary" type="submit">Modifier</button>
						<button class="warning"><a href="/admin/deleteSousCategorie/<?php echo $sousCategorie['id']; ?>">Supprimer</a></button>
					</form>
				<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>