# Makeup

[![Build Status](https://img.shields.io/travis/gintonicweb/Makeup/master.svg?style=flat-square)](https://travis-ci.org/gintonicweb/Makeup)
[![Coverage](https://img.shields.io/codecov/c/github/gintonicweb/Makeup.svg?style=flat-square)](https://codecov.io/github/gintonicweb/Makeup)
[![Total Downloads](https://img.shields.io/packagist/dt/gintonicweb/makeup.svg?style=flat-square)](https://packagist.org/packages/gintonicweb/makeup)
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE)

Makeup allows to change the way CakePHP resolves view paths with the help of a
configuration array. The goal of this plugin is to improve the reusability of
themes and reduce the folder-nesting madness of large applications.

- Easily map prefixes to themes
- Override themes from the application
- Reuse a theme across prefixes with different overrides
- Choose your own folder structure
- Fallback on traditional cakephp paths

## Install

Using [Composer][composer]:

```
composer require Gintonic/makeup:dev-master
```

You then need to load the plugin. You can use the shell command:

```
bin/cake plugin load Gintonic/Makeup
```

or by manually adding statement shown below to your app's `config/bootstrap.php`:

```php
Plugin::load('Gintonic/Makeup');
```

## Usage

Add the MakeupViewTrait to your AppView, and use the `$themes` variable to map
variables.

```
class AppView extends CrudView
{
    use \Gintonic\Makeup\View\MakeupViewTrait;

    protected $themes = [
        'Default' => [
            'MyDefaultFolder' => 'DefaultTheme'
        ],
        'Admin' => [
            'MyAdminFolder' => 'AdminTheme'
        ],
    ];
}
```
In the case above :
- `Default` This is a constant defined by Makeup, representing all non-prefixed pages
- `Admin` Represents the Admin prefix
- `MyDefaultFolder` and `MyAdminFolder` are folders found under `src/Template/` where
you can override themes
- `DefaultTheme` and `AdminTheme` are the names of 2 themes.


## Patches & Features

* Fork
* Mod, fix
* Test - this is important, so it's not unintentionally broken
* Commit - do not mess with license, todo, version, etc. (if you do change any, bump them into commits of
their own that I can ignore when I pull)
* Pull request - bonus point for topic branches

To ensure your PRs are considered for upstream, you MUST follow the [CakePHP coding standards][standards].

## Bugs & Feedback

http://github.com/gintonicweb/makeup/issues

## License

Copyright (c) 2015, [Gintonic][gintonic] and licensed under [The MIT License][mit].

[cakephp]:http://cakephp.org
[composer]:http://getcomposer.org
[mit]:http://www.opensource.org/licenses/mit-license.php
[gintonic]:http://gintoniccms.com
[standards]:http://book.cakephp.org/3.0/en/contributing/cakephp-coding-conventions.html
