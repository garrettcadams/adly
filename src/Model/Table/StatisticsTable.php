<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use GeoIp2\Database\Reader;

/**
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\LinksTable|\Cake\ORM\Association\BelongsTo $Links
 * @property \App\Model\Table\CampaignsTable|\Cake\ORM\Association\BelongsTo $Campaigns
 *
 * @method \App\Model\Entity\Statistic get($primaryKey, $options = [])
 * @method \App\Model\Entity\Statistic newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Statistic[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Statistic|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Statistic|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Statistic patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Statistic[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Statistic findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StatisticsTable extends Table
{
    public function initialize(array $config)
    {
        $this->belongsTo('Users');
        $this->belongsTo('Links');
        $this->belongsTo('Campaigns');
        $this->addBehavior('Timestamp');
    }

    public function get_country($ip)
    {
        try {
            $reader = new Reader(CONFIG . 'binary/geoip/GeoLite2-Country.mmdb');
            $record = $reader->country($ip);
            $countryCode = (trim($record->country->isoCode)) ? $record->country->isoCode : 'Others';
        } catch (\Exception $ex) {
            $countryCode = 'Others';
        }

        return $countryCode;
    }
}
