<?php
declare(strict_types=1);

namespace AMB\Interactor\Notification;

use AMB\Entity\Notificataion\Template;
use AMB\Interactor\View\FormatDate;
use Doctrine\DBAL\Connection;
use IamPersistent\SwiftMailer\Context\EmailContext;

final class EmailTemplateHandler
{
    /** @var \Doctrine\DBAL\Connection */
    protected $connection;
    /** @var \AMB\Entity\Notificataion\Template */
    private $template;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function handle(EmailContext $context)
    {
        $this->template = $this->loadTemplate($context->getTemplate());
        $this->setToday($context);
        $this->setSubject($context);
        $context->setTemplate($context->getTemplate() . '.html.twig');
    }

    private function loadTemplate(string $name)
    {
        $statement = $this->connection->executeQuery("SELECT * FROM email_templates WHERE `name` = '$name'");

        $data = $statement->fetch();

        return (new Template())
            ->setId($data['id'])
            ->setName($data['name'])
            ->setSubject($data['subject'])
            ->setType($data['email_type']);
    }

    private function setSubject(EmailContext $emailContext)
    {
        $subject = $this->template->getSubject();
        $context = $emailContext->getBodyContext();

        $replace = function($matches) use ($context) {
            $key = trim($matches[1]);

            return $context[$key];
        };

        $subject = preg_replace_callback('#{{(.+?)}}#', $replace, $subject);
        $emailContext->setSubject($subject);

        $context['_subject'] = $subject;
        $emailContext->setBodyContext($context);
    }

    private function setToday(EmailContext $emailContext)
    {
        $context = $emailContext->getBodyContext();
        $context['today'] = (new FormatDate)();
        $emailContext->setBodyContext($context);
    }
}
