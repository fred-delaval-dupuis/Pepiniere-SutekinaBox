<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 09/07/2018
 * Time: 14:30
 */

namespace App\Controller;

use App\Entity\Box;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class AdminController extends Controller
{
    /**
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $boxes = $this->getDoctrine()->getRepository(Box::class)->findAll();

        return $this->render('Admin/index.html.twig', [
            'boxes' => $boxes,
        ]);
    }
}