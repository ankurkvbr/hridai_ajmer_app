<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MonumentRating Entity
 *
 * @property int $id
 * @property int $monument_id
 * @property string $rating
 * @property int $is_publish
 *
 * @property \App\Model\Entity\MonumentsGarden $monuments_garden
 */
class MonumentRating extends Entity
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
