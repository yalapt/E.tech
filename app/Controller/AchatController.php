<?php

class AchatController extends AppController
{
	public function index()
	{
		$this->editAdresse();
	}

	private function logged()
	{
		if(!$this->Auth->loggedIn())
		{
			$this->redirect('/user/login');
		}
	}

    private function nav()
    {
        $this->loadModel('Categorie');
        $this->loadModel('Sous_categorie');
        $categories = $this->Categorie->find('all', array('order' => array('nom' => 'asc')));
        $sousCategories = $this->Sous_categorie->find('all', array('order' => array('nom' => 'asc')));

        foreach($categories as $categorie)
        {
            foreach($categorie as $value) 
            {
                $listeCategorie[] = $value;
            }
        }

        foreach($sousCategories as $sousCategorie)
        {
            foreach($sousCategorie as $value) 
            {
                $listeSousCategorie[] = $value;
            }
        }

        $this->set('navCategories', $listeCategorie);
        $this->set('navSousCategories', $listeSousCategorie);
    }

    private function listDepartement()
	{
		$this->loadModel('Ville');

		$departement = $this->Ville->find('all', array('fields' => 'DISTINCT departement'));
		
		foreach ($departement as $value) 
		{
			foreach ($value as $dep)
			{
				$listDepartement[] = $dep;
			}
		}

		if($this->Auth->loggedIn())
		{
			$ville = $this->Ville->find('first', array('conditions' => array('id' => AuthComponent::user('ville'))));
			$villes = $this->Ville->find('all', array('conditions' => array('departement' => $ville['Ville']['departement'])));

			foreach ($villes as $value) 
			{
				foreach ($value as $info)
				{
					$listVille[] = $info;
				}
			}

			$this->set('departement', $ville['Ville']['departement']);
			$this->set('ville', $ville['Ville']['nom_ville']);
			$this->set('listVille', $listVille);
		}
		$this->set('listDepartement', $listDepartement);
	}

    public function editAdresse()
	{
		$this->logged();
		$this->loadModel('Ville');
		if($this->request->is('post'))
		{
			$this->request->data['nom'] = htmlspecialchars(trim($this->request->data['nom']));
			$this->request->data['prenom'] = htmlspecialchars(trim($this->request->data['prenom']));
			$this->request->data['adresse'] = htmlspecialchars(trim($this->request->data['adresse']));
			$this->request->data['telephone'] = htmlspecialchars(trim($this->request->data['telephone']));

			$this->Achat->set($this->request->data);

			if($this->Achat->validates())
			{
				if($this->request->data['ville'] != '0')
				{
                    $ville = $this->Ville->find('first', array('conditions' => array('id' => $this->request->data['ville'])));
					
                    $this->Session->write('Adresse', array('id_user' => AuthComponent::user('id'),
														   'nom' => $this->request->data['nom'],
														   'prenom' => $this->request->data['prenom'],
														   'departement' => $this->request->data['departement'],
														   'ville' => $ville['Ville']['nom_ville'],
														   'adresse' => $this->request->data['adresse'],
														   'telephone' => $this->request->data['telephone']));
					$this->redirect('/achat/editPanier');
				}
				else
				{
					$this->Session->setFlash('Vous devez choisir une ville.', 'error');
				}
			} 
			else 
			{
			    $errors = $this->Achat->validationErrors;
			    $this->Session->setFlash($errors, 'tab_error');
			}
        }

        if($this->Session->read('Adresse'))
        {
        	$departement = $this->Ville->find('all', array('fields' => 'DISTINCT departement'));
		
			foreach($departement as $value) 
			{
				foreach($value as $dep)
				{
					$listDepartement[] = $dep;
				}
			}

			$ville = $this->Ville->find('first', array('conditions' => array('nom_ville' => $this->Session->read('Adresse.ville'))));
			$villes = $this->Ville->find('all', array('conditions' => array('departement' => $ville['Ville']['departement'])));

			foreach($villes as $value) 
			{
				foreach($value as $info)
				{
					$listVille[] = $info;
				}
			}

			$this->set('listVille', $listVille);
			$this->set('listDepartement', $listDepartement);
        	$this->set('departement', $this->Session->read('Adresse.departement'));
        	$this->set('ville', $this->Session->read('Adresse.ville'));
        }
        else
        {
        	$this->listDepartement();
        }

        $this->set('title', 'Adresse de livraison');
        $this->nav();
		$this->layout = 'default';
		$this->render('/subview/achat/adresse');
	}

