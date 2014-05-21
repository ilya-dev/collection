# Collection

[![Build Status](https://travis-ci.org/ilya-dev/collection.svg?branch=master)](https://travis-ci.org/ilya-dev/collection)

Painless PHP collections.

## Installation

Open up your terminal, `cd` to your project directory and run:

```shell
composer require "ilya/collection:~1"
```

## Usage

```php
$collection = new Collection\Collection([1, 2, 3]);

$collection->all(); // => [1, 2, 3]
$collection->sum(); // => 6
$collection->toJson(); // => "[1,2,3]"
```

## Documentation

The source code is fully documented, so you can use something like `ApiGen`
to build pretty HTML documentation.

## Additional information

Collection is licensed under the MIT license.

## Development

Various development-related notes that I write for my own.

### Roadmap

#### Interfaces

+ `JsonSerializable` [done]
+ `Countable` [done]
+ `ArrayAccess` [done]
+ `IteratorAggregate` [done]

#### Methods

+ `all` [done]
+ `collapse` [done]
+ `difference` [done]
+ `each` [done]
+ `fetch` [done]
+ `filter` [done]
+ `first` [done]
+ `last` [done]
+ `flatten` [done]
+ `remove` [done]
+ `get` [done]
+ `groupBy` [done]
+ `has` [done]
+ `implode` [done]
+ `intersection` [done]
+ `isEmpty` [done]
+ `pluck` [done]
+ `map` [done]
+ `merge` [done]
+ `pop` [done]
+ `push` [done]
+ `prepend` [done]
+ `put` [done]
+ `reduce` [done]
+ `random` [done]
+ `reverse` [done]
+ `shift` [done]
+ `slice` [done]
+ `chunk` [done]
+ `sort` [done]
+ `sortBy` [done]
+ `splice` [done]
+ `sortByDesc` [done]
+ `sum` [done]
+ `take` [done]
+ `transform` [done]
+ `unique` [done]
+ `values` [done]

