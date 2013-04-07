TreeLayoutStack, v1.0
=======

[![Build Status](https://travis-ci.org/neilime/zf2-tree-layout-stack.png?branch=master)](https://travis-ci.org/neilime/zf2-tree-layout-stack)

Created by Neilime

Introduction
------------

TreeLayoutStack is module for ZF2 allowing the creation of tree layout 

P.S. If you want to contribute don't hesitate, I'll review any PR.

Requirements
------------

* [Zend Framework 2](https://github.com/zendframework/zf2) (latest master)

Installation
------------

### Main Setup

#### By cloning project

1. Clone this project into your `./vendor/` directory.

#### With composer

1. Add this project in your composer.json:

    ```json
    "require": {
        "neilime/zf2-tree-layout-stack": "dev-master"
    }
    ```
2. Now tell composer to download TreeLayoutStack by running the command:

    ```bash
    $ php composer.phar update
    ```

#### Post installation

1. Enabling it in your `application.config.php`file.

    ```php
    <?php
    return array(
        'modules' => array(
            // ...
            'TreeLayoutStack',
        ),
        // ...
    );
    ```
    
# How to use _TreeLayoutStack_