# Object Map

[![Latest Stable Version](http://poser.pugx.org/wmsamolet/object-map/v)](https://packagist.org/packages/wmsamolet/object-map)
[![Total Downloads](http://poser.pugx.org/wmsamolet/object-map/downloads)](https://packagist.org/packages/wmsamolet/object-map)
[![Latest Unstable Version](http://poser.pugx.org/wmsamolet/object-map/v/unstable)](https://packagist.org/packages/wmsamolet/object-map)
[![License](http://poser.pugx.org/wmsamolet/object-map/license)](https://packagist.org/packages/wmsamolet/object-map)
[![PHP Version Require](http://poser.pugx.org/wmsamolet/object-map/require/php)](https://packagist.org/packages/wmsamolet/object-map)
[![PHP Version Require](https://img.shields.io/badge/Coding%20Style-PSR--12-%23256d4e)](https://www.php-fig.org/psr/psr-12/)

PHP library for mapping, linking, configuring objects using data storage

## Description

#### This library is suitable for those who want:

- Create loosely coupled components
- Connect and configure handler classes dynamically

## Documentation

- [Testing](docs/testing.md)
- [Contributing](docs/contributing.md)
- [Changelog](docs/changelog.md)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require wmsamolet/object-map
```

or add

```
"wmsamolet/object-map": "^1.0"
```

to the requirement section of your `composer.json` file.

## Basic usage

```php
<?php

use Wmsamolet\ObjectMap\Domain\Repository\Memory\ObjectElementRepository;
use Wmsamolet\ObjectMap\Domain\Repository\Memory\ObjectLinkingRepository;
use Wmsamolet\ObjectMap\Domain\Service\ObjectMapService;

$objectMapService = new ObjectMapService(
    new ObjectElementRepository(),
    new ObjectLinkingRepository()
);

class TargetObject
{
}

class LinkedObject1
{
}

class LinkedObject2
{
}

// Add objects to map (adding information to the repository)
$objectMapService->addObjectToMap(TargetObject::class, 'Target object');
$objectMapService->addObjectToMap(LinkedObject1::class, 'Linked object #1');
$objectMapService->addObjectToMap(LinkedObject2::class, 'Linked object #2');

// Link objects to class TargetObject
$objectMapService->linkObjects(TargetObject::class, LinkedObject1::class);
$objectMapService->linkObjects(TargetObject::class, LinkedObject2::class);

// Get linked objects class name collection
$classNameCollection = $objectMapService->collectLinkedObjectsClassNames(
    TargetObject::class
);

// Get linked objects config collection ['class_name' => [...], ...]
$objectConfigCollection = $objectMapService->collectLinkedObjectsConfigs(
    TargetObject::class
);
```

## License

PHP Object Map is licensed under the MIT License - see the [LICENSE](LICENSE) file for details
