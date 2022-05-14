<?php
declare(strict_types=1);

namespace AMB\Entity\Member;

use AMB\Entity\Plan as AMBPlan;
use AMB\Entity\RenewalFrequency;
use Carbon\Carbon;

final class Plan
{
    /** @var \AMB\Entity\RenewalFrequency */
    private $renewalFrequency;
    /** @var \AMB\Entity\Plan */
    private $plan;
    /** @var \Carbon\Carbon */
    private $renewsOn;

    public function getRenewalFrequency(): RenewalFrequency
    {
        return $this->renewalFrequency;
    }

    public function setRenewalFrequency(RenewalFrequency $renewalFrequency): Plan
    {
        $this->renewalFrequency = $renewalFrequency;

        return $this;
    }

    public function getPlan(): AMBPlan
    {
        return $this->plan;
    }

    public function setPlan(AMBPlan $plan): Plan
    {
        $this->plan = $plan;
        $this->renewalFrequency = $plan->getRenewalFrequency();

        return $this;
    }

    public function getRenewsOn(): Carbon
    {
        return $this->renewsOn;
    }

    public function setRenewsOn(Carbon $renewsOn): Plan
    {
        $this->renewsOn = $renewsOn;

        return $this;
    }
}
