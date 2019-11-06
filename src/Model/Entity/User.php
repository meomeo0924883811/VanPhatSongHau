<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string|null $firstname
 * @property string|null $lastname
 * @property string|null $email
 * @property string $password
 * @property bool|null $is_active
 * @property string|null $role
 * @property \Cake\I18n\Time|null $last_login
 * @property \Cake\I18n\Time|null $last_edit
 * @property \Cake\I18n\Time|null $created
 * @property \Cake\I18n\Time|null $modified
 *
 * @property \App\Model\Entity\LogUser[] $log_users
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
        'firstname' => true,
        'lastname' => true,
        'email' => true,
        'password' => true,
        'is_active' => true,
        'role' => true,
        'last_login' => true,
        'last_edit' => true,
        'created' => true,
        'modified' => true,
        'log_users' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
}
