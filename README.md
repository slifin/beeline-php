## Beeline 🐝🐘

*Data orientated query builder*

## Documentation

For now I suggest reading this: https://github.com/jkk/honeysql

## Advantages

Beeline allows you to create dynamic ANSI compiliant SQL queries in the semantics of PHP's data structures

### Malleable 

This allows you to leverage your programming language to manipulate queries instead of relying on the API of your builder 

To show an example of this, consider a query where you would like to:

 Sort the columns of a select query:

```php
$query = [
  ':select' => [':a', ':c', ':b'] 
];

sort($query[':select']);
```

Remove a column:

```php
$query[':select'] = array_filter($query[':select'], fn(string $column) => $column !== ':c'); 
```

Merge columns:

```php
$query[':select'] = array_merge($query['select'], [':d']);
```

Recursively remove a column from a query and it's sub queries:

```php
// You get the point, you can use PHP to manipulate the data
```

Traditional query builders will let you down once you leave their implemented manipulation methods

### Reusable

When dealing with complex queries that can permutate in specific but hard to predict ways it's often useful to re-use parts of the query, many query builders often encourage you to put your business logic in hidden state objects:

```php
(new Select('tableA'))->condition('1 = 1');
```

Once the condition is on the select query it's often hard to reuse in the context of another query

but in beeline:

```php
$query = [
	':from' => ':tableA',
	':where' => [':=', 1, 1],
];
```

Take it out again and re-use it somewhere else, no data is ever lost to nested private objects

```php
$query[':where'];
```

Better yet store it in a place that makes sense in your application, context free:

```php
function one_equal_one() : array 
{
  return [':=', 1, 1];
}
```

Use it in a select query or an update query or manipulate it at run time then apply it, it's up to you!

### Powerful

Beeline handles many cases that other query builders do not:

- Zend DB: Parameterised expressions
- Doctrine: Unions, sub queries

### Testable
Assert against the shape of a query instead of strings, for example you can assert that a query has a particular condition by checking that the relevant data structure exists

### Debuggable

Has your query gone wrong? Have a look through the query's structure with xdebug, or print smaller parts of the query by passing it to beeline's function
