<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CraftFood Entity
 *
 * @property int $id
 * @property string $title
 * @property int $category
 * @property string $description
 * @property string $short_description
 * @property bool $is_active
 * @property string $address
 * @property string $latitude
 * @property string $longitude
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time $updated_at
 *
 * @property \App\Model\Entity\CraftFoodImage[] $craft_food_images
 */
class CraftFood extends Entity
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
