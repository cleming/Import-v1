<?php

namespace ImportV1;

use ImportV1\Console\Command;
use Symfony\Component\Console\Application as CoreApplication;

class Application extends CoreApplication
{
    public function __construct()
    {
        parent::__construct("Scripts d'import des données de Robert v1 vers Robert2.");

        $this->addCommands([
            new Command\ImportCommand(),
        ]);
    }
}
