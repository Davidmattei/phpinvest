<?php

declare(strict_types=1);

namespace PhpInvest\Service\File;

use PhpInvest\Entity\File;
use PhpInvest\Entity\GitRevision;
use PhpInvest\Invest\Collection\FileCollection;
use PhpInvest\Repository\FileRepository;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

final class FileService
{
    private FileRepository $fileRepository;

    public function __construct(FileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function scan(string $directory, GitRevision $revision): void
    {
        $fileCollection = new FileCollection();

        foreach ($this->find($directory) as $fileInfo) {
            $file = File::fromFileInfo($fileInfo);
            $fileCollection = $fileCollection->add($file);
        }

        $this->fileRepository->saveCollection($fileCollection);
    }

    /**
     * @return \Generator|SplFileInfo[]
     */
    private function find(string $directory): \Generator
    {
        $finder = new Finder();
        $finder
            ->files()
            ->in($directory)
            ->ignoreVCSIgnored(true);

        foreach ($finder as $fileInfo) {
            yield $fileInfo;
        }
    }

}
