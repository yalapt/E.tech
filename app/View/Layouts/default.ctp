<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>E.tech - <?php echo $title; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Bienvenue sur e.tech, notre site e-commerce !">
	<?php echo $this->Html->css('metro-bootstrap'); ?>
	<?php echo $this->Html->css('metro-bootstrap-responsive'); ?>
	<?php echo $this->Html->css('bootstrap.min'); ?>
	<?php echo $this->Html->css('style'); ?>
	<?php echo $this->Html->script('jquery-1.11.0.min'); ?>
	<?php echo $this->Html->script('bootstrap.min'); ?>
	<?php echo $this->Html->script('script'); ?>
	<?php echo $this->Html->script('errordocs.js'); ?>
</head>
<body>
	<div class="metro">
		<header class="bg-dark">
			<div class="navigation-bar dark">
			    <div class="navigation-bar-content container dropdown">
			        <a href="/../accueil" class="element"><img class="logo-etech" src="/img/e_tech.png"></a>
			        <ul class="element-menu">
			        <?php if(isset($navCategories)) : ?>
			        <?php foreach($navCategories as $navCategorie) : ?>
			            <li>
			                <a id="dLabel" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo $navCategorie['nom']; ?></a>
			                <ul class="dropdown-menu dark" data-role="dropdown">
			                <?php foreach($navSousCategories as $navSousCategorie) : ?>
			                <?php if($navCategorie['id'] == $navSousCategorie['id_categorie']) : ?>
			                    <li><a href="/../accueil/articles/<?php echo $navSousCategorie['id']; ?>"><?php echo $navSousCategorie['nom']; ?></a></li>
			            	<?php endif; ?>
			                <?php endforeach; ?>
			                </ul>
			            </li>
			        <?php endforeach; ?>
			        <?php endif; ?>
			        </ul>
			        <div class="no-tablet-portrait no-phone">
					<?php if(AuthComponent::user('id')) : ?>
					<ul class="element-menu place-right">
							<li><a href="/../user">Mon compte</a></li>
							<li><a href="/../user/logout"><span class="icon-switch"></span></a></li>
							<li><span class="element-divider"></span></li>
							<li><a href="/../accueil/panier" class="element place-right"><span class="icon-cart-2"> <span>[<?php if(!$this->Session->read('nbArticlePanier.nb')){echo '0';}else{echo $this->Session->read('nbArticlePanier.nb');} ?>] </span><span><?php if(!$this->Session->read('prixArticlePanier.prix')){echo '0';}else{echo $this->Session->read('prixArticlePanier.prix');} ?> €</span></span></a></li>
						</ul>
					<?php endif; ?>
					<?php if(AuthComponent::user('role')) : ?>
						<ul class="element-menu place-right">
							<li><a href="/../admin">Administration</a></li>
						</ul>
					<?php endif; ?>
					<?php if(!AuthComponent::user('id')) : ?>
			            <ul class="element-menu place-right">
			            	<li><a href="/../accueil/panier" class="element place-right"><span class="icon-cart-2"> <span>[<?php if(!$this->Session->read('nbArticlePanier.nb')){echo '0';}else{echo $this->Session->read('nbArticlePanier.nb');} ?>] </span><span><?php if(!$this->Session->read('prixArticlePanier.prix')){echo '0';}else{echo $this->Session->read('prixArticlePanier.prix');} ?> €</span></span></a></li>
			            </ul>
			            <span class="element-divider place-right"></span>
			            <ul class="element-menu place-right">
				            <li>
								<a href="/../user/login">Connexion</a>
							</li>
						</ul>
			            <span class="element-divider place-right"></span>
			            <ul class="element-menu place-right">
				            <li><a href="/../user/signin">Inscription</a></li>
			            </ul>
			            <?php endif; ?>
			            <ul class="element-menu place-right">
				            <li class="search-nav">
				            	<img class="img-search" role="button" data-toggle="dropdown" src="/img/search-nav.png">
				            	<ul class="dropdown-menu dark" data-role="dropdown">
									<div id="tfheader">
										<form id="tfnewsearch" method="post" action="/../accueil">
											<input type="text" class="tftextinput" name="search" size="21" maxlength="120">
										</form>
									</div>
				            	</ul>
				            </li>	
			            </ul>
			        </div>
			    </div>
			</div>
		</header>
		<div id="mainBody" class="container">
			<div id="generalAlert" style="display: none;"></div>
			<?php echo $this->Session->flash(); ?>
			<br>
			<div class="container">
				<?php echo $this->fetch('content'); ?>
			</div>
		</div>
	</div>
	<div id="footer">
		<div class="container">
        	<p class="text-muted credit">Copyright &copy; E.tech - 2014</p>
        </div>
    </div>
    <!-- Load JavaScript Libraries -->
	<?php echo $this->Html->script('jquery-1.11.0.min'); ?>
	<?php echo $this->Html->script('bootstrap.min'); ?>
	<?php echo $this->Html->script('script'); ?>
</body>
</html>