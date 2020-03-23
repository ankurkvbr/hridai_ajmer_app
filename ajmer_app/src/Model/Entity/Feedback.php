<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Feedback Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $feedback_for_id
 * @property int $feedback_category_id
 * @property float $rating
 * @property string $description
 * @property \Cake\I18n\Time $created_at
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\FeedbackFor $feedback_for
 * @property \App\Model\Entity\FeedbackCategory $feedback_category
 */
class Feedback extends Entity
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
