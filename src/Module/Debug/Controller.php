<?php

namespace PublishPressFuture\Module\Debug;

use PublishPressFuture\Core\HookableInterface;
use PublishPressFuture\Core\InitializableInterface;
use PublishPressFuture\Core\LoggerInterface;
use PublishPressFuture\Module\Settings\HooksAbstract as SettingsHooksAbstract;

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
     */
    public function __construct(HookableInterface $hooks, LoggerInterface $logger)
    {
        $this->hooks = $hooks;
        $this->logger = $logger;
    }

    public function initialize()
    {
        $this->hooks->addAction(HooksAbstract::ACTION_LOGGER_LOG, [$this, 'loggerLog'], 10, 3);
        $this->hooks->addAction(HooksAbstract::ACTION_LOGGER_EMERGENCY, [$this, 'loggerEmergency'], 10, 2);
        $this->hooks->addAction(HooksAbstract::ACTION_LOGGER_ALERT, [$this, 'loggerAlert'], 10, 2);
        $this->hooks->addAction(HooksAbstract::ACTION_LOGGER_CRITICAL, [$this, 'loggerCritical'], 10, 2);
        $this->hooks->addAction(HooksAbstract::ACTION_LOGGER_ERROR, [$this, 'loggerError'], 10, 2);
        $this->hooks->addAction(HooksAbstract::ACTION_LOGGER_WARNING, [$this, 'loggerWarning'], 10, 2);
        $this->hooks->addAction(HooksAbstract::ACTION_LOGGER_NOTICE, [$this, 'loggerNotice'], 10, 2);
        $this->hooks->addAction(HooksAbstract::ACTION_LOGGER_INFO, [$this, 'loggerInfo'], 10, 2);
        $this->hooks->addAction(HooksAbstract::ACTION_LOGGER_DEBUG, [$this, 'loggerDebug'], 10, 2);
        $this->hooks->addAction(HooksAbstract::ACTION_LOGGER_DELETE_LOGS, [$this, 'loggerDeleteLogs'], 10);
        $this->hooks->addAction(HooksAbstract::ACTION_LOGGER_DROP_DATABASE_TABLE, [$this, 'loggerDropDatabaseTable'], 10);

        $this->hooks->addAction(SettingsHooksAbstract::ACTION_DELETE_ALL_SETTINGS, [$this, 'onDeleteAllSettings']);

        $this->hooks->addFilter(HooksAbstract::FILTER_LOGGER_FETCH_ALL, [$this, 'loggerFetchAll'], 10);
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

    public function loggerFetchAll($results = [])
    {
        $results = $this->logger->fetchAll();

        return $results;
    }

    public function onDeleteAllSettings()
    {
        $this->loggerDropDatabaseTable();
    }
}
