<?php
declare(strict_types=1);

namespace AMB\Interactor\Image;

use Doctrine\DBAL\Connection;
use League\Flysystem\Config;
use League\Flysystem\Visibility;
use Psr\Http\Message\UploadedFileInterface;
use Ramsey\Uuid\Uuid;
use Zestic\Flysystem\Files;

final readonly class UploadImage
{
    public function __construct(
        private Connection $connection,
        private Files $files,
    ) { }

    public function upload(UploadedFileInterface $file)
    {
        $this->connection->beginTransaction();

        try {
            $content = $file->getStream()->getContents();
            $id = Uuid::uuid4();
            $filePath = "$id.png";
            $filename = $this->files->write(
                $filePath,
                $content,
                [Config::OPTION_VISIBILITY => Visibility::PUBLIC]
            );
            $imageData = [
                'filepath' => $filePath,
                'id'       => $id,
            ];
            $response = $this->connection->insert('images', $imageData);
            if (1 !== $response) {
                throw new \Exception('There was a problem saving the image');
            }
        } catch (\Exception $e) {
            $this->connection->rollBack();

            throw $e;
        }
        $this->connection->commit();

        return $filePath;
    }
}
