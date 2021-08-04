<?php
declare(strict_types=1);

namespace AMB\Interactor;

final class FullName
{
    public function __invoke(array &$data, bool $removeParts = false): string
    {
        $parts = $this->gatherParts($data);
        $name = implode(' ', $parts);

        if (!empty($data['suffix'])) {
            $name .= ', ' . $data['suffix'];
        }
        if ($removeParts) {
            $fields = $this->getFields();
            foreach ($fields as $field) {
                unset($data[$field]);
            }
            unset($data['suffix']);
        }

        return $name;
    }

    public function transform(array $data): string
    {
        return $this->__invoke($data);
    }

    private function gatherParts(array $data): array
    {
        // order matters here
        $fields = $this->getFields();
        $parts = [];

        foreach ($fields as $field) {
            if (!empty($data[$field])) {
                $parts[] = $data[$field];
            }
        }

        return $parts;
    }

    private function getFields(): array
    {
        return [
            'firstName',
            'first_name',
            'member_first_name',
            'middleName',
            "middle_name",
            "member_middle_name",
            'lastName',
            'last_name',
            'member_last_name',
        ];
    }
}
