<?php
declare(strict_types=1);

namespace AMB\Entity;

final class ReportData
{
    /** @var array */
    private $header;
    /** @var array */
    private $data;

    public function getHeader(): array
    {
        return $this->header;
    }

    public function setHeader(array $header): ReportData
    {
        $this->header = $header;

        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): ReportData
    {
        $this->data = $data;

        return $this;
    }

    public function addRow(array $row): ReportData
    {
        $this->data[] = $row;

        return $this;
    }
}
