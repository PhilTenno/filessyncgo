<?php
// src/FileSyncGoBundle.php

declare(strict_types=1);

namespace PhilTenno\FileSyncGo;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class FileSyncGoBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
