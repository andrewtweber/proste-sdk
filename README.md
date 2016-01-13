# proste-sdk

Easy SDK for any RESTful API

## Extending

Proste is an abstract class. In most cases you simply need to extend it, give it a name, and specify the base URL

```php
class GitHub extends SDK
{
    protected $name = 'GitHub';
 
    protected $base_url = 'https://api.github.com/';
}
```

## Usage

All requests will throw an Exception if the HTTP status code returned is not 2**

The responses returned are expected to be JSON and are decoded into an array.

```php
$github = new Proste\GitHub();

try {
    $releases = $github->get('repos/andrewtweber/proste-sdk/releases');

    dd($releases);

    $github->post('repos/andrewtweber/proste-sdk/issues', [
        'title' => 'New Issue',
        'body' => 'Your project is terrible',
    ]);
} catch (\Exception $e) {
}
```

## Todo

* Add example classes to the repository
* Make options available on all requests
* Authenticated requests
