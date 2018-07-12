<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 12/07/2018
 * Time: 15:32
 */

namespace App\Subscriber;


use App\Entity\Box;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\GuardEvent;

class BoxTransitionGuardSubscriber implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * WorkflowLogger constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return [
            'workflow.box_creation.guard.add_products'              => ['guardAddProducts'],
            'workflow.box_creation.guard.order_products'            => ['guardOrderProducts'],
            'workflow.box_creation.guard.validate'                  => ['guardValidate'],
            'workflow.box_creation.guard.invalidate'                => ['guardInvalidate'],
            'workflow.box_creation.guard.add_products_invalidated'  => ['guardAddProductsInvalidated'],
        ];
    }

    # from: box_created -> to: box_filled
    public function guardAddProducts(GuardEvent $event)
    {
        $this->logGuard($event);
        /** @var Box $box */
        $box = $event->getSubject();
        if (empty($box->getBoxProducts())) {
            $event->setBlocked(true);
        }
    }

    # from: box_filled -> to: validation
    public function guardOrderProducts(GuardEvent $event)
    {
        $this->logGuard($event);
        // do nothing
    }

    # from: validation -> to: go
    public function guardValidate(GuardEvent $event)
    {
        $this->logGuard($event);
        /** @var Box $box */
        $box = $event->getSubject();
        $boxProducts = $box->getBoxProducts();

        $datesFilled = true;
        $valid = true;
        foreach ($boxProducts as $boxProduct) {
            $datesFilled &= ! empty($boxProduct->getReceptionDate());
            $valid &= $boxProduct->getValid();
        }

        $event->setBlocked(! ($datesFilled && $valid));
    }

    # from: validation -> to: invalidated
    public function guardInvalidate(GuardEvent $event)
    {
        $this->logGuard($event);
        /** @var Box $box */
        $box = $event->getSubject();
        $boxProducts = $box->getBoxProducts();

        $datesFilled = true;
        $valid = true;
        foreach ($boxProducts as $boxProduct) {
            $datesFilled &= ! empty($boxProduct->getReceptionDate());
            $valid &= $boxProduct->getValid();
        }

//        $this->logger->debug('datesFilled = ' . $datesFilled);
//        $this->logger->debug('valid = ' . $valid);

        $event->setBlocked(! ($datesFilled && ! $valid));
    }

    # from: invalidated -> to: box_filled
    public function guardAddProductsInvalidated(GuardEvent $event)
    {
        $this->logGuard($event);
        // do nothing
    }

    private function logGuard(GuardEvent $event)
    {
        $this->logger->alert(sprintf(
            'BoxTransitionGuard : Box (id: "%s") is trying to perform transition "%s" from "%s" to "%s"',
            $event->getSubject()->getId(),
            $event->getTransition()->getName(),
            implode(', ', array_keys($event->getMarking()->getPlaces())),
            implode(', ', $event->getTransition()->getTos())
        ));
    }
}