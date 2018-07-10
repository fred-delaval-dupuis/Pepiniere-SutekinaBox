<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 10/07/2018
 * Time: 17:15
 */

namespace App\Service;


class EventServiceMapper
{
    const TRANSITIONS   = 'transitions';
    const PLACES        = 'places';

    private static $mappings = [
        'transitions' => [
            'add_products' => 'ROLE_BOX_CREATOR',
            'order_products' => 'ROLE_BOX_VALIDATOR',
            'validate' => 'ROLE_BOX_CREATOR',
            'invalidate' => 'ROLE_BOX_CREATOR',
            'add_products_invalidated' =>  'ROLE_BOX_CREATOR',
        ],
        'places' => [
            'box_created' => 'ROLE_BOX_CREATOR',
            'box_filled'  => 'ROLE_BOX_VALIDATOR',
            'validation'  => 'ROLE_BOX_CREATOR',
            'invalidated' => 'ROLE_BOX_CREATOR',
            'go'  => 'ROLE_BOX_CREATOR',
        ],
    ];

    /**
     * @param string $key
     * @param string $type
     * @return null|string
     */
    public function get(string $key, string $type = self::PLACES): ?string
    {
        if (isset (self::$mappings[$type][$key])) {
            return self::$mappings[$type][$key];
        } else {
            return null;
        }
    }
}