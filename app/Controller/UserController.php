<?php

class UserController extends AppController 
{
	public function index()
	{
		$this->show();
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

	static function formateDate($string)
    {
        $tab = explode(' ', $string);
        $dateTab = explode('-', $tab[0]);
        $i = count($dateTab)-1;
        while($i >= 0)
        {
            $newTab[] = $dateTab[$i];
            $i--;
        }
        $date = implode('/', $newTab);
        $formated = $date.' à '.$tab[1];
        return $formated;
    }

    static function formateCB($string)
    {
        $i = 0;
        $newString = '';
        while($i < 16)
        {
        	if($i < 4)
        	{
        		$newString .= $string[$i];
        	}
        	else
        	{
        		$newString .= '*';
        	}
        	$i++;
        }
        return $newString;
    }

	public function show()
	{
		$this->logged();

		$this->set('title', 'Mon compte');
        $this->nav();
		$this->layout = 'default';
		$this->render('/subview/user/accueil');
	}

	public function achats()
	{
		$this->logged();

		$this->loadModel('Achat');
		$achats = $this->Achat->find('all', array('conditions' => array('id_user' => AuthComponent::user('id'))));

		foreach($achats as $achat) 
		{
			foreach($achat as $value)
			{
				$listeAchat[] = $value;
			}
		}

		$this->set('title', 'Mes achats');
		if(isset($listeAchat))
		{
			$this->set('achats', $listeAchat);
		}
        $this->nav();
		$this->layout = 'default';
		$this->render('/subview/user/achats');
	}

	public function achat()
	{
		$this->logged();

		$idAchat = $this->request->params['id'];

		$this->loadModel('Achat');
		$this->loadModel('Achat_assoc');
		$this->loadModel('Article');
		$achat = $this->Achat->find('all', array('conditions' => array('id' => $idAchat)));
		$achatAssocs = $this->Achat_assoc->find('all', array('conditions' => array('id_achat' => $idAchat)));

		foreach($achat as $value) 
		{
			foreach($value as $info)
			{
				$infoAchat[] = $info;
			}
		}

		$prixTotal = 0;
		$nbArticleTotal = 0;
		foreach($achatAssocs as $achatAssoc) 
		{
			foreach($achatAssoc as $value)
			{
				$articleAssocs = $this->Article->find('first', array('conditions' => array('id' => $value['id_article'])));
				$listeArticleAssoc[$articleAssocs['Article']['nom']] = $value['quantite'];
				$listePrixAssoc[$articleAssocs['Article']['nom']] = $articleAssocs['Article']['prix']*$value['quantite'];
				$prixTotal += $articleAssocs['Article']['prix']*$value['quantite'];
				$nbArticleTotal += $value['quantite'];
			}
		}

		$this->set('title', 'Achat');
		$this->set('achat', $infoAchat);
		$this->set('articleAssocs', $listeArticleAssoc);
		$this->set('prixAssocs', $listePrixAssoc);
		$this->set('prixTotal', $prixTotal);
		$this->set('nbArticleTotal', $nbArticleTotal);
        $this->nav();
		$this->layout = 'default';
		$this->render('/subview/user/achat');
	}

	public function compte()
	{
		$this->logged();

		if($this->request->is('post'))
		{
			$this->request->data['id'] = AuthComponent::user('id');
			$this->request->data['email'] = htmlspecialchars(strtolower(trim($this->request->data['email'])));
			$this->request->data['nom'] = htmlspecialchars(trim($this->request->data['nom']));
			$this->request->data['prenom'] = htmlspecialchars(trim($this->request->data['prenom']));
			$this->request->data['adresse'] = htmlspecialchars(trim($this->request->data['adresse']));
			$this->request->data['telephone'] = htmlspecialchars(trim($this->request->data['telephone']));

			$this->User->set($this->request->data);

			unset($this->User->validate['username']);
			unset($this->User->validate['password']);

			if($this->User->validates())
			{
				if($this->request->data['ville'] != '0')
				{
					if($this->request->data['password'] != '')
					{
						$this->request->data['password'] = Security::hash(htmlspecialchars(trim($this->request->data['password'])), 'sha1', true);

					 	if($this->User->save($this->request->data, false, array('id', 'email', 'nom', 'prenom', 'password', 'ville', 'adresse', 'telephone')))
						{	
							$user = $this->User->find('first', array('conditions' => array('id' => AuthComponent::user('id'))));
				        	$this->Auth->login($user['User']);
				        	$this->redirect('/user/compte');

						}
						else
						{
							$this->Session->setFlash('La modification a échoué.', 'error');
						}
					}
					else
					{
						if($this->User->save($this->request->data, false, array('id', 'email', 'nom', 'prenom', 'ville', 'adresse', 'telephone')))
						{	
							$user = $this->User->find('first', array('conditions' => array('id' => AuthComponent::user('id'))));
				        	$this->Auth->login($user['User']);
				        	$this->redirect('/user/compte');

						}
						else
						{
							$this->Session->setFlash('La modification a échoué.', 'error');
						}
					}
				}
				else
				{
					$this->Session->setFlash('Vous devez choisir une ville.', 'error');
				}
			} 
			else 
			{
			    $errors = $this->User->validationErrors;
			    $this->Session->setFlash($errors, 'tab_error');
			}
        }
  		

        $this->set('title', 'Mes informations');
        $this->listDepartement();
        $this->nav();
		$this->layout = 'default';
		$this->render('/subview/user/compte');
	}

    public function delete()
    {   
    	$this->logged();

		$dir = new Folder(WWW_ROOT . 'files' . DS . AuthComponent::user('username'));
        $dir->delete();
        $this->User->delete(AuthComponent::user('id'));
		$this->redirect('/user/logout');
    }

	public function signin()
	{
		if($this->Auth->loggedIn())
		{
			$this->redirect('/');
		}

		if($this->request->is('post'))
		{
			$this->request->data['username'] = htmlspecialchars(strtolower(trim($this->request->data['username'])));
			$this->request->data['email'] = htmlspecialchars(strtolower(trim($this->request->data['email'])));
			$this->request->data['nom'] = htmlspecialchars(trim($this->request->data['nom']));
			$this->request->data['prenom'] = htmlspecialchars(trim($this->request->data['prenom']));
			$this->request->data['adresse'] = htmlspecialchars(trim($this->request->data['adresse']));
			$this->request->data['telephone'] = htmlspecialchars(trim($this->request->data['telephone']));
			$this->request->data['password'] = Security::hash(htmlspecialchars(trim($this->request->data['password'])), 'sha1', true);

			$this->User->set($this->request->data);

			if($this->User->validates()) 
			{
				if($this->request->data['ville'] != '0')
				{
				 	if($this->User->save($this->request->data, false, array('username', 'email', 'nom', 'prenom', 'password', 'ville', 'adresse', 'telephone')))
					{	
						$dir = new Folder(WWW_ROOT . 'files' . DS . $this->request->data['username'], true);
						$user = $this->User->find('first', array(
							'conditions' => array('username' => $this->request->data['username'], 'password' => $this->request->data['password'])));

			        	$this->Auth->login($user['User']);
			            $this->redirect('/');
					}
					else
					{
						$this->Session->setFlash('L\'inscription à échoué.', 'error');
					}
				}
				else
				{
					$this->Session->setFlash('Vous devez choisir une ville.', 'error');
				}
			} 
			else 
			{
			    $errors = $this->User->validationErrors;
			    $this->Session->setFlash($errors, 'tab_error');
			}
		}

		$this->set('title', 'Inscription');
		$this->listDepartement();
		$this->nav();
		$this->layout = 'default';
		$this->render('/subview/user/signin');
	}

	public function login()
	{
		if($this->Auth->loggedIn())
		{
			$this->redirect('/');
		}

		if($this->request->is('post')) 
		{
			$this->request->data['username'] = htmlspecialchars(strtolower(trim($this->request->data['username'])));
			$this->request->data['password'] = Security::hash(htmlspecialchars(trim($this->request->data['password'])), 'sha1', true);

			$user = $this->User->find('first', array(
				'conditions' => array('username' => $this->request->data['username'], 'password' => $this->request->data['password'])));

        	if(!empty($user))
        	{
        		$this->Auth->login($user['User']);
        		$Log = array('id' => AuthComponent::user('id'), 'logged' => '1');
				$this->User->save($Log, false);
            	$this->redirect('/');
        	} 
        	else 
        	{
            	$this->Session->setFlash('Nom d\'utilisateur ou mot de passe invalide.', 'error');
        	}
    	}

		$this->set('title', 'Connexion');
		$this->nav();
		$this->layout = 'default';
		$this->render('/subview/user/login');
	}

	public function logout()
	{
		if($this->Auth->loggedIn())
		{
			$this->Auth->logout();
		}
		$this->redirect('/');
	}
}