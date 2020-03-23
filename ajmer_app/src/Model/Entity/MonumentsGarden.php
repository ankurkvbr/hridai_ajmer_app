<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MonumentsGarden Entity
 *
 * @property int $id
 * @property string $title
 * @property int $category
 * @property string $description
 * @property int $state_id
 * @property int $cities_id
 * @property bool $is_active
 * @property string $address
 * @property string $latitude
 * @property string $longitude
 * @property string $tour_title
 * @property string $tour_video
 * @property string $audio
 * @property string $audio_cover_image
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time $updated_at
 *
 * @property \App\Model\Entity\MonumentsGardensTitleTranslation $title_translation
 * @property \App\Model\Entity\MonumentsGardensDescriptionTranslation $description_translation
 * @property \App\Model\Entity\MonumentsGardensTranslation[] $_i18n
 * @property \App\Model\Entity\State $state
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\MonumentsGardensTranslation $inner_translation
 * @property \App\Model\Entity\MonumentsGardensImage[] $monuments_gardens_images
 * @property \App\Model\Entity\MonumentsGardensTranslation[] $monuments_gardens_translation
 * @property \App\Model\Entity\MonumentReview $monument_review
 */
class MonumentsGarden extends Entity
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
