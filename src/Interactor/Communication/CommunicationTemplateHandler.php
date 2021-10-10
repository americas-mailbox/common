<?php
declare(strict_types=1);

namespace AMB\Interactor\Communication;

use AMB\Entity\Communication\Template;
use AMB\Interactor\View\FormatDate;
use Doctrine\DBAL\Connection;
use Communication\Context\CommunicationContext;

final class CommunicationTemplateHandler
{
    private Template $template;

    public function __construct(
        private Connection $connection,
    )  {
    }

    public function handle(string $template, CommunicationContext $context)
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

    private function setSubject(CommunicationContext $notificationContext): self
    {
        $subject = $this->template->getSubject();
        $context = $notificationContext->toArray();

        $replace = function($matches) use ($context) {
            $key = trim($matches[1]);

            return $context[$key] ?? '';
        };

        $subject = preg_replace_callback('#{{(.+?)}}#', $replace, $subject);
        $notificationContext->getMeta('email')->setSubject($subject);

        return $this;
    }

    private function setToday(CommunicationContext $notificationContext): self
    {
        $notificationContext->set('today', (new FormatDate)());

        return $this;
    }
}
