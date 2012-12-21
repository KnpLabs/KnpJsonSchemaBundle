Disclaimer
==========

**This bundle is in development stage!!! Do not use it in production.**

Current buid status of master : [![Build Status](https://secure.travis-ci.org/KnpLabs/KnpJsonSchemaBundle.png)](https://travis-ci.org/KnpLabs/KnpJsonSchemaBundle)

The generated json schema is based on [IETF Specification](http://tools.ietf.org/html/draft-zyp-json-schema-03) which expired on May 26, 2011.
Despite my search, I couldn't find any more up-to-date spec, so if you know one, please let me know.

The JsonSchema Bundle
=====================

The purpose of this bundle is to provide a service which allow you to generate json schema based on validation metadata.

If the question is about the purpose of Json schema, well, I can only advise you to take a look at the official website: http://json-schema.org/

Installation
------------
Add the following to your composer.json:
``` json
{
    "mininmum-stability": "dev",
    "require": {
        "knplabs/json-schema-bundle": "dev-master"
    }
}
```

and run `composer.phar update knplabs/json-schema-bundle`

Configuration
-------------
Register the compiler pass in your bundle like so :

```php
//src/MyBundle/MyBundle.php

public function build(ContainerBuilder $container)
{
    $container->addCompilerPass(new Knp\JsonSchemaBundle\DependencyInjection\Compiler\RegisterJsonSchemaCompilerPass($this));
}
```

You must also import some routing inforamtions:
```yaml
#app/config/routing.yml

json_schema:
    resource: "@KnpJsonSchemaBundle/Resources/config/routing.yml"

```

Then in your model/entity for which you want to provide a json schema:

```php
<?php

namespace App\Entity;

use Knp\JsonSchemaBundle\Annotations as Json;

/**
 * @Json/Schema("huitre")
 */
class Huitre
{

}
```

Usage
-----
You may use the `json_schema.response.factory` to automatically link the generated schema to an object.
```php
class DefaultController extends Controller
{
    public function indexAction()
    {
        $user = new User();
        $user->age = 10;

        return $this->get('json_schema.response.factory')->create($user);
    }
}
```

Will generate the following response:


You can also access the json schema through `/schemas/{name}.json`



Internals
---------
It uses the Validator and Doctrine FormTypeGuesser to guess values of 'required', 'type', 'pattern', 'minLength' and 'maxLength'.

For property that couldn't be guessed with these guessers, another handler take over from it.

You can see all constraints that are handled in the `ExtraValidatorConstraintsHandler` class.

You can also hardly specified the json schema constraints you want by using the annotations provided with this bundle.


Examples
--------
### Entity
```php
<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 **/
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $name;

    /**
     * @Assert\Type(type="string")
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    protected $email;

    /**
     * @Assert\Regex(pattern="/^[0-9]{5}$/")
     */
    protected $zipCode;

    /**
     * @Assert\Length(min="2", max="50")
     */
    protected $address;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(min="21")
     */
    protected $age;

    /**
     * @Assert\Blank()
     */
    protected $file;

    /**
     * @Assert\Choice(choices={"toto","tutu","tata"})
     */
    protected $type;

    /**
     * @ORM\Column(type="decimal", nullable=true)
     */
    protected $balance;

    /**
     * @Assert\Type(type="string")
     * @Assert\Type(type="number")
     */
    protected $height;
}
```

### Result
```json
{
    "title": "user",
    "properties": {
        "id": {
            "required": true,
            "type": "integer"
        },
        "name": {
            "required": true,
            "type": "string"
        },
        "email": {
            "required": true,
            "type": "string"
        },
        "zipCode": {
            "required": false,
            "type": "string",
            "pattern": "[0-9]{5}"
        },
        "address": {
            "required": false,
            "type": "string",
            "minLength": "2",
            "maxLength": "50"
        },
        "age": {
            "required": true,
            "type": "integer",
            "minimum": "21"
        },
        "file": {
            "required": false,
            "type": "string"
        },
        "type": {
            "required": false,
            "type": "string",
            "enum": [
                "toto",
                "tutu",
                "tata"
            ]
        },
        "balance": {
            "required": false,
            "type": "number"
        },
        "height": {
            "required": false,
            "type": [
                "string",
                "number"
            ]
        }
    }
}
```

Contributors
------------
 - Gildas Quéméner [gquemener](https://github.com/gquemener)
 - Florian Klein [docteurklein](https://github.com/docteurklein)
