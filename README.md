SimpleLogger
====================

This simple PHP logger class.

Installation
============

Through composer:

    "require": {
        ...
        "graceas/php-simple-logger": "v1.1.6"
        ...
    }

Usage
=====

    $logger = new \SimpleLogger\SimpleLogger();
    $logger->addCritical('critical error');
    $logger->addInfo('info message');
