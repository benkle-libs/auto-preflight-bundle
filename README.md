AutoPreflightBundle
===================

A simple bundle to automatically generate responses for CORS preflight.

Install
------

Install with composer.
```
$ composer require benkle/auto-preflight-bundle
```

Add this to your kernel bundles:
```php
new Benkle\AutoPreflightBundle\BenkleAutoPreflightBundle(),
```

Configuration
-------------

Add this section to your _config.yaml_:
```yaml
benkle_auto_preflight:
    allow_origin: '*'
    allow_headers: x-auth-token
```
Both _allow_origin_ and _allow_headers_ are currently string values, and are send as is to the browser.

You also **must** use the field _methods_ in your route definitions, or only `GET` will be available.
