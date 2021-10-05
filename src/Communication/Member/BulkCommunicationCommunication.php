<?php
declare(strict_types=1);

namespace AMB\Communication\Member;

use AMB\Communication\MemberCommunication;
use AMB\Entity\BulkCommunication;
use AMB\Entity\Member;

final class BulkCommunicationCommunication extends MemberCommunication
{
    public function dispatch(Member $member, BulkCommunication $communication)
    {
        $this->setValuesFromMember($member);
        $this->setTemplateContext($member, $communication);

        $this->send();

        return true;
    }

    private function setTemplateContext(Member $member, BulkCommunication $communication)
    {
        $emailBodyContext = [
            'body' => $communication->getEmailBody(),
            'plan' => $member->getPlan()->getPlan()->getTitle(),
            'subject' => $communication->getSubject(),
        ];
        $this->context
            ->set('body', $communication->getEmailBody())
            ->set('plan', $member->getPlan()->getPlan()->getTitle())
            ->set('subject', $communication->getSubject());
    }

    protected function getTemplates(): array
    {
        return [
            'email' => [
                'html' => 'bulk-communication'
            ],
        ];
    }
}