    public function editPanier()
    {
    	$this->logged();
        $this->set('title', 'Panier');
        $this->set('articles', $this->articlesPanier());
        $this->nav();
        $this->layout = 'default';
        $this->render('/subview/achat/panier');
    }

    public function recap()
    {
    	$this->logged();
        $this->set('title', 'Récapitulatif');
        $this->set('articles', $this->articlesPanier());
        $this->nav();
        $this->layout = 'default';
        $this->render('/subview/achat/recap');
    }

    public function paiement()
    {
    	$this->logged();
    	$this->loadModel('Achat');
    	$this->loadModel('Achat_assoc');
    	$this->loadModel('Article');
    	if($this->request->is('post'))
		{
			if(isset($this->request->data['cb']))
			{
				if(is_numeric($this->request->data['cb']) && strlen($this->request->data['cb']) == 16)
				{
					if(is_numeric($this->request->data['crypto']) && strlen($this->request->data['crypto']) == 3)
					{
						$dataAchat = array('id_user' => AuthComponent::user('id'),
									   'nom' => $this->Session->read('Adresse.nom'),
									   'prenom' => $this->Session->read('Adresse.prenom'),
									   'departement' => $this->Session->read('Adresse.departement'),
									   'ville' => $this->Session->read('Adresse.ville'),
									   'adresse' => $this->Session->read('Adresse.adresse'),
									   'telephone' => $this->Session->read('Adresse.telephone'),
									   'cb' => $this->request->data['cb'],
									   'date' => date('Y-m-d-H-i-s'));
				    	$this->Achat->save($dataAchat);
				    	
				    	$idAchat = $this->Achat->getLastInsertId();
						$panier = $this->Session->read('Panier');

				        foreach($panier as $id => $nb)
				        {
				            if($nb != 0)
				            {
				            	$dataAssoc = array('id' => null, 'id_achat' => $idAchat, 'id_article' => $id, 'quantite' => $nb);
				            	$this->Achat_assoc->save($dataAssoc, false, array('id_achat', 'id_article', 'quantite'));
				            }
				        }

				        $this->redirect('/achat/finalisation');
				    }
				    else
				    {
				    	$this->Session->setFlash('Cryptograme invalide.', 'error');
				    }
			    }
			    else
			    {
			    	$this->Session->setFlash('Numéro de carte bancaire invalide.', 'error');
			    }
			}
			else
			{
				$this->Session->setFlash('Vous devez entrer votre numéro de carte bancaire.', 'error');
			}
		}

		$this->set('title', 'Paiement');
        $this->nav();
        $this->layout = 'default';
        $this->render('/subview/achat/paiement');
    }

    public function finalisation()
    {
    	$this->set('title', 'Merci pour votre achat');
        $this->nav();
        $this->layout = 'default';
        $this->render('/subview/achat/remerciement');
    }

