<?php

App::uses('AppModel', 'Model');

class Achat extends AppModel 
{
	public $validate = array(
        'nom' => array(
            array(
                'rule'=>array('custom','/^[a-z\d_-]{2,50}$/i'),
                'rule'=>array('minLength',2),
                'rule'=>array('maxLength',50),
                'required' => true,
                'allowEmpty' => false,
                'message' => 'Nom invalide.'
            )
        ),
        'prenom' => array(
            array(
                'rule'=>array('custom','/^[a-z\d_-]{2,50}$/i'),
                'rule'=>array('minLength',2),
                'rule'=>array('maxLength',50),
                'required' => true,
                'allowEmpty' => false,
                'message' => 'Prenom invalide.'
            )
        ),
        'telephone' => array(
            array(
                'rule'=>array('custom','/^[a-z\d_-]{10,10}$/i'),
                'rule'=>array('minLength',10),
                'rule'=>array('maxLength',10),
                'required' => true,
                'allowEmpty' => false,
                'message' => 'Numéro de téléphone invalide.'
            )
        ),
        'adresse' => array(
            array(
                'rule'=>array('minLength',3),
                'rule'=>array('maxLength',255),
                'required' => true,
                'allowEmpty' => false,
                'message' => 'Adresse invalide.'
            )
        ),
    );
}