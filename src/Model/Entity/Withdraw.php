<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * @property int $user_id
 * @property int $status
 * @property float $publisher_earnings
 * @property float $referral_earnings
 * @property float $amount
 * @property string $method
 * @property string $account
 * @property \Cake\I18n\FrozenTime $created
 * @property int $id
 * @property string $transaction_id
 * @property \App\Model\Entity\User $user
 */
class Withdraw extends Entity
{
}
