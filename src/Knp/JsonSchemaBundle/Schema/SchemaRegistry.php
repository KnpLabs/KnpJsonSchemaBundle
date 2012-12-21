<?php

namespace Knp\JsonSchemaBundle\Schema;

class SchemaRegistry
{
    protected $registry = [];

    public function register($alias, $namespace)
    {
        if ($this->hasAlias($alias)) {
            throw new \Exception(sprintf(
                'Alias "%s" is already used for namespace "%s".',
                $alias,
                $this->registry[$alias]
            ));
        }

        if ($this->hasNamespace($namespace)) {
            throw new \Exception(sprintf(
                'Namespace "%s" is already registered with alias "%s".',
                $namespace,
                $this->getAlias($namespace)
            ));
        }

        $this->registry[$alias] = $namespace;
    }

    public function all()
    {
        return $this->registry;
    }

    public function getNamespace($alias)
    {
        if (!$this->hasAlias($alias)) {
            throw new \Exception(sprintf(
                'Alias "%s" is not registered.', $alias
            ));
        }

        return $this->registry[$alias];
    }

    public function getAlias($namespace)
    {
        if (!$this->hasNamespace($namespace)) {
            throw new \Exception(sprintf(
                'Namespace "%s" is not registered.', $namespace
            ));
        }

        return array_flip($this->registry)[$namespace];
    }

    private function hasAlias($alias)
    {
        return array_key_exists($alias, $this->registry);
    }

    private function hasNamespace($namespace)
    {
        return array_key_exists($namespace, array_flip($this->registry));
    }
}
