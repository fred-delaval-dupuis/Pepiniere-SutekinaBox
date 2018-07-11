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
            'add_products' => [
                'role'          => 'ROLE_BOX_CREATOR',
                'mail-subject'    => 'Box %s products are ready to be ordered',
                'mail-body'     => 'The Box %s is ready to get to the next step. Please see to the ordering of the products in this <a href="">Box here</a>'
            ],
            'order_products' => [
                'role'          => 'ROLE_BOX_VALIDATOR',
                'mail-subject'    => 'Box %s - Products ordered',
                'mail-body'     => 'The products for the Box %s have been ordered. Please be patient while we receive all the products and verify their conformity!'
            ],
            'validate' => [
                'role'          => 'ROLE_BOX_CREATOR',
                'mail-subject'    => 'Box %s has been validated',
                'mail-body'     => 'The Box %s has been validated. It is a "go" for us, so the Box has been sent to Packaging!'
            ],
            'invalidate' => [
                'role'          => 'ROLE_BOX_CREATOR',
                'mail-subject'    => 'Box %s has been invalidated',
                'mail-body'     => 'Sorry, the Box %s has been deemed unsendable. Please read the description in the Box panel to update its content!'
            ],
            'add_products_invalidated' => [
                'role'          => 'ROLE_BOX_CREATOR',
                'mail-subject'    => 'Box %s needs to be updated',
                'mail-body'     => 'Sorry, the Box %s has been deemed unsendable. Please, select other products to be part of the Box!'
            ],
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
     * @param string $attr
     * @param string $key
     * @param string $type
     * @return null|string
     */
    private function get(string $attr, string $key, string $type = self::TRANSITIONS): ?string
    {
        if (isset (self::$mappings[$type][$key])) {
            return self::$mappings[$type][$key][$attr];
        } else {
            return null;
        }
    }

    /**
     * @param string $key
     * @param string $type
     * @return null|string
     */
    public function getRole(string $key, string $type = self::TRANSITIONS): ?string
    {
        return $this->get('role', $key, $type);
    }

    /**
     * @param string $key
     * @param string $type
     * @return null|string
     */
    public function getMailSubject(string $key, string $type = self::TRANSITIONS): ?string
    {
        return $this->get('mail-subject', $key, $type);
    }

    /**
     * @param string $key
     * @param string $type
     * @return null|string
     */
    public function getMailBody(string $key, string $type = self::TRANSITIONS): ?string
    {
        return $this->get('mail-body', $key, $type);
    }

}