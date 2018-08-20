<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Inflector;

/**
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\TranslateBehavior
 */
class PagesTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->addBehavior('Translate', ['fields' => ['title', 'content', 'meta_title', 'meta_description']]);
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('title')
            ->allowEmpty('slug')
            ->add('slug', [
                'unique' => [
                    'rule' => 'validateUnique',
                    'provider' => 'table',
                    'message' => __('Slug must be unique.')
                ]
            ])
            ->add('published', 'inList', [
                'rule' => ['inList', ['0', '1']],
                'message' => __('Choose a valid value.')
            ])
            ->allowEmpty('content')
            ->allowEmpty('meta_title')
            ->allowEmpty('meta_description');

        return $validator;
    }

    //http://www.whatstyle.net/articles/52/generate_unique_slugs_in_cakephp
    public function createSlug($slug, $id = null)
    {
        $slug = mb_strtolower(Inflector::slug($slug, '-'));
        $i = 0;
        $conditions = array();
        $conditions['slug'] = $slug;
        if (!is_null($id)) {
            $conditions['Pages.id <>'] = $id;
        }

        while ($this->find()->where($conditions)->count()) {
            if (!preg_match('/-{1}[0-9]+$/', $slug)) {
                $slug .= '-' . ++$i;
            } else {
                $slug = preg_replace('/[0-9]+$/', ++$i, $slug);
            }
            $conditions['Pages.slug'] = $slug;
        }
        return $slug;
    }
}
