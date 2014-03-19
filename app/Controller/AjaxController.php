<?php


class AjaxController extends AppController 
{
	/*----- AJAX -----*/

	public function ajaxSigninVilles()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$departement = $this->request->data['departement'];
		$this->loadModel('Ville');
		$listVille = $this->Ville->find('all', array(
			'conditions' => array('departement' => $departement),
			'order' => array('nom_ville ASC')));

		echo '<option value="0" class="text-muted">Ville</option>';

		foreach($listVille as $value) 
		{
			foreach($value as $ville)
			{
				echo '<option value="'.$ville['id'].'">'.$ville['nom_ville'].'</option>';
			}
		}
	}

	public function ajaxSigninName()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$name = htmlspecialchars(strtolower(trim($this->request->data['username'])));
		$this->loadModel('User');
		$username = $this->User->find('count', array(
			'conditions' => array('username' => $name)));

		if($username != '0')
		{
			echo 'indisponible';
		}
		else
		{
			echo 'disponible';
		}
	}

	public function ajaxSigninEmail()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$email = htmlspecialchars(strtolower(trim($this->request->data['email'])));
		$this->loadModel('User');
		$useremail = $this->User->find('count', array(
			'conditions' => array('email' => $email)));

		if($useremail != '0')
		{
			echo 'indisponible';
		}
		else
		{
			echo 'disponible';
		}
	}

	public function ajaxSousCategories()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';
		$categorie = $this->request->data['categorie'];
		$this->loadModel('Sous_categorie');
		$listeSousCategorie = $this->Sous_categorie->find('all', array(
			'conditions' => array('id_categorie' => $categorie),
			'order' => array('nom ASC')));

		echo '<option value="0" class="text-muted">Sous-catégorie</option>';

		foreach($listeSousCategorie as $value) 
		{
			foreach($value as $SousCategorie)
			{
				echo '<option value="'.$SousCategorie['id'].'">'.$SousCategorie['nom'].'</option>';
			}
		}
	}
}
