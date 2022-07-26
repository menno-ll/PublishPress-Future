<?php

namespace PublishPressFuture\Module\Debug;

use PublishPressFuture\Core\HookableInterface;
use PublishPressFuture\Core\InitializableInterface;
use PublishPressFuture\Module\Settings\ActionHooksAbstract as SettingsHooksAbstract;

class Controller implements InitializableInterface
{
    /**
     * @var HookableInterface
     */
    private $hooks;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param HookableInterface $hooks
     * @param LoggerInterface $logger
     */
    public function __construct(HookableInterface $hooks, LoggerInterface $logger)
    {
        $this->hooks = $hooks;
        $this->logger = $logger;
    }

    public function initialize()
    {
        $this->hooks->addAction(ActionHooksAbstract::LOG, [$this, 'loggerLog'], 10, 3);
        $this->hooks->addAction(ActionHooksAbstract::LOG_EMERGENCY, [$this, 'loggerEmergency'], 10, 2);
        $this->hooks->addAction(ActionHooksAbstract::LOG_ALERT, [$this, 'loggerAlert'], 10, 2);
        $this->hooks->addAction(ActionHooksAbstract::LOG_CRITICAL, [$this, 'loggerCritical'], 10, 2);
        $this->hooks->addAction(ActionHooksAbstract::LOG_ERROR, [$this, 'loggerError'], 10, 2);
        $this->hooks->addAction(ActionHooksAbstract::LOG_WARNING, [$this, 'loggerWarning'], 10, 2);
        $this->hooks->addAction(ActionHooksAbstract::LOG_NOTICE, [$this, 'loggerNotice'], 10, 2);
        $this->hooks->addAction(ActionHooksAbstract::LOG_INFO, [$this, 'loggerInfo'], 10, 2);
        $this->hooks->addAction(ActionHooksAbstract::LOG_DEBUG, [$this, 'loggerDebug'], 10, 2);
        $this->hooks->addAction(ActionHooksAbstract::DELETE_LOGS, [$this, 'loggerDeleteLogs']);
        $this->hooks->addAction(ActionHooksAbstract::DROP_DATABASE_TABLE, [$this, 'loggerDropDatabaseTable']);

        $this->hooks->addAction(SettingsHooksAbstract::DELETE_ALL_SETTINGS, [$this, 'onDeleteAllSettings']);

        $this->hooks->addFilter(ActionHooksAbstract::FETCH_ALL_LOGS, [$this, 'loggerFetchAll']);
    }

    public function loggerLog($level, $message, $context = [])
    {
        $this->logger->log($level, $message, $context);
    }

    public function loggerEmergency($message, $context = [])
    {
        $this->logger->emergency($message, $context);
    }

    public function loggerAlert($message, $context = [])
    {
        $this->logger->alert($message, $context);
    }

    public function loggerCritical($message, $context = [])
    {
        $this->logger->critical($message, $context);
    }

    public function loggerError($message, $context = [])
    {
        $this->logger->error($message, $context);
    }

    public function loggerWarning($message, $context = [])
    {
        $this->logger->warning($message, $context);
    }

    public function loggerNotice($message, $context = [])
    {
        $this->logger->notice($message, $context);
    }

    public function loggerInfo($message, $context = [])
    {
        $this->logger->info($message, $context);
    }

    public function loggerDebug($message, $context = [])
    {
        $this->logger->debug($message, $context);
    }

    public function loggerDeleteLogs()
    {
        $this->logger->deleteLogs();
    }

    public function loggerDropDatabaseTable()
    {
        $this->logger->dropDatabaseTable();
    }

    public function loggerFetchAll($results = [], $replace = true)
    {
        $fetchedEntries = $this->logger->fetchAll();

        if ($replace) {
            return $fetchedEntries;
        }

        return array_merge($results, $fetchedEntries);
    }

    public function onDeleteAllSettings()
    {
        $this->loggerDropDatabaseTable();
    }
}
