<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use BaksDev\Reference\Caps\Type\SizeCaps;
use BaksDev\Reference\Caps\Type\SizeCapsType;
use Symfony\Config\DoctrineConfig;

return static function (DoctrineConfig $doctrine) {
    $doctrine->dbal()->type(SizeCaps::TYPE)->class(SizeCapsType::class);
};
