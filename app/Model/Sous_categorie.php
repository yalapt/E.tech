<?php

App::uses('AppModel', 'Model');

class Sous_categorie extends AppModel 
{
    public $validate = array(
        'id_categorie' => array(
            array(
                'rule' => 'numeric',
                'required' => true,
                'allowEmpty' => false,
                'message' => 'Une catégorie doit être associée à la sous-catégorie.'
            )
        ),
        'nom' => array(
            array(
                'rule' => 'alphaNumeric',
                'rule'=>array('minLength',1),
                'rule'=>array('maxLength',255),
                'required' => true,
                'allowEmpty' => false,
                'message' => 'Nom de la sous-catégorie invalide.'
            ),
            array(
                'rule' => 'isUnique',
                'message' => 'Nom de la sous-catégorie déjà utilisé.'
            )
        )
    );
}