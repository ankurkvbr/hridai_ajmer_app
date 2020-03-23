<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CraftFoodImage Entity
 *
 * @property int $id
 * @property int $craft_food_id
 * @property string $image
 * @property int $shorting_order
 * @property int $is_default
 * @property int $is_active
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time $updated_at
 *
 * @property \App\Model\Entity\CraftFood $craft_food
 */
class CraftFoodImage extends Entity
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
