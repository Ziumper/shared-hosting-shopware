<?php

declare(strict_types=1);

namespace Ziumper\Shopware\Composer\MultiClassMap;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Override;
use function str_starts_with;
    
class MultiClassMapPlugin implements PluginInterface, EventSubscriberInterface {
    
   public function activate(Composer $composer, IOInterface $io) {}

    public static function getSubscribedEvents(): array
    {
        return [
            'post-autoload-dump' => 'splitClassmap',
        ];
    }

    public function splitClassmap(Event $event): void
    {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        $classmapFile = $vendorDir . '/composer/autoload_classmap.php';

        if (!file_exists($classmapFile)) {
            return;
        }

        $classmap = include $classmapFile;

        foreach ($classmap as $class => $path) {
            $prefix = explode('\\', $class, 2)[0] ?: 'global';
            $parts[$prefix][$class] = $path;
        }


        foreach ($parts as $name => $map) {
            file_put_contents(
                $vendorDir . "/composer/autoload_classmap_{$name}.php",
                "<?php\n\nreturn " . var_export($map, true) . ";\n"
            );
        }
        
        $autoloadStaticFile = $vendorDir . '/composer/autoload_static.php';
        if (file_exists($autoloadStaticFile)) {
                require_once $autoloadStaticFile;
                $declared = get_declared_classes();
                $staticInit = end($declared);

            if (class_exists($staticInit)) {
                $ref = new \ReflectionClass($staticInit);
                if ($ref->hasProperty('classMap')) {
                    $prop = $ref->getProperty('classMap');
                    $prop->setAccessible(true);
                    $staticMap = $prop->getValue();

                    $staticParts = [];
                    foreach ($staticMap as $class => $path) {
                        $prefix = explode('\\', $class, 2)[0] ?: 'global';
                        $staticParts[$prefix][$class] = $path;
                    }

                    foreach ($staticParts as $name => $map) {
                        file_put_contents(
                            $vendorDir . "/composer/autoload_static_classmap_" . strtolower($name) . ".php",
                            "<?php\n\nreturn " . var_export($map, true) . ";\n"
                        );
                    }
                }
        }
    }
    }

    #[Override]
    public function deactivate(Composer $composer, IOInterface $io): void {
        
    }

    #[Override]
    public function uninstall(Composer $composer, IOInterface $io): void {
        
    }
}