<?php

declare(strict_types=1);

namespace PhpInvest\Service\Git;

use PhpInvest\Entity\Project;
use PhpInvest\Invest\Git\Checkout;
use PhpInvest\Process\Git\LogProcess;
use PhpInvest\Process\Git\RevParseProcess;

final class CheckoutFactory
{
    public static function create(string $directory, Project $project): Checkout
    {
        $branch = (string) RevParseProcess::init($directory)->run();
        $log = LogProcess::init($directory)->run();

        return new Checkout(
            $log->get(LogProcess::VALUE_AUTHOR),
            $log->get(LogProcess::VALUE_AUTHOR_EMAIL),
            $branch,
            $log->getDate(),
            $directory,
            $log->get(LogProcess::VALUE_HASH),
            $project
        );
    }
}
