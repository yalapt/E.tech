<?php

App::uses('AppModel', 'Model');

class Categorie extends AppModel 
{
    public $validate = array(
        'nom' => array(
            array(
                'rule' => 'alphaNumeric',
                'rule'=>array('minLength',1),
                'rule'=>array('maxLength',255),
                'required' => true,
                'allowEmpty' => false,
                'message' => 'Nom de la catégorie invalide.'
            ),
            array(
                'rule' => 'isUnique',
                'message' => 'Nom de la catégorie déjà utilisé.'
            )
        )
    );
}