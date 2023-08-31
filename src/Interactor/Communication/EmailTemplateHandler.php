<?php
declare(strict_types=1);

namespace AMB\Interactor\Communication;

use AMB\Entity\Communication\Template;
use AMB\Interactor\View\FormatDate;
use Communication\Context\EmailContext;
use Doctrine\DBAL\Connection;

final class EmailTemplateHandler
{
    private Template $template;

    public function __construct(
        private Connection $connection,
    ) {
    }

    public function handle(EmailContext $context)
    {
        $this->template = $this->loadTemplate($context->getHtmlTemplate());
        $this->setToday($context);
        $this->setSubject($context);
    }

    private function loadTemplate(string $name)
    {
        if ($name === 'blank') {
            $name = 'generic';
        }
        $statement = $this->connection->executeQuery("SELECT * FROM email_templates WHERE `name` = '$name'");

        $data = $statement->fetchAssociative();

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

            return $context[$key] ?? null;
        };

        $subject = preg_replace_callback('#{{(.+?)}}#', $replace, $subject);
        if (!empty($subject)) {
            $emailContext->setSubject($subject);
        } else {
            $subject = $emailContext->getSubject();
        }

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
