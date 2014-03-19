<?php

class AdminController extends AppController
{
	public function index()
	{
		$this->show();
	}

	private function role()
	{
		if($this->Auth->loggedIn())
		{
			if(!AuthComponent::user('role'))
			{
				$this->redirect('/');
			}
		}
		else
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
		$this->role();
		$this->set('title', 'Administration');
		$this->nav();
		$this->layout = 'default';
		$this->render('/subview/admin/accueil');
	}

	public function users()
	{
		$this->role();
		$this->loadModel('User');

		$users = $this->User->find('all');

		foreach($users as $user)
		{
			foreach($user as $value)
			{
				$listeUser[] = $value;
			}
		}

		$this->set('users', $listeUser);

		$this->set('title', 'Gestion des utilisateurs');
		$this->nav();
		$this->layout = 'default';
		$this->render('/subview/admin/utilisateurs');
	}

	public function gradeUser()
	{
		$this->role();
		$id = $this->request->params['id'];
		$this->loadModel('User');
		$data = array('id' => $id,
					  'role' => '1');
		$this->User->save($data, false, array('id', 'role'));
		$this->redirect('/admin/users');
	}

	public function degradeUser()
	{
		$this->role();
		$id = $this->request->params['id'];
		$this->loadModel('User');
		$data = array('id' => $id,
					  'role' => '0');
		$this->User->save($data, false, array('id', 'role'));
		$this->redirect('/admin/users');
	}

	public function deleteUser()
	{
		$this->role();
		$id = $this->request->params['id'];
		$this->loadModel('User');
		$this->User->delete($id);
		$this->redirect('/admin/users');
	}

	public function createUser()
	{
		$this->role();
		$this->loadModel('User');

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
			            $this->redirect('/admin/users');
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

		$this->set('title', 'Créer un utilisateur');
		$this->listDepartement();
		$this->nav();
		$this->layout = 'default';
		$this->render('/subview/admin/create_user');
	}

	public function editUser()
	{
		$this->role();
		$this->loadModel('User');

		if($this->request->is('post'))
		{
			$this->request->data['id'] = $this->request->params['id'];
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
				        	$this->redirect('/admin/editUser/'.$this->request->params['id']);
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
				  			$this->redirect('/admin/editUser/'.$this->request->params['id']);
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
  		
  		$user = $this->User->find('first', array('conditions' => array('id' => $this->request->params['id'])));

  		$idVille = 0;

  		foreach ($user as $value)
  		{
  			$info[] = $value;
  		}

  		foreach ($info as $value)
  		{
  			$idVille = $value['ville'];
  		}

  		$this->loadModel('Ville');

		$departement = $this->Ville->find('all', array('fields' => 'DISTINCT departement'));
		
		foreach ($departement as $value) 
		{
			foreach ($value as $dep)
			{
				$listDepartement[] = $dep;
			}
		}

		$ville = $this->Ville->find('first', array('conditions' => array('id' => $idVille)));
		$villes = $this->Ville->find('all', array('conditions' => array('departement' => $ville['Ville']['departement'])));
		
		foreach ($villes as $value) 
		{
			foreach ($value as $infos)
			{
				$listVille[] = $infos;
			}
		}

		$this->set('departement', $ville['Ville']['departement']);
		$this->set('ville', $ville['Ville']['nom_ville']);
		$this->set('listVille', $listVille);
		$this->set('listDepartement', $listDepartement);
        $this->set('title', 'Modifier un utilisateur');
        $this->set('infos', $info);
        $this->nav();
		$this->layout = 'default';
		$this->render('/subview/admin/edit_user');
	}

	public function categories()
	{
		$this->role();
		$this->createCategorie();
		$this->createSousCategorie();
		$this->showCategorie();
		$this->set('title', 'Gestion des catégories');
		$this->nav();
		$this->layout = 'default';
		$this->render('/subview/admin/categories');
	}

	private function showCategorie()
	{
		$this->loadModel('Categorie');
		$this->loadModel('Sous_categorie');

		$categories = $this->Categorie->find('all');
		$sousCategories = $this->Sous_categorie->find('all', array('order' => array('id_categorie' => 'asc')));
		
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
				$listeSousCategories[] = $value;
			}
		}

