# health-checker
Monitor your laravel server and application health and get notified immediately.

## Features
* [Dashboard](#dashboard)
* [APIs](#APIs)
* [Artisan command](#artisan-command)
* [Schedule](#schedule)
* [Notifications](#notifications)
* [Implemented Checkers](#checkers)
* [Custom Checkers](#custom-checkers)
 
# Install
```
$ composer require nagy/health-check
```
publish config files and resources
```
$ php artisan vendor:publish --provider='Nagy\HealthChecker\ServiceProvider'
```


## Dashboard
http://localhost/health-check/dashboard
<img width="1412" alt="screen shot 2018-09-22 at 15 52 53" src="https://user-images.githubusercontent.com/10484012/45917999-50790580-be80-11e8-9404-12d16d69db3b.png">

## APIs
get all checkers: `http://localhost/health-check/checkers`
response:
```
[
 'httpd-check',
 'app-debug'
]
```

get all check results `http://localhost/health-check`
response:
```
[
    [
      'checkerName' => 'httpd-check',
      'type' => 'success',
      'message' => 'Everything is ok with the process'
    ],
    ...
]
```
get specific checker result `http://localhost/health-check/checker-name`
response:
```
[
  'checkerName' => 'httpd-check',
  'type' => 'success',
  'message' => 'Everything is ok with the process'
]
```

## Artisan Command
<img width="721" alt="screen shot 2018-09-22 at 15 55 16" src="https://user-images.githubusercontent.com/10484012/45917998-4fe06f00-be80-11e8-8d5b-ac54857a9586.png">

## Schedule
Package will run peridcally in the background to check you application and server health.
the frequency is being set based on the [laravel frequency options](https://laravel.com/docs/5.6/scheduling#schedule-frequency-options)

## Notifications
First the package is enabled by checking `notifications => [ 'enabled' => true]` in the configuration file, then check if the result type is exists on `notifications => 'notify_on' `
The current suporrted notification channels is `MailChannel`, you can add your custom channel by creating a class with a *notify* method.
The *notify* method accepts a collection of results.
```
class CustomChannel
{
    public function notify(Collection $results)
    {
        //
    }
}
```

## Checkers
The package shipped with two global checkers
### ProcessCount
used to check the count of running process, for exampl, you need to check that at least a 10 workers are ruuning, then add a new elemet to the `checkers` in the configuration file
```
checkers => [
    'app-workers' => [
            'class' => '\Nagy\HealthChecker\Checkers\ProcessCount',
            'options' => ['processName' => 'app-workers', 'min' => 10, max => 20]
        ],
]
```
> **Note**
The package consider the checker key as the checker name, so it's highly recommend to name avoid the spaces in the checker name.

### Expression
Expression checker evalutes a Specfic expression, the evalution should be `true` to consider the it as healthy.


## Custom Checkers
in case you need to build your own checkers then all you need to do is creating a class that extends from `AbstractBaseChecker` and implements `HealthCheckInterface`.
then you have to implement methods `check`, `isHealthy` and `getMessage`

```
class CustomChecker extends AbstractBaseChecker implements HealthCheckInterface
{
    public function check(): Result
    {
        if ($this->isHealthy()) {
            return $this->makeHealthyResult();
        } else {
            return $this->makeUnHealthyResult();
            // return $this->makeUnHealthyResult(Result::WARNING_STATUS);
        }
    }

    public function isHealthy(): bool
    {
        return true;
    }

    public function getMessage(): string
    {
        // return your message to be attached in case of unhealthy result
    }
}
