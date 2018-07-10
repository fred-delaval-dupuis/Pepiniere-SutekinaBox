<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 09/07/2018
 * Time: 16:57
 */

namespace App\Controller;


use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{

    public function login(Request $request, AuthenticationUtils $utils)
    {
        // already logged
        if ($this->getUser()) {
            return $this->redirectToRoute('admin_index');
        }

        $error = $utils->getLastAuthenticationError();

        $lastUsername = $utils->getLastUsername();

        $form = $this->createForm(LoginType::class, [
            'email' => $lastUsername,
        ]);

        return $this->render('Admin/login.html.twig', [
            'form'  => $form->createView(),
            'error' => $error,
        ]);
    }
}