<?php
namespace Knp\JsonSchemaBundle\PhpSpec;

use PhpSpec\ServiceContainer;
use PhpSpec\Extension\ExtensionInterface;

class CompatibilityExtension implements ExtensionInterface
{
    public function load(ServiceContainer $container)
    {
        // This exists for PHP 5.3 compatibility
        if (!interface_exists('\JsonSerializable')) {
            class_alias('Knp\JsonSchemaBundle\Model\JsonSerializable', 'JsonSerializable');
        }
    }
}
