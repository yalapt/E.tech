<?php

class AccueilController extends AppController
{
	public function index()
	{
		$this->show();
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

	public function show()
	{
        $this->loadModel('Article');

        if($this->request->is('post'))
		{
			$search = $this->request->data['search'];
			$articles = $this->Article->find('all', array('conditions' => array(
														  'OR' => array(
														  array('nom LIKE' => '%'.$search.'%'),
														  array('marque LIKE' => '%'.$search.'%'),
														  array('description LIKE' => '%'.$search.'%'))),
														  'order' => array('vues' => 'desc')));
		}
		else
		{
        	$articles = $this->Article->find('all', array('order' => array('vues' => 'desc')));
		}

        foreach($articles as $article)
        {
            foreach($article as $value) 
            {
                $listeArticle[] = $value;
            }
        }

		$this->set('title', 'Accueil');
		if(isset($listeArticle))
        {
            $this->set('articles', $listeArticle);
        }
        $this->nav();
		$this->layout = 'default';
		$this->render('/subview/accueil/accueil');
	}

    public function articles()
    {   
        $this->loadModel('Article');
        $idSousCategorie = $this->request->params['id'];

        $articles = $this->Article->find('all', array('conditions' => array('id_sous_categorie' => $idSousCategorie),
                                                      'order' => array('nom' => 'asc')));
        foreach($articles as $article)
        {
            foreach($article as $value) 
            {
                $listeArticle[] = $value;
            }
        }

        $this->set('title', 'Accueil');
        if(isset($listeArticle))
        {
            $this->set('articles', $listeArticle);
        }
        $this->nav();
        $this->layout = 'default';
        $this->render('/subview/accueil/articles');
    }

    public function article()
    {   
        if(isset($this->request->params['id']))
        {
            $this->loadModel('Article');
            $article = $this->Article->find('first', array('conditions' => array('id' => $this->request->params['id'])));
            
            foreach($article as $info)
            {
                $infoArticle[] = $info;
                $data['id'] = $info['id'];
                $data['vues'] = $info['vues']+1;
                $this->Article->save($data, false, array('id', 'vues'));
            }
        }

        $this->set('title', 'Accueil');
        if(isset($infoArticle))
        {
        	$this->set('article', $infoArticle);
        }
        $this->nav();
        $this->layout = 'default';
        $this->render('/subview/accueil/article');
    }

    public function panier()
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

        $this->set('title', 'Accueil');
        $this->set('articles', $this->articlesPanier());
        $this->nav();
        $this->layout = 'default';
        $this->render('/subview/accueil/panier');
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
        $this->redirect('/accueil/panier');
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
        $this->redirect('/accueil/panier');
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
        $this->redirect('/accueil/panier');
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
        $this->redirect('/accueil/panier');
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
