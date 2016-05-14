# Version 2.1.0

## Bugfixes

* None

## Features

* Add new GenericThreaded class as replacement for GenericStackable class
* Add new ThreadedStorage class as replacement for StackableStorage class
* GenericStackable class now extends \Threaded instead of deprecated \Stackable
* Remove PHP 5.5 + 5.4 compatiblity

# Version 2.0.0

## Bugfixes

* None

## Features

* Remove internal identifier from StackableStorage
* Move addServer() and getServers() methods to new MemcachedStorageInterface

# Version 1.0.0

## Bugfixes

* None

## Features

* Switched to stable dependencies due to version 1.0.0 release

# Version 0.5.13

## Bugfixes

* None

## Features

* Applied new file name and comment convention

# Version 0.5.12

## Bugfixes

* None

## Features

* Remove unnecessary lock/unlock calls when stack values

# Version 0.5.11

## Bugfixes

* None

## Features

* Add test for GenericStackable class

# Version 0.5.10

## Bugfixes

* Refactoring AbstractStorage/StackableStorage to avoid PHPCPD errors

## Features

* None

# Version 0.5.9

## Bugfixes

* None

## Features

* Refactoring ANT PHPUnit execution process
* Composer integration by optimizing folder structure (move bootstrap.php + phpunit.xml.dist => phpunit.xml)
* Switch to new appserver-io/build build- and deployment environment