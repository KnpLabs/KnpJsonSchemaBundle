<?php

namespace Knp\JsonSchemaBundle\Model;

/**
 * When used with PHP 5.3 this bundle will alias \JsonSerializable to this class
 */
interface JsonSerializable {

    public function jsonSerialize();

}