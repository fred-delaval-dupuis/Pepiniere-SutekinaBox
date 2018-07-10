<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 10/07/2018
 * Time: 10:42
 */

namespace App\Controller;


use App\Entity\Box;
use App\Entity\BoxProduct;
use App\Entity\Product;
use App\Form\BoxType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BoxController extends AbstractController
{
    /**
     * @Security("is_granted('ROLE_BOX_CREATOR')")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $box = new Box();

        $form = $this->createForm(BoxType::class, $box);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $box->setStatus(BOX::BOX_CREATED);
            $box->setUser($this->getUser());

            $products = $em->getRepository(Product::class)->findAll();

            foreach ($products as $product) {
                $boxProduct = new BoxProduct($box, $product, 1);
                $box->addBoxProduct($boxProduct);
                $product->addBoxProduct($boxProduct);

                $em->persist($boxProduct);
                // No need for product as it comes from a repository, so is already persisted
            }

            $em->persist($box);
            $em->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('Admin/Box/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Security("is_granted('ROLE_BOX_VALIDATOR')")
     */
    public function validate()
    {

    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @param Box $box
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function view(Box $box)
    {
        if (null === $box) {
            /**
             * @TODO set message flash
             */
            return $this->redirectToRoute('admin_index');
        }


        return $this->render('Admin/Box/view.html.twig', [
            'box'       => $box,
            'boxProducts'  => $box->getBoxProducts(),
        ]);

    }
}