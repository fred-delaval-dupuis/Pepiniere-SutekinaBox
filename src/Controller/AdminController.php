<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 09/07/2018
 * Time: 14:30
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class AdminController extends Controller
{
    public function index()
    {
        return $this->render('Admin/layout.html.twig');
    }
}