# Netflex Database abstraction layer

This package provides a database abstraction layer for Netflex.

Its used internally by the [Netflex Database driver for Laravel](https://github.com/netflex-sdk/database).
The only reason for this package to exist is to allow Netflex Databasedriver to be installable on both PHP 7.4 and PHP ^8.0.

This package provides a virtual PDO driver that can be used to connect to Netflex databases.

The reason for having two versions of the driver is that the internal interfaces of PDO and PDOStatement changed between PHP 7.4 and PHP 8.0.

Once we drop support for PHP 7.4, this package will be merged into the main Netflex database driver codebase.