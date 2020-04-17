<?php

declare(strict_types=1);

namespace PhpInvest\Invest\Collection;

use PhpInvest\Entity\Project;

final class ProjectCollection implements \IteratorAggregate
{
    private array $projects;

    public function __construct(Project ...$projects)
    {
        $this->projects = $projects;
    }

    public function add(Project $project): ProjectCollection
    {
        return new self($project, ...$this->projects);
    }

    public function count(): int
    {
        return count($this->projects);
    }

    public function filter(callable $callback): ProjectCollection
    {
        return new self(...array_filter($this->projects, $callback));
    }

    public function first(): ?Project
    {
        return $this->projects[0] ?? null;
    }

    /**
     * @return \Generator|Project[]
     */
    public function getIterator(): \Generator
    {
        foreach ($this->projects as $project) {
            yield $project;
        }
    }

    public function getNames(): array
    {
        return array_map(fn (Project $project) => $project->getName(), $this->projects);
    }

    public function isEmpty(): bool
    {
        return 0 === $this->count();
    }

    public function map(callable $callback): array
    {
        return array_map($callback, $this->projects);
    }
}
