<div id="myCarousel" class="carousel slide">
  	<ol class="carousel-indicators">
    	<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    	<li data-target="#myCarousel" data-slide-to="1"></li>
    	<li data-target="#myCarousel" data-slide-to="2"></li>
  	</ol>
  	<!-- Carousel items -->
  	<div class="carousel-inner">
    	<div class="active item"><img src="/img/rog.jpg"></div>
    	<div class="item"><img src="/img/lumia.jpg"></div>
    	<div class="item"><img src="/img/dell.jpg"></div>
  	</div>
  	<!-- Carousel nav -->
  	<a class="carousel-control left" href="#myCarousel" data-slide="prev"><span class="icon-arrow-left-2"></span></a>
  	<a class="carousel-control right" href="#myCarousel" data-slide="next"><span class="icon-arrow-right-2"></span></a>
</div>
<div class="breadcrumbs">
	<ul>
    	<li><a href="/../accueil">Accueil</a></li>
  	</ul>
</div>
<div class="box-article">
	<h3>Les articles</h3>
  <?php if(isset($articles)) : ?>
	<?php foreach($articles as $article): ?>
	<div class="list article shadow">
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
  <p>Aucun article à afficher</p>
  <?php endif; ?>
</div>