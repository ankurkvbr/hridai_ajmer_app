<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Project Entity
 *
 * @property int $id
 * @property string $project_name
 * @property string $project_description
 * @property string $address
 * @property string $latitude
 * @property string $longitude
 * @property int $state_id
 * @property int $cities_id
 * @property bool $is_active
 * @property string $url
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time $updated_at
 *
 * @property \App\Model\Entity\ProjectProjectNameTranslation $project_name_translation
 * @property \App\Model\Entity\ProjectProjectDescriptionTranslation $project_description_translation
 * @property \App\Model\Entity\ProjectAddressTranslation $address_translation
 * @property \App\Model\Entity\ProjectCreatedAtTranslation $created_at_translation
 * @property \App\Model\Entity\ProjectTranslation[] $_i18n
 * @property \App\Model\Entity\State $state
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\ProjectTranslation $inner_translation
 * @property \App\Model\Entity\ProjectImage[] $project_images
 * @property \App\Model\Entity\ProjectTranslation[] $project_translation
 */
class Project extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
