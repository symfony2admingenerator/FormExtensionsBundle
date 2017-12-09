FormExtensions [![knpbundles.com](http://knpbundles.com/symfony2admingenerator/FormExtensionsBundle/badge-short)](http://knpbundles.com/symfony2admingenerator/FormExtensionsBundle)
==============

[![Latest Stable Version](https://poser.pugx.org/symfony2admingenerator/form-extensions-bundle/v/stable.png)](https://packagist.org/packages/symfony2admingenerator/form-extensions-bundle)
[![Total Downloads](https://poser.pugx.org/symfony2admingenerator/form-extensions-bundle/downloads.png)](https://packagist.org/packages/symfony2admingenerator/form-extensions-bundle)

Symfony2 form extensions for Admingenerator project inspired by 
[genemu/GenemuFormBundle](https://github.com/genemu/GenemuFormBundle).

### Documentation

For a full list of form types and extensions (and related notes)
see [documentation](Resources/doc/documentation.md).

--------------

### Installation

Add this to your `composer.json`:

```json
"require": {
    "symfony2admingenerator/form-extensions-bundle": "^2.0"
}
```

For Symfony version lower than 2.7 or Twig lower than 1.12 add the following to your `composer.json`:
```json
"require": {
    "symfony2admingenerator/form-extensions-bundle": "v2.0-beta.21"
}
```

And then enable the bundle in your `AppKernel.php`:

```php
<?php
// AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Admingenerator\FormBundle\AdmingeneratorFormBundle(),
        new Admingenerator\FormExtensionsBundle\AdmingeneratorFormExtensionsBundle(),
        // AdmingeneratorGeneratorBundle is optional, however if you're useing it
        // make sure it is loaded AFTER AdmingeneratorFormExtensionsBundle
        new Admingenerator\GeneratorBundle\AdmingeneratorGeneratorBundle(),
    );
}
?>
```

To make `symfony2admingenerator/form-extensions-bundle` forms work, you need to edit your base 
template, and include static and dynamic stylesheets and javascripts. 

For Admingenerator users:

```html+django
{% extends 'AdmingeneratorGeneratorBundle::base_admin.html.twig' %}

{% block stylesheets %}
    {{ parent() }}

    {% include 'AdmingeneratorFormExtensionsBundle::stylesheets.html.twig' %}
    {% if form is defined and form is not empty %}
        {{ form_css(form) }}
    {% endif %}
{% endblock %}

{% block javascripts %}
    {{ parent() }}

    {% include 'AdmingeneratorFormExtensionsBundle::javascripts.html.twig' %}
    {% if form is defined and form is not empty %}
        {{ form_js(form) }}
    {% endif %}
{% endblock %}
```

For others:

```html+django
{% block stylesheets %}
    {% include 'AdmingeneratorFormExtensionsBundle::stylesheets.html.twig' %}
    
    {% if form is defined and form is not empty %}
        {{ form_css(form) }}
    {% endif %}
{% endblock %}

{% block javascripts %}
    {% include 'AdmingeneratorFormExtensionsBundle::javascripts.html.twig' %}
    
    {% if form is defined and form is not empty %}
        {{ form_js(form) }}
    {% endif %}
{% endblock %}
```

Note that the templates above are only usable if you've configured assetic for you project (with the correct filters enabled, `uglifyjs2` and `uglifycss`). This bundle also offers a view without filters and without assetic. Simple append `_assetic_basic` or `assetic_less` to the template name.

### Configure assetic packages (only if you use base.html.twig template)

Symfony <2.7:
```yaml
framework:
    templating:
        packages:
            formextensions_css:
                version: 1.0
                version_format: "%%1$s?v%%2$s"
            formextensions_js:
                version: 1.0
                version_format: "%%1$s?v%%2$s"
```

Symfony 2.7 or higher:
```yaml
framework:
    assets:
        packages:
            formextensions_css:
                version: 1.0
                version_format: "%%1$s?v%%2$s"
            formextensions_js:
                version: 1.0
                version_format: "%%1$s?v%%2$s"
```



### Translators needed!

We need your support to translate forms messages :) 
If you want to help open a pull request and submit a package for your language.

### License

For license information read carefully `LICENSE` file. 
