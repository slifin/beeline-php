## Beeline 🐝🐘

*Data orientated query builder*



## Getting started

Pull the query builder into your project using composer:

```bash
composer require slifin/beeline-php
```



Create your first query:

```php
<?php 
require_once __DIR__ . '/vendor/autoload.php';

\slifin\beeline\format([
    'select' => [1]
]); // ['SELECT ?', 1];
```



## Usage documentation

For now I suggest reading the corresponding documentation from honeySQL: https://github.com/jkk/honeysql



