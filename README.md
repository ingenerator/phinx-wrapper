# inGenerator Phinx Wrapper

This is a very thin wrapper around the excellent robmorgan/phinx, which we use to configure it
the way we want it across all projects and provide a few bits and bobs of useful database 
schema / migration related helpers.

Usage:

* add https://php-packages.ingenerator.com to your composer repositories
* require ingenerator/phinx-wrapper


* create a phinx.php in your project root directory:
```php
<?php

use Ingenerator\PhinxWrapper\DefaultPhinxConfig;

return DefaultPhinxConfig::fromMyDotCnf()
    ->getConfig(['database_name' => 'my_database_schema']);
```

* create a db_schema/migrations directory under your project root directory

And then run phinx as required.

The method above returns a phinx config array in default form - if you want to override any
of our defaults, just customise the array before you return it.

For example, to use a project-specific migration base class:

```php
<?php

use Ingenerator\PhinxWrapper\DefaultPhinxConfig;

$config = DefaultPhinxConfig::fromMyDotCnf()
    ->getConfig(['database_name' => 'my_database_schema']);

$config['migration_base_class'] = 'My\Project\BaseMigration';

return $config;
```

# Contributing

Contributions are welcome, but this is primarily intended to be an opinionated internal-focused
library that thinks the way we do. Before starting work on any contribution, please get in 
touch. You are of course very welcome to fork and add customisations of your own.

# Licence

Licensed under the BSD-3-Clause Licence
