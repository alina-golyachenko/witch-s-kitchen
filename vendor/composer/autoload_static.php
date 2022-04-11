<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit921a1efd6e0a901b613e34b03d11d554
{
    public static $files = array (
        '8da1fb9565b7cada926e2d495f43fb11' => __DIR__ . '/../..' . '/Config/config.php',
    );

    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Models\\' => 7,
        ),
        'C' => 
        array (
            'Core\\DB\\' => 8,
            'Core\\Controller\\' => 16,
            'Core\\' => 5,
            'Controllers\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Models',
        ),
        'Core\\DB\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Core/DB',
        ),
        'Core\\Controller\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Core/Controller',
        ),
        'Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Core',
        ),
        'Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Controllers',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Controllers\\Contacts' => __DIR__ . '/../..' . '/Controllers/Contacts.php',
        'Controllers\\Main' => __DIR__ . '/../..' . '/Controllers/Main.php',
        'Controllers\\Recipes' => __DIR__ . '/../..' . '/Controllers/Recipes.php',
        'Controllers\\Users' => __DIR__ . '/../..' . '/Controllers/Users.php',
        'Core\\Controller' => __DIR__ . '/../..' . '/Core/Controller.php',
        'Core\\Core' => __DIR__ . '/../..' . '/Core/Core.php',
        'Core\\DB' => __DIR__ . '/../..' . '/Core/DB.php',
        'Core\\Template' => __DIR__ . '/../..' . '/Core/Template.php',
        'Core\\Utils' => __DIR__ . '/../..' . '/Core/Utils.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit921a1efd6e0a901b613e34b03d11d554::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit921a1efd6e0a901b613e34b03d11d554::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit921a1efd6e0a901b613e34b03d11d554::$classMap;

        }, null, ClassLoader::class);
    }
}
