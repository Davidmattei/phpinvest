<?php

declare(strict_types=1);

namespace PhpInvest\Entity;

use PhpInvest\Invest\Git\Checkout;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class GitRevision
{
    private string $author;
    private string $authorEmail;
    private string $branch;
    private \DateTimeImmutable $commitDate;
    private string $hash;
    private UuidInterface $id;
    private Project $project;

    private function __construct(
        string $author,
        string $authorEmail,
        string $branch,
        \DateTimeImmutable $commitDate,
        string $hash,
        Project $project
    ) {
        $this->author = $author;
        $this->authorEmail = $authorEmail;
        $this->branch = $branch;
        $this->commitDate = $commitDate;
        $this->hash = $hash;
        $this->id = Uuid::uuid4();
        $this->project = $project;
    }

    public static function fromCheckout(Checkout $checkout): GitRevision
    {
        return new self(
            $checkout->getAuthor(),
            $checkout->getAuthorEmail(),
            $checkout->getBranch(),
            $checkout->getCommitDate(),
            $checkout->getHash(),
            $checkout->getProject()
        );
    }
}
