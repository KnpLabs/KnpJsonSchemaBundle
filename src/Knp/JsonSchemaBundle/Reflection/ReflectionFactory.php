<?php

namespace Knp\JsonSchemaBundle\Reflection;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;

class ReflectionFactory
{
    public function __construct(Finder $finder, Filesystem $filesystem)
    {
        $this->finder     = $finder;
        $this->filesystem = $filesystem;
    }

    public function create($className)
    {
        return new \ReflectionClass($className);
    }

    public function createFromDirectory($directory, $namespace)
    {
        if (false === $this->filesystem->exists($directory)) {
            return array();
        }

        $this->finder->files();
        $this->finder->name('*.php');
        $this->finder->in($directory);

        $refClasses = array();

        foreach ($this->finder->getIterator() as $name) {
            $baseName      = substr($name, strlen($directory)+1, -4);
            $baseClassName = str_replace('/', '\\', $baseName);
            $refClasses[]  = $this->create($namespace.'\\'.$baseClassName);
        }

        return $refClasses;
    }
}
