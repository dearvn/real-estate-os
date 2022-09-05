# WordPress Plugin Real Estate OS 
* A standardized, organized, object-oriented foundation for building high-quality WordPress Plugins
* A project to learn Wordpress Hooks, Actions and Filters

#Wordpress Coding Standards - PHPCS
## Check and Fix issue Wordpress standard if you want to deploy on wordpress.org

** Install package to check Wordpress standard:**

```sh
composer install
```

**Get all errors of the project:**

````sh
vendor/bin/phpcs --standard=WordPress .
```

**Fix all errors of the project:**

```sh
vendor/bin/phpcbf --standard=WordPress .
````

or fix manually

## Contents
Learn hooks:
* `hook taxonomy`. Created new taxonomy and add to post refs `class-toxonomy.php`
* `hook category`. Created custom field and show on list refs `class-category.php`
* `hook posttype`. Created new posttype refs `class-post.php`
* `hook meta_box_cb`. Created multi dropdown as child parent and use ajax change list of childs refs `scripts.js` and `class-real-estate-ajax.php`

## Study Cases
* 1. I want to add custom field to category and show on list in admin
* 2. I want to add new post type
* 3. I want to add custom taxonomy and add custom field to this one
* 4. I want to add meta box when add/edit custom post type
* 5. I want to add new filter in list post type
* 6. I want to create command to execute on terminal
* and more ...

Other I created wp cmd to import sample data to testing
* `wp wds run_migrate`

## Features
* Create new real estate post by location, price, category, type...

## TODO
* Create filter on list of real estate by location, price, category on admin
* Create tag by conjunction between location, category
* Can add multi images
* Create new template detail of real estate type
* Auto post to fanpage, zalo
* Auto post to batdongsan website
* Peformance images

## Installation

Run command to import sample data
* `wp wds run_migrate`


## License

The WordPress Plugin Real Estate OS is licensed under the GPL v2 or later.

> This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation.

> This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

> You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA

A copy of the license is included in the root of the plugin’s directory. The file is named `LICENSE`.

## Important Notes

### Licensing

The WordPress Plugin Real Estate OS is licensed under the GPL v2 or later; however, if you opt to use third-party code that is not compatible with v2, then you may need to switch to using code that is GPL v3 compatible.

For reference, [here's a discussion](http://make.wordpress.org/themes/2013/03/04/licensing-note-apache-and-gpl/) that covers the Apache 2.0 License used by [Bootstrap](http://twitter.github.io/bootstrap/).

### Includes

Note that if you include your own classes, or third-party libraries, there are three locations in which said files may go:

* `includes` is where functionality where you can put all your admin code, custom classes.
* `assets` is where you can add your site assets i.e images, js, css.
* `temlates` is for all view templates.


## Supports for custom development.

If you’re interested in custom plugin development or website customization please contact us. donald.nguyen.it@gmail.com
