<?php

declare(strict_types=1);

namespace PhpInvest\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Finder\SplFileInfo;

final class File
{
    private \DateTimeImmutable $cTime;
    private string $filename;
    private UuidInterface $id;
    private string $relativePath;
    private int $size;

    private function __construct(\DateTimeImmutable $cTime, string $filename, string $relativePath, int $size)
    {
        $this->cTime = $cTime;
        $this->filename = $filename;
        $this->id = Uuid::uuid4();
        $this->relativePath = $relativePath;
        $this->size = $size;
    }

    public static function fromFileInfo(SplFileInfo $fileInfo): File
    {
        $cTime = new \DateTimeImmutable();
        $cTime->setTimestamp($fileInfo->getCTime());

        return new self(
            $cTime,
            $fileInfo->getFilename(),
            $fileInfo->getRelativePath(),
            $fileInfo->getSize()
        );
    }

    public function getCTime(): \DateTimeImmutable
    {
        return $this->cTime;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getRelativePath(): string
    {
        return $this->relativePath;
    }

    public function getSize(): int
    {
        return $this->size;
    }
}
