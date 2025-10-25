<?php

declare(strict_types=1);

namespace Ziumper\MultiClassMap;

class AutoloadSpliter {
    
    private string $classmapFile;
    private string $staticFile;
    
    public function __construct(private string $vendorDir) {
        $this->classmapFile = $vendorDir . '/composer/autoload_classmap.php';
        $this->staticFile = $vendorDir . '/composer/autoload_static.php';
    }
    
    public function getClassMapParts(): array 
    {
        if (!file_exists($this->classmapFile)) {
            return [];
        }

        $classmap = include $this->classmapFile;

        $parts = [];
        
        foreach ($classmap as $class => $path) {
            $prefix = explode('\\', $class, 2)[0] ?: 'global';
            $parts[$prefix][$class] = $path;
        }
        
        
        return $parts;
    }
    
    public function getStaticParts(): array 
    {
        return [];
    }
    
    public function split(): void
    {
        $parts = $this->getClassMapParts();
        
        foreach ($parts as $name => $map) {
            file_put_contents(
                $this->vendorDir . "/composer/autoload_classmap_{$name}.php",
                "<?php\n\nreturn " . var_export($map, true) . ";\n"
            );
        }
        
        $autoloadStaticFile = $this->vendorDir . '/composer/autoload_static.php';
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
}
