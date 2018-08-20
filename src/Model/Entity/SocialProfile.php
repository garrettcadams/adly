<?php

namespace App\Model\Entity;

use ADmad\SocialAuth\Model\Entity\SocialProfile as SocialProfilePlugin;

/**
 * @property int $id
 * @property int $user_id
 * @property string $provider
 * @property string $identifier
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $full_name
 * @property string $email
 * @property string $email_verified
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \App\Model\Entity\User $user
 */
class SocialProfile extends SocialProfilePlugin
{
}
