<?php
declare(strict_types=1);

namespace AMB\Interactor;

final class FullName
{
    public function __invoke(array $data)
    {
        $parts = $this->gatherParts($data);
        $name = implode(' ', $parts);

        if (!empty($data['suffix'])) {
            $name .= ', ' . $data['suffix'];
        }

        return $name;
    }

    private function gatherParts(array $data): array
    {
        // order matters here
        $fields = [
            'firstName',
            'first_name',
            'middleName',
            "middle_name",
            'lastName',
            'last_name',
        ];
        $parts = [];

        foreach ($fields as $field) {
            if (!empty($data[$field])) {
                $parts[] = $data[$field];
            }
        }

        return $parts;
    }
}
