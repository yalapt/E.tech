<?php

App::uses('AppModel', 'Model');

class Article extends AppModel 
{
	public $validate = array(
        'nom' => array(
            array(
                'rule' => 'notEmpty',
                'allowEmpty' => false,
                'message' => 'Vous devez entrer un nom.'
            )
        ),
        'prix' => array(
            array(
                'rule' => 'notEmpty',
                'allowEmpty' => false,
                'message' => 'Vous devez entrer un prix.'
            )
        ),
        'description' => array(
            array(
                'rule' => 'notEmpty',
                'allowEmpty' => false,
                'message' => 'Vous devez entrer une description.'
            )
        ),
        'referance' => array(
            array(
                'rule' => 'notEmpty',
                'allowEmpty' => false,
                'message' => 'Vous devez entrer le référance.'
            )
        ),
        'marque' => array(
            array(
                'rule' => 'notEmpty',
                'allowEmpty' => false,
                'message' => 'Vous devez entrer la marque.'
            )
        ),
        'poids' => array(
            array(
                'rule' => 'notEmpty',
                'allowEmpty' => false,
                'message' => 'Vous devez entrer le poids.'
            )
        ),
    );
}