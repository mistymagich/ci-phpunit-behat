MY CodeIgniter Set
==================

CodeIgniterとよく使うツールをまとめたもの

Content
-------

* CodeIgniter 2.1.3 <http://ellislab.com/codeigniter>
* CodeIgniter Sparks <http://getsparks.org>
* CodeIgniter Rest Server <https://github.com/philsturgeon/codeigniter-restserver>
* CodeIgniter SPL Autoloader <https://github.com/bubbafoley/codeigniter-spl-autoloader>
* PHPUnit <http://phpunit.de/manual/current/en/index.html>
* Behat <http://behat.org>
* Phing <http://www.phing.info>

Initial Setting
---------------

    composer/composer.phar self-update
    composer/composer.phar install -d composer

PHPUnit
-------

* Use phing

    ./composer/bin/phing phpunit

* Use phpunit

    cd tests
    ../composer/bin/phpunit
    ../composer/bin/phpunit models/UserTest


Behat
-----

* Use phing

    ./composer/bin/phing behat
    

* Use behat

    ./composer/bin/behat
    ./composer/bin/behat --tags users
    

CodeIgniter Sparks
------------------

### Install Package ###

    ./tools/spark install -v1.0.0 example-spark


