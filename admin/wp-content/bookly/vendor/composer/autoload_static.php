<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit594bc36159fe664c633902b9c76debdc
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Twilio\\' => 7,
        ),
        'B' => 
        array (
            'Bookly\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Twilio\\' => 
        array (
            0 => __DIR__ . '/..' . '/twilio/sdk/src/Twilio',
        ),
        'Bookly\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit594bc36159fe664c633902b9c76debdc::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit594bc36159fe664c633902b9c76debdc::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit594bc36159fe664c633902b9c76debdc::$classMap;

        }, null, ClassLoader::class);
    }
}
