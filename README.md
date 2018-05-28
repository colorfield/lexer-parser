# Lexer & Parser Drupal 8

Drupal 8 test site including a Lexer & Parser for mathematical expressions exposed as a field formatter.
The module relies on this [math-php](https://github.com/fubhy/math-php) library. 

## Getting started

The detailed instructions of the Drupal 8 available tools can be found the original [README](./README.md)
from the [Composer template for Drupal project](https://github.com/pfrenssen/drupal-project)
maintained by Pieter Frenssen.


### Install Drupal

Create a _build.properties.local_ file at the project root with
at least the following overrides  from _build.properties.dist_.

```
# Drupal configuration
# --------------------

# The project name.
project.name = lexer_parser_d8

# The site name.
website.site.name = Lexer and Parser

# Database settings.
drupal.db.name = lexer_parser_d8
drupal.db.user = root
drupal.db.password = root

# The base URL. This is used for doing functional tests in Behat and PHPUnit.
drupal.base_url = http://lexer_parser_d8.dvm
```

Then, at the project root, run

- `composer install` to get the Drupal core and vendors
- `./vendor/bin/phing install` to install the site.

### Install the Lexer & Parser module

- Install as usual `drush en lexer_parser`, there is no specific configuration.
- On a content type, create a _Text (plain)_ or _Text (plain, long)_ field.
- On 'Manage display', choose the 'Lexer and Parser' format.
- Optionally choose the 'Display' option ('Result' or 'Result and calculation steps').
- Create a node from the chosen content type and add a mathematical 
expression (e.g. '10 + 20 - 30 + 15 * 5') on the created field.
- On node view, the calculated expression should be visible (e.g. '75').

### Tests

@todo

In the web directory run

`SIMPLETEST_BASE_URL=http://lexer_parser_d8.dvm ../vendor/bin/phpunit -c core/ --testsuite functional --group lexer_parser`
