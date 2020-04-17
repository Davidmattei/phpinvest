<?php

declare(strict_types=1);

namespace PhpInvest\Invest\Git;

use PhpInvest\Entity\Project;

final class Checkout
{
    private string $author;
    private string $authorEmail;
    private string $branch;
    private \DateTimeImmutable $commitDate;
    private string $directory;
    private string $hash;
    private Project $project;

    public function __construct(
        string $author,
        string $authorEmail,
        string $branch,
        \DateTimeImmutable $commitDate,
        string $directory,
        string $hash,
        Project $project
    ) {
        $this->author = $author;
        $this->authorEmail = $authorEmail;
        $this->branch = $branch;
        $this->commitDate = $commitDate;
        $this->directory = $directory;
        $this->hash = $hash;
        $this->project = $project;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getAuthorEmail(): string
    {
        return $this->authorEmail;
    }

    public function getBranch(): string
    {
        return $this->branch;
    }

    public function getCommitDate(): \DateTimeImmutable
    {
        return $this->commitDate;
    }

    public function getDirectory(): string
    {
        return $this->directory;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getProject(): Project
    {
        return $this->project;
    }
}
