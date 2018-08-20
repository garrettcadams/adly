<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * @property int $user_id
 * @property int $ad_type
 * @property int $status
 * @property string $url
 * @property string $domain
 * @property string $alias
 * @property string $title
 * @property string description
 * @property string image
 * @property int $hits
 * @property int $method
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $created
 * @property int $id
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Statistic[] $statistics
 */
class Link extends Entity
{
}
