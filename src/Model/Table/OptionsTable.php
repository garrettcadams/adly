<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use Cake\ORM\Entity;

class OptionsTable extends Table
{
    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('name')
            ->add('name', [
                'alphaNumeric' => [
                    'rule' => ['custom', '/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/'],
                    'message' => 'Option name must only contain letters, numbers, underscore and start with letter.'
                ]
            ])
            ->add('name', [
                'unique' => [
                    'rule' => 'validateUnique',
                    'provider' => 'table',
                    'message' => 'Option\'s name already exists'
                ]
            ]);

        return $validator;
    }

    public function afterSave(Event $event, Entity $entity, $options)
    {
    }
}
