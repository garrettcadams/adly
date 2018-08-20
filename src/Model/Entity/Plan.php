<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * @property string $title
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $created
 * @property int $id
 * @property bool $enable
 * @property bool $hidden
 * @property string $description
 * @property float $monthly_price
 * @property float $yearly_price
 * @property bool $edit_link
 * @property bool $edit_long_url
 * @property bool $multi_domains
 * @property bool $disable_ads
 * @property bool $disable_captcha
 * @property bool $onetime_captcha
 * @property bool $direct
 * @property bool $alias
 * @property bool $referral
 * @property bool $stats
 * @property bool $api_quick
 * @property bool $api_mass
 * @property bool $api_full
 * @property bool $api_developer
 * @property bool $bookmarklet
 * @property \App\Model\Entity\User[] $users
 * @property \App\Model\Entity\PlansTitleTranslation $title_translation
 * @property \App\Model\Entity\PlansDescriptionTranslation $description_translation
 * @property \App\Model\Entity\I18n[] $_i18n
 */
class Plan extends Entity
{
}
