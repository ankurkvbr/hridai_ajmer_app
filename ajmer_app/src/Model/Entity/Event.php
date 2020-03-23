<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Event Entity
 *
 * @property int $id
 * @property string $event_name
 * @property string $event_description
 * @property \Cake\I18n\Time $even_date_time
 * @property string $address
 * @property string $latitude
 * @property string $longitude
 * @property string $url
 * @property int $state_id
 * @property int $city_id
 * @property bool $is_active
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time $updated_at
 *
 * @property \App\Model\Entity\EventEventNameTranslation $event_name_translation
 * @property \App\Model\Entity\EventEventDescriptionTranslation $event_description_translation
 * @property \App\Model\Entity\EventTranslation[] $_i18n
 * @property \App\Model\Entity\State $state
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\EventImage[] $event_images
 */
class Event extends Entity
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
