<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0e2448304f26d52d30b7d34cd80efe37
{
    public static $files = array (
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        '72579e7bd17821bb1321b87411366eae' => __DIR__ . '/..' . '/illuminate/support/helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Component\\Translation\\' => 30,
        ),
        'P' => 
        array (
            'Psr\\SimpleCache\\' => 16,
            'Psr\\Log\\' => 8,
            'Psr\\Container\\' => 14,
            'Psr\\Cache\\' => 10,
            'PhpOffice\\PhpSpreadsheet\\' => 25,
        ),
        'N' => 
        array (
            'NoahBuscher\\Macaw\\' => 18,
        ),
        'I' => 
        array (
            'Illuminate\\Support\\' => 19,
            'Illuminate\\Database\\' => 20,
            'Illuminate\\Contracts\\' => 21,
            'Illuminate\\Container\\' => 21,
        ),
        'D' => 
        array (
            'Doctrine\\Common\\Inflector\\' => 26,
        ),
        'C' => 
        array (
            'Cache\\TagInterop\\' => 17,
            'Cache\\Hierarchy\\' => 16,
            'Cache\\Bridge\\SimpleCache\\' => 25,
            'Cache\\Adapter\\Redis\\' => 20,
            'Cache\\Adapter\\Common\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Component\\Translation\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/translation',
        ),
        'Psr\\SimpleCache\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/simple-cache/src',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'Psr\\Cache\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/cache/src',
        ),
        'PhpOffice\\PhpSpreadsheet\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpoffice/phpspreadsheet/src/PhpSpreadsheet',
        ),
        'NoahBuscher\\Macaw\\' => 
        array (
            0 => __DIR__ . '/..' . '/noahbuscher/macaw',
        ),
        'Illuminate\\Support\\' => 
        array (
            0 => __DIR__ . '/..' . '/illuminate/support',
        ),
        'Illuminate\\Database\\' => 
        array (
            0 => __DIR__ . '/..' . '/illuminate/database',
        ),
        'Illuminate\\Contracts\\' => 
        array (
            0 => __DIR__ . '/..' . '/illuminate/contracts',
        ),
        'Illuminate\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/illuminate/container',
        ),
        'Doctrine\\Common\\Inflector\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/inflector/lib/Doctrine/Common/Inflector',
        ),
        'Cache\\TagInterop\\' => 
        array (
            0 => __DIR__ . '/..' . '/cache/tag-interop',
        ),
        'Cache\\Hierarchy\\' => 
        array (
            0 => __DIR__ . '/..' . '/cache/hierarchical-cache',
        ),
        'Cache\\Bridge\\SimpleCache\\' => 
        array (
            0 => __DIR__ . '/..' . '/cache/simple-cache-bridge',
        ),
        'Cache\\Adapter\\Redis\\' => 
        array (
            0 => __DIR__ . '/..' . '/cache/redis-adapter',
        ),
        'Cache\\Adapter\\Common\\' => 
        array (
            0 => __DIR__ . '/..' . '/cache/adapter-common',
        ),
    );

    public static $fallbackDirsPsr4 = array (
        0 => __DIR__ . '/..' . '/nesbot/carbon/src',
    );

    public static $classMap = array (
        'BaseController' => __DIR__ . '/../..' . '/app/controllers/BaseController.php',
        'Company' => __DIR__ . '/../..' . '/app/models/Company.php',
        'HomeController' => __DIR__ . '/../..' . '/app/controllers/HomeController.php',
        'RedisConnect' => __DIR__ . '/../..' . '/app/models/RedisConnect.php',
        'RedisController' => __DIR__ . '/../..' . '/app/controllers/RedisController.php',
        'Warehouse' => __DIR__ . '/../..' . '/app/models/Warehouse.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0e2448304f26d52d30b7d34cd80efe37::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0e2448304f26d52d30b7d34cd80efe37::$prefixDirsPsr4;
            $loader->fallbackDirsPsr4 = ComposerStaticInit0e2448304f26d52d30b7d34cd80efe37::$fallbackDirsPsr4;
            $loader->classMap = ComposerStaticInit0e2448304f26d52d30b7d34cd80efe37::$classMap;

        }, null, ClassLoader::class);
    }
}
