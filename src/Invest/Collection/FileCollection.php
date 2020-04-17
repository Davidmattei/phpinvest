<?php

declare(strict_types=1);

namespace PhpInvest\Invest\Collection;

use PhpInvest\Entity\File;

final class FileCollection implements \IteratorAggregate
{
    private array $files;

    public function __construct(File ...$files)
    {
        $this->files = $files;
    }

    public function add(File $file): FileCollection
    {
        return new self($file, ...$this->files);
    }

    public function count(): int
    {
        return count($this->files);
    }

    /**
     * @return \Generator|File[]
     */
    public function getIterator(): \Generator
    {
        foreach ($this->files as $file) {
            yield $file;
        }
    }

    public function map(callable $callback): array
    {
        return array_map($callback, $this->files);
    }
}
