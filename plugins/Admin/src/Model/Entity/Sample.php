<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;

/**
 * Sample Entity
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $image
 * @property bool $active
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $created
 */
class Sample extends Entity
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
        'title' => true,
        'description' => true,
        'content' => true,
        'image' => true,
        'active' => true,
        'modified' => true,
        'created' => true
    ];
}
