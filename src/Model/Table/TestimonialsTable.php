<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\TranslateBehavior
 */
class TestimonialsTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->addBehavior('Translate', ['fields' => ['name', 'position', 'content']]);
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('name')
            ->notEmpty('position')
            ->notEmpty('image')
            ->add('published', 'inList', [
                'rule' => ['inList', ['0', '1']],
                'message' => __('Choose a valid value.')
            ])
            ->notEmpty('content');

        return $validator;
    }
}
