# HadesArchitect Notification Bundle

[![Build Status](https://travis-ci.org/HadesArchitect/NotificationBundle.svg?branch=master)](https://travis-ci.org/HadesArchitect/NotificationBundle)
[![Latest Stable Version](https://poser.pugx.org/hadesarchitect/notification-bundle/v/stable.svg)](https://packagist.org/packages/hadesarchitect/notification-bundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/d3944cb9-a6d7-493f-b8c7-4b288e633d1a/mini.png)](https://insight.sensiolabs.com/projects/d3944cb9-a6d7-493f-b8c7-4b288e633d1a)

Event-driven notification bundle for Symfony 2 environment. Provides convenient way to manage user notifications in applications, for example to warn administrators about important events like user registration or notify users about any significant things for them like 'you order has been sent'. For that moment supports only swiftmailer as a notification channel, but easily could be extended. Visual part could be rendered through any supported template engine like twig.  

## Installation

Install through composer: 

*First step: require bundle*
```bash
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

## Usage

### Example

I'd like to receive notifications when anybody comments my posts, assuming I used [FOSCommentBundle](https://github.com/FriendsOfSymfony/FOSCommentBundle) for commentaries functionality. To do it, I should make two simple steps:

* Add a template for a notification
* Configure handler in app/config/config.yml

First of all, I need to write a template which would be rendered and send to me. I'll use a twig as a template engine. Every template will automatically take some arguments from handler, for that moment it's an event, event name and receiver information. Let me introduce you tiny twig template.

```twig
{# AcmeBundle:Notification:post_commented.html.twig #}
<h1>Post commented!</h1>
<p>Author: {{ event.comment.authorName }}</p>
<p>Time: {{ event.comment.createdAt|date('H:i:s d/m/Y') }}</p>
<p>Text: {{ event.comment.body }}</p>
```

After that, I should configure event handler.

```yaml
ha_notification:
    swiftmailer_channel:
        sender: no-reply@my-project.com
    handlers: 
        post_commented:
            event:         fos_comment.comment.post_persist
            subject:       Post commented! 
            receiver:      administrator@my-project.com
            template:      AcmeBundle:Notification:post_commented.html.twig
```

That's all! Don't forget to ensure swiftmailer configuration because mail sending could be not configured or disabled in development environment. 

### Configuration

After initial setup you should configure the bundle in appropriate way. Normally it could be done by some changes in app/config/config.yml or if you would like to keep user notifications in separate file you should create new file, f.e. app/config/notifications.yml and include it in the config.yml (imports: [{resource: notifications.yml}]). 

####Typical configuration
*Typical way is to specify some data for handlers: expected event, receiver's data, subject and template*
```yaml
ha_notification:
    swiftmailer_channel:
        sender: no-reply@my-project.com # We need to specify sender name for swiftmailer
    handlers: # Array of handlers, you could configure as much handlers as you want to. 
        user_registered: # handler name, should be unique
            event:    fos_user.registration.completed # Expected event
            receiver: administrator@mail.com          # Admin email, could be an array of emails
            subject:  New user registered!            # Subject, optional
            template: Acme:Notifications:user_registered.html.twig # Template, optional (but recommended to create custom templates)
```

####Minimal handler configuration
*But you could omit some part of configuration*
```yaml
ha_notification:
    swiftmailer_channel:
        sender: no-reply@my-project.com
    handlers: 
        user_registered:
            event:    fos_user.registration.completed
            receiver: administrator@mail.com
```

####Full configuration
```yaml
ha_notification:
    default_channel: @ha_notification.channel.swiftmailer # Specify default notification channel, swiftmailer by default
    swiftmailer_channel:
        sender: no-reply@my-project.com
    handlers: 
        user_registered:
            event:         fos_user.registration.completed
            subject:       New user registered! 
            receiver:      administrator@mail.com
            template:      Acme:Notifications:user_registered.html.twig
            handler_class: %ha_notification.handler.default_class% # Overrides handler class
            templating:    @templating #Templating engine service # Overrides templating engine for the handler
            channel:       @ha_notification.channel # Overrides notification channel for the handler
```

### Parameters

Parameters which you could override:

* ha_notification.default_subject - *Subject for notifications*
* ha_notification.view.default_template - *Template for letter body*
* ha_notification.handler.default_class - *Handler class*
* ha_notification.channel.swiftmailer_class - *Default class for swiftmailer notification channel*

## Todo

* Describe ways to extend bundle
* Add more tests
* Add possibility to throw notifications directly, not only through event handlers  
* Add possibility to bypass any services and parameters to templates, instead of using twig globals
