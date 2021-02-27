<?php
declare(strict_types=1);

namespace AMB\Notification\Context;

final class ActivityLogContext
{
    /** @var string */
    private $formatter;

    public function getFormatter()
    {
        return $this->formatter;
    }

    public function setFormatter($formatter): ActivityLogContext
    {
        $this->formatter = $formatter;

        return $this;
    }
}