    private function articlesPanier()
    {
        $checkPanier = $this->Session->check('Panier');

        if($checkPanier)
        {
            if($this->Session->read('nbArticlePanier.nb') and $this->Session->read('nbArticlePanier.nb') > 0)
            {
                $panier = $this->Session->read('Panier');
                $this->loadModel('Article');

                foreach($panier as $id => $nb)
                {
                    if($nb != 0)
                    {
                        $article = $this->Article->find('first', array('conditions' => array('id' => $id)));
                        $articles[$id] = $article;
                    }
                }

                foreach($articles as $article) 
                {
                    foreach($article as  $value) 
                    {
                        $elems[] = $value;
                    }
                }

                return $elems;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    public function addArticlePanier()
    {
        if(isset($this->request->params['id']))
        {
            $id = $this->request->params['id'];
            $checkPanier = $this->Session->check('Panier');
            $checkArticle = $this->Session->check('Panier.'.$id);
            $panier = $this->Session->read('Panier');
            if(!$checkPanier)
            {
                $this->Session->write('Panier', array($id => 1));
            }
            else
            {
                if($checkArticle)
                {
                    $nb = $this->Session->read('Panier.'.$id);
                    $nb++;
                    $this->Session->write('Panier.'.$id, $nb);
                }
                else
                {
                    $panier[$id] = 1;
                    $this->Session->write('Panier', $panier);
                }
            }
        }

        $this->countArticlePanier();
        $this->prixArticlePanier();
        $this->redirect('/achat/editPanier');
    }

    public function addArticlesPanier()
    {
        if($this->request->is('post'))
        {
            $id = $this->request->data['id'];
            $nb = $this->request->data['nb'];

            if(isset($this->request->data['nb']) && is_numeric($this->request->data['nb']) && $this->request->data['nb'] > 0)
            {
            	$checkPanier = $this->Session->check('Panier');
	            $checkArticle = $this->Session->check('Panier.'.$id);
	            $panier = $this->Session->read('Panier');
	            if(!$checkPanier)
	            {
	                $this->Session->write('Panier', array($id => $nb));
	            }
	            else
	            {
	                if($checkArticle)
	                {
	                    $nbLast = $this->Session->read('Panier.'.$id);
	                    $nb += $nbLast;
	                    $this->Session->write('Panier.'.$id, $nb);
	                }
	                else
	                {
	                    $panier[$id] = $nb;
	                    $this->Session->write('Panier', $panier);
	                }
	            }
            }
        }

        $this->countArticlePanier();
        $this->prixArticlePanier();
        $this->redirect('/achat/editPanier');
    }

    public function deleteArticlePanier()
    {
        if(isset($this->request->params['id']))
        {
            $id = $this->request->params['id'];
            $checkPanier = $this->Session->check('Panier');
            $checkArticle = $this->Session->check('Panier.'.$id);
            if($checkPanier)
            {
                if($checkArticle)
                {
                    $nb = $this->Session->read('Panier.'.$id);
                    if($nb > 0)
                    {
                        $nb--;
                        $this->Session->write('Panier.'.$id, $nb);
                    }
                }
            }
        }

        $this->countArticlePanier();
        $this->prixArticlePanier();
        $this->redirect('/achat/editPanier');
    }

    public function deleteArticlesPanier()
    {
        if(isset($this->request->params['id']))
        {
            $id = $this->request->params['id'];
            $checkPanier = $this->Session->check('Panier');
            $checkArticle = $this->Session->check('Panier.'.$id);
            if($checkPanier)
            {
                if($checkArticle)
                {
                    $nb = $this->Session->read('Panier.'.$id);
                    if($nb > 0)
                    {
                        $nb = 0;
                        $this->Session->write('Panier.'.$id, $nb);
                    }
                }
            }
        }

        $this->countArticlePanier();
        $this->prixArticlePanier();
        $this->redirect('/achat/editPanier');
    }

    private function countArticlePanier()
    {
        $checkPanier = $this->Session->check('Panier');
        $count = 0;

        if($checkPanier)
        {
            $panier = $this->Session->read('Panier');

            foreach($panier as $value) 
            {
                $count += $value;
            }
        }

        $this->Session->write('nbArticlePanier', array('nb' => $count));
        return $count;
    }

    private function prixArticlePanier()
    {
        $checkPanier = $this->Session->check('Panier');
        $prix = 0;

        if($checkPanier)
        {
            $panier = $this->Session->read('Panier');
            $this->loadModel('Article');

            foreach($panier as $id => $nb)
            {
                if($nb != 0)
                {
                    $article = $this->Article->find('first', array('conditions' => array('id' => $id)));
                    $articles[$id] = $article;
                }
            }

            foreach($articles as $article)
            {
                foreach($article as  $value) 
                {
                    foreach($panier as $id => $nb)
                    {
                        if($id == $value['id'])
                        {
                            $prix += $value['prix']*$nb;
                        }
                    }
                }
            }
        }

        $this->Session->write('prixArticlePanier', array('prix' => $prix));
        return $prix;
    }
}
