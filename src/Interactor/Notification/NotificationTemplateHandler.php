<?php
declare(strict_types=1);

namespace AMB\Interactor\Notification;

use AMB\Entity\Notificataion\Template;
use AMB\Interactor\View\FormatDate;
use Doctrine\DBAL\Connection;
use Notification\Context\NotificationContext;

final class NotificationTemplateHandler
{
    /** @var \Doctrine\DBAL\Connection */
    protected $connection;
    /** @var \AMB\Entity\Notificataion\Template */
    private $template;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function handle(string $template, NotificationContext $context)
    {
        $this
            ->loadTemplate($template)
            ->setToday($context)
            ->setSubject($context);
    }

    private function loadTemplate(string $name): self
    {
        $statement = $this->connection->executeQuery("SELECT * FROM email_templates WHERE `name` = '$name'");

        $data = $statement->fetchAssociative();

        $this->template = (new Template())
            ->setChannel('email')
            ->setId($data['id'])
            ->setName($data['name'])
            ->setSubject($data['subject'])
            ->setType($data['email_type']);

        return $this;
    }

    private function setSubject(NotificationContext $notificationContext): self
    {
        $subject = $this->template->getSubject();
        $context = $notificationContext->toArray();

        $replace = function($matches) use ($context) {
            $key = trim($matches[1]);

            return $context[$key];
        };

        $subject = preg_replace_callback('#{{(.+?)}}#', $replace, $subject);
        $notificationContext->getMeta('email')->setSubject($subject);

        return $this;
    }

    private function setToday(NotificationContext $notificationContext): self
    {
        $notificationContext->set('today', (new FormatDate)());

        return $this;
    }
}
