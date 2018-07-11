<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 10/07/2018
 * Time: 17:12
 */

namespace App\Subscriber;


use App\Entity\Box;
use App\Entity\User;
use App\Service\EventServiceMapper;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\Event;

class WorkflowMailer implements EventSubscriberInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var EventServiceMapper
     */
    private $mapper;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var string
     */
    private $adminEmail;

    /**
     * WorkflowMailer constructor.
     * @param \Swift_Mailer $mailer
     * @param EventServiceMapper $mapper
     * @param EntityManagerInterface $manager
     * @param LoggerInterface $logger
     * @param string $adminEMail
     */
    public function __construct(\Swift_Mailer $mailer, EventServiceMapper $mapper, EntityManagerInterface $manager, LoggerInterface $logger, string $adminEMail)
    {
        $this->mailer       = $mailer;
        $this->mapper       = $mapper;
        $this->manager      = $manager;
        $this->logger       = $logger;
        $this->adminEmail   = $adminEMail;
    }

    public static function getSubscribedEvents()
    {
        return [
            'workflow.box_creation.leave' => 'onLeave',
        ];
    }

    public function onLeave(Event $event)
    {
        /**
         * @var Box $box
         */
        $box = $event->getSubject();
        $transitionName = $event->getTransition()->getName();

        $role = $this->mapper->getRole($transitionName);

        if (null === $role) {
            return;
        }

        $users = $this->manager->getRepository(User::class)->getUsersFromRole($role);

        if (null === $users) {
            return;
        }

        $message = new \Swift_Message(sprintf($this->mapper->getMailSubject($transitionName), $box->getTitle()) , sprintf($this->mapper->getMailBody($transitionName), $box->getTitle()));
        /**
         * @TODO decide which email to set as From
         */
        $message->addFrom($this->adminEmail);

        /**
         * @var User $user
         */
        foreach ($users as $user) {
            $message->addTo($user->getEmail());
        }

        $tos = array_keys($message->getTo());
        $this->logger->debug('Mail "' .  $message->getSubject() . '" sent to: ' . implode(', ', $tos) . ' with content: ' . $message->getBody());

//        $this->mailer->send($message);
    }

}