<?php

declare(strict_types=1);

namespace Ziumper\MultiClassMap;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Override;

class MultiClassMapPlugin implements PluginInterface, EventSubscriberInterface {
    
   #[Override]
   public function activate(Composer $composer, IOInterface $io) {}

    #[Override]
    public static function getSubscribedEvents(): array
    {
        return [
            'post-autoload-dump' => 'splitClassmap',
        ];
    }
    
    public function onPostAutloadDump(Event $event): void
    {
        $spliter = new AutoloadSpliter();
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        $spliter->splitMap($vendorDir);
    }

    #[Override]
    public function deactivate(Composer $composer, IOInterface $io): void {
        
    }

    #[Override]
    public function uninstall(Composer $composer, IOInterface $io): void {
        
    }
}