		$this->set('categories', $listeCategorie);
		$this->set('sousCategories', $listeSousCategories);
	}

	private function createCategorie()
	{
		if(isset($this->request->data['createCategorie']))
		{
			$this->request->data['nom'] = htmlspecialchars($this->request->data['nom']);
			$this->loadModel('Categorie');

			$this->Categorie->set($this->request->data);

			if($this->Categorie->validates())
			{
				if(isset($this->request->data['id']))
				{
					$this->Categorie->save($this->request->data, false, array('id' , 'nom'));
				}
				else
				{
					$this->Categorie->save($this->request->data, false, array('nom'));
				}
				
				$this->redirect('/admin/categories');
			} 
			else 
			{
			    $errors = $this->Categorie->validationErrors;
			    $this->Session->setFlash($errors, 'tab_error');
			}
		}
	}

	private function createSousCategorie()
	{
		if(isset($this->request->data['createSousCategorie']))
		{
			$this->request->data['nom'] = htmlspecialchars($this->request->data['nom']);
			$this->loadModel('Sous_categorie');

			$this->Sous_categorie->set($this->request->data);

			if($this->Sous_categorie->validates())
			{
				if($this->request->data['id_categorie'] != '0')
				{
					if(isset($this->request->data['id']))
					{
						$this->Sous_categorie->save($this->request->data, false, array('id' ,'id_categorie', 'nom'));
					}
					else
					{
						$this->Sous_categorie->save($this->request->data, false, array('id_categorie', 'nom'));
					}

					$this->redirect('/admin/categories');
				}
				else
				{
					$this->Session->setFlash('Une catégorie doit être associée à la sous-catégorie.', 'error');
				}
			} 
			else 
			{
			    $errors = $this->Sous_categorie->validationErrors;
			    $this->Session->setFlash($errors, 'tab_error');
			}
		}
	}

	public function deleteCategorie()
	{
		$this->role();
		$id = $this->request->params['id'];
		$this->loadModel('Categorie');
		$this->Categorie->delete($id);
		$this->redirect('/admin/categories');
	}

	public function deleteSousCategorie()
	{
		$this->role();
		$id = $this->request->params['id'];
		$this->loadModel('Sous_categorie');
		$this->Sous_categorie->delete($id);
		$this->redirect('/admin/categories');
	}

	public function articles()
	{
		$this->role();
		$this->showArticles();
		$this->set('title', 'Gestion des articles');
		$this->nav();
		$this->layout = 'default';
		$this->render('/subview/admin/articles');
	}

	public function article()
	{
		$this->role();

		if($this->request->is('post'))
		{
			$this->request->data['nom'] = htmlspecialchars($this->request->data['nom']);
			$this->request->data['prix'] = htmlspecialchars(trim($this->request->data['prix']));
			$this->request->data['description'] = htmlspecialchars($this->request->data['description']);
			$this->request->data['reference'] = htmlspecialchars($this->request->data['reference']);
			$this->request->data['marque'] = htmlspecialchars($this->request->data['marque']);
			$this->request->data['poids'] = htmlspecialchars(trim($this->request->data['poids']));

			$this->loadModel('Article');
			$this->Article->set($this->request->data);

			if($this->Article->validates()) 
			{
				if($this->request->data['id_categorie'] != '0' and $this->request->data['id_sous_categorie'] != '0')
				{
				 	if($this->Article->save($this->request->data, false, array('id', 'id_categorie', 'id_sous_categorie', 'nom', 'prix', 'description', 'reference', 'marque', 'poids')))
					{	
						$id = $this->request->data['id'];
						if(!empty($this->request->data['image']['name'])) 
						{
							$file1 = new File(WWW_ROOT . 'image/articles/'.$id.'.jpg');
							$file2 = new File(WWW_ROOT . 'image/articles/min/'.$id.'.jpg');
							$file3 = new File(WWW_ROOT . 'image/articles/display/'.$id.'.jpg');
	        				$file1->delete();
	        				$file2->delete();
	        				$file3->delete();
							move_uploaded_file($this->request->data['image']['tmp_name'], 'img/articles/'.$id.'.jpg');
							$this->creerMin('img/articles/'.$id.'.jpg', 'img/articles/min',$id.'.jpg', 200, 200);
							$this->creerMin('img/articles/'.$id.'.jpg', 'img/articles/display',$id.'.jpg', 600, 520);
						}
			            $this->redirect('/admin/article/'.$id);
					}
					else
					{
						$this->Session->setFlash('La modification à échoué.', 'error');
					}
				}
				else
				{
					$this->Session->setFlash('Vous devez choisir une catégorie et une sous-catégorie.', 'error');
				}
			} 
			else 
			{
			    $errors = $this->Article->validationErrors;
			    $this->Session->setFlash($errors, 'tab_error');
			}
		}

		$this->showArticle();
		$this->showCategorie();
		$this->set('title', 'Gestion des articles');
		$this->nav();
		$this->layout = 'default';
		$this->render('/subview/admin/article');
	}

	private function showArticles()
	{
		$this->loadModel('Article');
		$articles = $this->Article->find('all');
		
		foreach($articles as $article)
		{
			foreach($article as $value) 
			{
				$listeArticle[] = $value;
			}
		}

		$this->set('articles', $listeArticle);
	}

	private function showArticle()
	{
		if(isset($this->request->params['id']))
        {
            $this->loadModel('Article');
            $article = $this->Article->find('first', array('conditions' => array('id' => $this->request->params['id'])));
            
            foreach($article as $info)
            {
                $infoArticle[] = $info;
            }
        }

		$this->set('article', $infoArticle);
	}

	public function createArticle()
	{
		$this->role();

		if($this->request->is('post'))
		{
			$this->request->data['nom'] = htmlspecialchars($this->request->data['nom']);
			$this->request->data['prix'] = htmlspecialchars(trim($this->request->data['prix']));
			$this->request->data['description'] = htmlspecialchars($this->request->data['description']);
			$this->request->data['reference'] = htmlspecialchars($this->request->data['reference']);
			$this->request->data['marque'] = htmlspecialchars($this->request->data['description']);
			$this->request->data['poids'] = htmlspecialchars(trim($this->request->data['poids']));

			$this->loadModel('Article');
			$this->Article->set($this->request->data);

			if($this->Article->validates()) 
			{
				if($this->request->data['id_categorie'] != '0' and $this->request->data['id_sous_categorie'] != '0')
				{
					if(!empty($this->request->data['image']['name'])) 
					{					
						if($this->Article->save($this->request->data, false, array('id_categorie', 'id_sous_categorie', 'nom', 'prix', 'description', 'reference', 'marque', 'poids')))
						{
							$id = $this->Article->getLastInsertId();
							move_uploaded_file($this->request->data['image']['tmp_name'], 'img/articles/'.$id.'.jpg');
							$this->creerMin('img/articles/'.$id.'.jpg', 'img/articles/min',$id.'.jpg', 200, 200);
							$this->creerMin('img/articles/'.$id.'.jpg', 'img/articles/display',$id.'.jpg', 600, 400);
				            $this->redirect('/admin/articles');
						}
						else
						{
							$this->Session->setFlash('La modification à échoué.', 'error');
						}
					}
					else
					{
						$this->Session->setFlash('Vous devez choisir une image.', 'error');
					}
				}
				else
				{
					$this->Session->setFlash('Vous devez choisir une catégorie et une sous-catégorie.', 'error');
				}
			} 
			else 
			{
			    $errors = $this->Article->validationErrors;
			    $this->Session->setFlash($errors, 'tab_error');
			}
		}

		$this->showCategorie();
		$this->set('title', 'Gestion des articles');
		$this->nav();
		$this->layout = 'default';
		$this->render('/subview/admin/createArticle');
	}

	public function deleteArticle()
	{
		$this->role();
		$id = $this->request->params['id'];
		$this->loadModel('Article');
		$this->Article->delete($id);
		$this->redirect('/admin/articles');
	}

	private function creerMin($img,$chemin,$nom,$mlargeur=100,$mhauteur=100)
	{
		// On supprime l'extension du nom
		$nom = substr($nom,0,-4);
		// On récupère les dimensions de l'image
		$dimension=getimagesize($img);
		// On cré une image à partir du fichier récup
		if(substr(strtolower($img),-4)==".jpg"){$image = imagecreatefromjpeg($img); }
		else if(substr(strtolower($img),-4)==".png"){$image = imagecreatefrompng($img); }
		else if(substr(strtolower($img),-4)==".gif"){$image = imagecreatefromgif($img); }
		// L'image ne peut etre redimensionne
		else{return false; }
		
		// Création des miniatures
		// On cré une image vide de la largeur et hauteur voulue
		$miniature =imagecreatetruecolor ($mlargeur,$mhauteur); 
		// On va gérer la position et le redimensionnement de la grande image
		if($dimension[0]>($mlargeur/$mhauteur)*$dimension[1] ){ $dimY=$mhauteur; $dimX=$mhauteur*$dimension[0]/$dimension[1]; $decalX=-($dimX-$mlargeur)/2; $decalY=0;}
		if($dimension[0]<($mlargeur/$mhauteur)*$dimension[1]){ $dimX=$mlargeur; $dimY=$mlargeur*$dimension[1]/$dimension[0]; $decalY=-($dimY-$mhauteur)/2; $decalX=0;}
		if($dimension[0]==($mlargeur/$mhauteur)*$dimension[1]){ $dimX=$mlargeur; $dimY=$mhauteur; $decalX=0; $decalY=0;}
		// on modifie l'image crée en y plaçant la grande image redimensionné et décalée
		imagecopyresampled($miniature,$image,$decalX,$decalY,0,0,$dimX,$dimY,$dimension[0],$dimension[1]);
		// On sauvegarde le tout
		imagejpeg($miniature,$chemin."/".$nom.".jpg",90);
		return true;
	}

	public function achats()
	{
		$this->role();

		$this->loadModel('User');
		$this->loadModel('Achat');
		$users = $this->User->find('all');

		if($this->request->is('post'))
		{
			if($this->request->data['id_user'] != 0)
			{
				$idUser = $this->request->data['id_user'];
				$achats = $this->Achat->find('all', array('conditions' => array('id_user' => $this->request->data['id_user'])));
			}
			else
			{
				$idUser = 0;
				$achats = $this->Achat->find('all');
			}
		}
		else
		{
			$idUser = 0;
			$achats = $this->Achat->find('all');
		}

		foreach($users as $user)
		{
			foreach($user as $value)
			{
				$listeUser[] = $value;
			}
		}

		foreach($achats as $achat)
		{
			foreach($achat as $value)
			{
				$listeAchat[] = $value;
			}
		}

		$this->set('title', 'Les achats');
		$this->set('idUser', $idUser);
		$this->set('users', $listeUser);
		if(isset($listeAchat))
		{
			$this->set('achats', $listeAchat);
		}
        $this->nav();
		$this->layout = 'default';
		$this->render('/subview/admin/achats');
	}

	public function achat()
	{
		$this->role();

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
		$this->render('/subview/admin/achat');
	}
}