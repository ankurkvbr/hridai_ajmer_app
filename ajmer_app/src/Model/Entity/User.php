<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;
/**
 * User Entity
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $password
 * @property string $email
 * @property string $address
 * @property string $state_id
 * @property string $city_id
 * @property int $mobile_no
 * @property \Cake\I18n\Time $dob
 * @property int $postal_code
 * @property int $role_id
 * @property \Cake\I18n\Time $registration_date
 * @property int $updated_by
 * @property \Cake\I18n\Time $updated_date
 * @property string $device_type
 * @property string $device_token
 * @property int $status
 * @property string $fp_token
 * @property \Cake\I18n\Time $fp_token_at
 * @property int $social_flag
 * @property string  $social_id
 * @property string $otp
 *
 * @property \App\Model\Entity\State $state
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Role $role
 */
class User extends Entity
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


    protected function _setPassword($value) {
        return (new DefaultPasswordHasher)->hash($value);
    }

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
}
