<div class="breadcrumbs">
  <ul>
    <li><a href="/../accueil">Accueil</a></li>
    <li><a href="/../achat">Achat</a></li>
    <li><a href="/../achat/editAdresse">Adresse de livraison</a></li>
    <li><a href="/../achat/editPanier">Panier</a></li>
    <li><a href="/../achat/recap">Récapitulatif</a></li>
    <li>Paiement</li>
  </ul>
</div>
<div class="container">
	<div class="block-paiement">
		<h4>Informations sur la transaction</h4>
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
					<th class="span4">Montant</th>
					<td ><?php if(!$this->Session->read('prixArticlePanier.prix')){echo '0';}else{echo $this->Session->read('prixArticlePanier.prix');} ?> €</td>
				</tr>
			</tbody>
		</table>
		<h4>Paiement securisé par carte bancaire <span><img class="cb-visa" src="/img/cb_visa_mastercard_logo.png"></span></h4>
		<form method="post" name="formCb">
			<input type="text" name="cb" class="form-control numero-cb" placeholder="Numéro de carte">
			<select class="form-control span2 date-mois" name="dateMois" placeholder="Expire fin">
				<option value="Janvier">Janvier</option>
				<option value="Février">Février</option>
				<option value="Mars">Mars</option>
				<option value="Avril">Avril</option>
				<option value="Mai">Mai</option>
				<option value="Juin">Juin</option>
				<option value="Juillet">Juillet</option>
				<option value="Aout">Aout</option>
				<option value="Septembre">Septembre</option>
				<option value="Octobre">Octobre</option>
				<option value="Novembre">Novembre</option>
				<option value="Décembre">Décembre</option>
			</select>
			<select class="form-control span2 date-annee" name="dateAnnee" placeholder="Expire fin">
				<option value="2014">2014</option>
				<option value="2015">2015</option>
				<option value="2016">2016</option>
				<option value="2017">2017</option>
				<option value="2018">2018</option>
				<option value="2019">2019</option>
				<option value="2020">2020</option>
			</select>
			<input type="text" name="crypto" class="form-control crypt" placeholder="Cryptogramme">
			<div class="button-compte">
				<input type="submit" class="success" value="Confirmer le paiement">
			</div>
		</form>
	</div>
</div>