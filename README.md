# HadesArchitect Notification Bundle

[![Build Status](https://travis-ci.org/HadesArchitect/NotificationBundle.svg?branch=master)](https://travis-ci.org/HadesArchitect/NotificationBundle)
[![Latest Stable Version](https://poser.pugx.org/hadesarchitect/notification-bundle/v/stable.png)](https://packagist.org/packages/hadesarchitect/notification-bundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/d3944cb9-a6d7-493f-b8c7-4b288e633d1a/mini.png)](https://insight.sensiolabs.com/projects/d3944cb9-a6d7-493f-b8c7-4b288e633d1a)

Event-driven notification bundle for Symfony 2 environment. Provides convenient way to manage user notifications in applications, for example to warn administrators about important events like user registration or notify users about any significant things for them like 'you order has been sent'. For that moment supports only swiftmailer as a notification channel, but easily could be extended. Visual part could be rendered through any supported template engine like twig.  

## Installation

Install through composer: 

*First step: require bundle*
```
composer require hadesarchitect/notification-bundle ~1
```

*Second step: enable bundle*
```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new HadesArchitect\NotificationBundle\HadesArchitectNotificationBundle(),
    );
}
```

## Configuration



### Parameters

Parameters which you could override:

* json_schema.validator.class - *real validator class*
* json_schema.validator.service.class - *validator service class*
* json_schema.uri_resolver.class - *real resolver class*
* json_schema.uri_resolver.service.class - *resolver service class*
* json_schema.uri_retriever.class - *real retriever class*
* json_schema.uri_retriever.service.class - *retriever service class*
