<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 12/07/2018
 * Time: 10:00
 */

namespace App\Helper;


use Symfony\Component\Translation\TranslatorInterface;

trait TranslatorHelperTrait
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * TranslatorHelperTrait constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

}