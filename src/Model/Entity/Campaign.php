<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * @property int $user_id
 * @property int $id
 * @property bool $default_campaign
 * @property int $ad_type
 * @property int $status
 * @property string $payment_method
 * @property string $name
 * @property string $website_title
 * @property string $website_url
 * @property string $banner_name
 * @property string $banner_size
 * @property string $banner_code
 * @property float $price
 * @property int $traffic_source
 * @property string $transaction_id
 * @property string $transaction_details
 * @property \Cake\I18n\FrozenTime $started
 * @property \Cake\I18n\FrozenTime $completed
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $created
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\CampaignItem[] $campaign_items
 * @property \App\Model\Entity\Statistic[] $statistics
 * @property \App\Model\Entity\Invoice $invoice
 */
class Campaign extends Entity
{
}
