<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\TranslateBehavior
 */
class AnnouncementsTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->addBehavior('Translate', ['fields' => ['title', 'content']]);
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('title')
            ->add('published', 'inList', [
                'rule' => ['inList', ['0', '1']],
                'message' => __('Choose a valid value.')
            ])
            ->allowEmpty('content');

        return $validator;
    }
}
