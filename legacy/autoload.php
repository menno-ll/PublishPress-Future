<?php

use PublishPressFuture\Core\Container;
use PublishPressFuture\Core\ServicesAbstract;

/**
 * Autoloads the classes.
 */
function postexpirator_autoload($class)
{
    $namespaces = array('PostExpirator');
    foreach ($namespaces as $namespace) {
        if (substr($class, 0, strlen($namespace)) === $namespace) {
            $class = str_replace('_', '', strstr($class, '_'));

            $container = Container::getInstance();
            $legacyPath = $container->get(ServicesAbstract::SERVICE_LEGACY_PATH);

            $filename = $legacyPath . '/classes/' . sprintf('%s.class.php', $class);
            if (is_readable($filename)) {
                require_once $filename;

                return true;
            }
        }
    }

    return false;
}

spl_autoload_register('postexpirator_autoload');
