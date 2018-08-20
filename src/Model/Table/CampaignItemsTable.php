<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * @property \App\Model\Table\CampaignsTable|\Cake\ORM\Association\BelongsTo $Campaigns
 *
 * @method \App\Model\Entity\CampaignItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\CampaignItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CampaignItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CampaignItem|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CampaignItem|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CampaignItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CampaignItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CampaignItem findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CampaignItemsTable extends Table
{
    public function initialize(array $config)
    {
        $this->belongsTo('Campaigns');
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            //->requirePresence('purchase')
            ->allowEmpty('purchase')
            ->naturalNumber('purchase', __('Write a valid natural number.'));

        return $validator;
    }
}
