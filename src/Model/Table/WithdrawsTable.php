<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Withdraw get($primaryKey, $options = [])
 * @method \App\Model\Entity\Withdraw newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Withdraw[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Withdraw|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Withdraw|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Withdraw patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Withdraw[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Withdraw findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WithdrawsTable extends Table
{
    public function initialize(array $config)
    {
        $this->belongsTo('Users');
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('amount')
            ->notEmpty('amount', __('You must have a balance.'));

        return $validator;
    }
}
