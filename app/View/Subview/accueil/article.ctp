<div class="breadcrumbs">
    <ul>
        <li><a href="/../accueil">Accueil</a></span></li>
        <li>Article</li>
    </ul>
</div>
<div class="box-element">
    <?php if(isset($article)) : ?>
    <?php foreach ($article as $value) : ?>
    <h2><span class="title-article"><?php echo $value['nom']; ?></span></h2>
    <div class="list">
        <!-- Modal -->
        <div class="modal fade" id="article" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <?php echo $this->Html->image('articles/'.$value['id'].'.jpg'); ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->
        <span class="article-apercu" data-toggle="modal" data-target="#article"><?php echo $this->Html->image('articles/display/'.$value['id'].'.jpg'); ?></span>
        <div class="info-right">
            <div class="info-prix">
                <span><span class="prix-etech">PRIX E.TECH :</span><br> <?php echo $value['prix'];?> € TTC</span>
            </div>
            <div class="info-add">
            <form method="post" action="/../accueil/addArticlesPanier">
                <input type="hidden" name="id" value="<?php echo $value['id']; ?>">
                <input class="nb-article span1" type="text" name="nb" value="1">
                <button class="success" type="submit"><span class="icon-cart-2"></span> Ajouter à mon panier</button>
            </form>
            </div>
            <div class="info-vues">
                <span>Cet article a été consulté <?php echo $value['vues']; ?> fois</span>
            </div>
        </div>
    </div>
    <br>
    <div>
        <h4>Informations du produit</h4>
        <table class="table table-bordered" cellspacing="0">
            <tbody>
                <tr class="techSpecRow"><td class="techSpecTD1">Marque : </td><td class="techSpecTD2"><?php echo $value['marque']; ?></td></tr>
                <tr class="techSpecRow"><td class="techSpecTD1">Model :</td><td class="techSpecTD2"><?php echo $value['nom']; ?></td></tr>
                <tr class="techSpecRow"><td class="techSpecTD1">Référence : </td><td class="techSpecTD2"><?php echo $value['reference']; ?></td></tr>
                <tr class="techSpecRow"><td class="techSpecTD1">Description : </td><td class="techSpecTD2"><?php echo $value['description']; ?></td></tr>
                <tr class="techSpecRow"><td class="techSpecTD1">Poids : </td><td class="techSpecTD2"><?php echo $value['poids']; ?> g</td></tr>
            </tbody>
        </table>
    </div>
    <?php endforeach; ?>
    <?php else : ?>
        <p>Article introuvable</p>
    <?php endif; ?>
</div>