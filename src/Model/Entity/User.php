<?php

namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * @property int $status
 *
 * @property string $username
 * @property string $email
 * @property string $temp_email
 * @property bool $disable_earnings
 * @property string $role
 * @property int $plan_id
 * @property string $api_token
 * @property float $wallet_money
 * @property float $publisher_earnings
 * @property float $referral_earnings
 * @property int $referred_by
 * @property \App\Model\Entity\Plan $plan
 * @property string $first_name
 * @property string $last_name
 * @property string $address1
 * @property string $address2
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $country
 * @property string $phone_number
 * @property string $withdrawal_method
 * @property string $withdrawal_account
 * @property string $login_ip
 * @property string register_ip
 * @property \Cake\I18n\FrozenTime $expiration
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property int $id
 * @property string $password
 * @property string $activation_key
 * @property float $advertiser_balance
 * @property \App\Model\Entity\Campaign[] $campaigns
 * @property \App\Model\Entity\Link[] $links
 * @property \App\Model\Entity\Statistic[] $statistics
 * @property \App\Model\Entity\Withdraw[] $withdraws
 * @property \App\Model\Entity\Invoice[] $invoices
 * @property \App\Model\Entity\SocialProfile[] $social_profiles
 */
class User extends Entity
{

    // Make all fields mass assignable for now.
    protected $_accessible = ['*' => true];

    protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }
}
