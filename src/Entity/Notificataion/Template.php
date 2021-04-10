<?php
declare(strict_types=1);

namespace AMB\Entity\Notificataion;

final class Template
{
    /** @var string */
    private $channel;
    /** @var mixed */
    private $id;
    /** @var string */
    private $name;
    /** @var string */
    private $subject;
    /** @var string */
    private $type;

    public function getChannel(): string
    {
        return $this->channel;
    }

    public function setChannel(string $channel): Template
    {
        $this->channel = $channel;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): Template
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Template
    {
        $this->name = $name;

        return $this;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): Template
    {
        $this->subject = $subject;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): Template
    {
        $this->type = $type;

        return $this;
    }
}
