<?php

namespace App\Model\Table;

use ADmad\SocialAuth\Model\Table\SocialProfilesTable as SocialProfilesTablePlugin;

/**
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\SocialProfile get($primaryKey, $options = [])
 * @method \App\Model\Entity\SocialProfile newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SocialProfile[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SocialProfile|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SocialProfile|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SocialProfile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SocialProfile[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SocialProfile findOrCreate($search, callable $callback = null, $options = [])
 */
class SocialProfilesTable extends SocialProfilesTablePlugin
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->belongsTo('Users');
    }
}
