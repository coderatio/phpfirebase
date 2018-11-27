# PHP Firebase
A simple and clean CRUD PHP library for Google Firebase datastore.
This library, allows you to create, read, update and delete records stored on your Google Firebase database.

## Installation
To intall the library, kindly execute the command `composer require coderatio/phpfirebase:v1.0` Or `composer require coderatio/phpfirebase`.

## How to use
To start using, make sure you open vendor folder => coderatio => phpfirebase => src => secrete and update the contents of the key with your Google firebase service account key.

## Creating new records (C)
To create new record, do this...
```php
require 'vendor/autoload';
use Coderatio\PhpFirebase\PhpFirebase;

$pfb = new PhpFirebase();
$pfb->setTable('posts');
$pfb->insertRecord([
    'title' => 'Post one',
    'body' => 'Post one contents'
  ], $returnData);
  //The $returnData which is boolean returns inserted data if set to true. Default is false.
```

## Reading records (R)
To read created records, do this...
```php
// Getting all records
$pfb->getRecords();

// Getting a record. Note: This can only be done via the record id.
$pfb->getRecord(1); 
```

## Updating records (U)
To update a record, do this...
```php
// This takes the record ID and any column you want to update.
$pfb->updateRecord(1, [
  'title' => 'Post one edited'
]);

```

## Deleting records (D)
To delete created record, do this...
```php
 // This takes only the record ID. Deleting all records will be added in Beta-2
 
 $pfb->deleteRecord(1);
```

## Contribution
Kindly send fork the repo and send a pull request or find me on <a href="https://twitter.com/josiahoyahaya">Twitter</a>
