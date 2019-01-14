<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Core\Controller\Cli\Cache;

use CrazyCat\Framework\App\Cache\Factory as CacheFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @category CrazyCat
 * @package CrazyCat\Developer
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Clear extends \CrazyCat\Framework\App\Module\Controller\Cli\AbstractAction {

    const INPUT_KEY_CACHE_NAME = 'cache_name';

    /**
     * @param \Symfony\Component\Console\Command\Command $command
     */
    protected function configure( Command $command )
    {
        $command->setDefinition( [
            new InputArgument( self::INPUT_KEY_CACHE_NAME, InputArgument::REQUIRED, 'Type of cache to clear' )
        ] );
        $command->setDescription( 'Clear cache of specified type' );
        $command->setHelp( 'Types: modules, events' );
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    protected function run( InputInterface $input, OutputInterface $output )
    {
        if ( ( $cacheName = $input->getArgument( self::INPUT_KEY_CACHE_NAME ) ) ) {
            $this->objectManager->get( CacheFactory::class )->create( $cacheName )->clear();
            $output->writeln( sprintf( 'Cache `%s` cleared.', $cacheName ) );
        }
    }

}