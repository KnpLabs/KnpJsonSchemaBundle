<?php

namespace Knp\JsonSchemaBundle\Schema;

class SchemaRegistry
{
    protected $registry = [];

    public function register($alias, $namespace)
    {
        if ($this->has($alias)) {
            throw new \Exception(sprintf(
                'Alias "%s" is already used for schema "%s".', $alias, $this->registry[$alias]
            ));
        }
        $this->registry[$alias] = $namespace;
    }

    public function all()
    {
        return $this->registry;
    }

    public function get($alias)
    {
        if (!$this->has($alias)) {
            throw new \Exception(sprintf(
                'Alias "%s" is not registered.', $alias
            ));
        }

        return $this->registry[$alias];
    }

    private function has($alias)
    {
        return array_key_exists($alias, $this->registry);
    }
}
