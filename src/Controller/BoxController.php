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
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Workflow\Exception\TransitionException;
use Symfony\Component\Workflow\Registry;

class BoxController extends AbstractController
{
    /**
     * @Security("is_granted('ROLE_BOX_CREATOR')")
     *
     * @param Request $request
     * @param Registry $workflows
     * @param LoggerInterface $logger
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request, Registry $workflows, LoggerInterface $logger)
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

            // Workflow Management - current place is 'box_created', transitioning to waiting_for_products
            $workflow = $workflows->get($box);

            if ($workflow->can($box, 'add_product')) {
                try {
                    $workflow->apply($box, 'add_product');
                } catch (TransitionException $e) {
                    $this->logTransitionError($logger, $e, $box);
                }
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
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @param Request $request
     * @param Box $box
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function edit(Request $request, Box $box)
    {
        if (null === $box) {
            return $this->redirectToRoute('admin_index');
        }

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(BoxType::class, $box);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($box);
            $em->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('Admin/Box/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Security("is_granted('ROLE_BOX_CREATOR')")
     *
     * @param Box $box
     * @param Registry $workflows
     * @param LoggerInterface $logger
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addProducts(Box $box, Registry $workflows, LoggerInterface $logger)
    {
        if (null === $box) {
            return $this->redirectToRoute('admin_index');
        }

        $workflow = $workflows->get($box);

        if ($workflow->can($box, 'add_products')) {
            try {
                $workflow->apply($box, 'add_products');
                $this->getDoctrine()->getManager()->flush();
            } catch (TransitionException $e) {
                $this->logTransitionError($logger, $e, $box);
            }
        }

        return $this->redirectToRoute('admin_index');
    }

    /**
     * @Security("is_granted('ROLE_BOX_VALIDATOR')")
     *
     * @param Box $box
     * @param Registry $workflows
     * @param LoggerInterface $logger
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function order(Box $box, Registry $workflows, LoggerInterface $logger)
    {
        if (null === $box) {
            return $this->redirectToRoute('admin_index');
        }

        $workflow = $workflows->get($box);

        if ($workflow->can($box, 'order_products')) {
            try {
                $workflow->apply($box, 'order_products');
                $this->getDoctrine()->getManager()->flush();
            } catch (TransitionException $e) {
                $this->logTransitionError($logger, $e, $box);
            }
        }

        return $this->redirectToRoute('admin_index');
    }

    /**
     * @Security("is_granted('ROLE_BOX_VALIDATOR')")
     *
     * @param Box $box
     * @param Registry $workflows
     * @param LoggerInterface $logger
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function validate(Box $box, Registry $workflows, LoggerInterface $logger)
    {
        if (null === $box) {
            return $this->redirectToRoute('admin_index');
        }

        $workflow = $workflows->get($box);

        if ($workflow->can($box, 'validate')) {
            try {
                $workflow->apply($box, 'validate');
                $this->getDoctrine()->getManager()->flush();
            } catch (TransitionException $e) {
                $this->logTransitionError($logger, $e, $box);
            }
        }

        return $this->redirectToRoute('admin_index');
    }

    /**
     * @Security("is_granted('ROLE_BOX_VALIDATOR')")
     * @param Box $box
     * @param Registry $workflows
     * @param LoggerInterface $logger
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function invalidate(Box $box, Registry $workflows, LoggerInterface $logger)
    {
        if (null === $box) {
            return $this->redirectToRoute('admin_index');
        }

        $workflow = $workflows->get($box);

        if ($workflow->can($box, 'invalidate')) {
            try {
                $workflow->apply($box, 'invalidate');
                $this->getDoctrine()->getManager()->flush();
            } catch (TransitionException $e) {
                $this->logTransitionError($logger, $e, $box);
            }
        }

        return $this->redirectToRoute('admin_index');
    }

    public function addProductsInvalidated(Box $box, Registry $workflows, LoggerInterface $logger)
    {
        if (null === $box) {
            return $this->redirectToRoute('admin_index');
        }

        $workflow = $workflows->get($box);

        if ($workflow->can($box, 'add_products_invalidated')) {
            try {
                $workflow->apply($box, 'add_products_invalidated');
                $this->getDoctrine()->getManager()->flush();
            } catch (TransitionException $e) {
                $this->logTransitionError($logger, $e, $box);
            }
        }
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @param Box $box
     * @param Registry $workflows
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function view(Box $box, Registry $workflows)
    {
        if (null === $box) {
            /**
             * @TODO set message flash
             */
            return $this->redirectToRoute('admin_index');
        }

        $workflow = $workflows->get($box);
        dump($workflow->getEnabledTransitions($box));

        return $this->render('Admin/Box/view.html.twig', [
            'box'       => $box,
            'boxProducts'  => $box->getBoxProducts(),
        ]);
    }

    /**
     * @param LoggerInterface $logger
     * @param TransitionException $e
     * @param Box $box
     */
    private function logTransitionError(LoggerInterface $logger, TransitionException $e, Box $box)
    {
        $pattern = 'Workflow %s: Transition %s on Box %s was not allowed';
        $logger->error(sprintf($pattern, [$e->getWorkflow()->getName(), $e->getTransitionName(), $box->getTitle()]));
    }
}