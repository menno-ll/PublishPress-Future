<?php

namespace PublishPressFuture\Core\WordPress;

use function dbDelta;

class DatabaseFacade
{
    /**
     * @return string
     */
    public function getTablePrefix()
    {
        global $wpdb;

        return $wpdb->prefix;
    }

    /**
     * @param string $query
     * @param integer $x
     * @param integer $y
     *
     * @return string|null
     */
    public function getVar($query = null, $x = 0, $y = 0)
    {
        global $wpdb;

        return $wpdb->get_var($query, $x, $y);
    }

    /**
     * @param string $query
     *
     * @return int|bool
     */
    public function query($query)
    {
        global $wpdb;

        return $wpdb->query($query);
    }

    /**
     * @param string $query
     *
     * @return string
     */
    public function prepare($query, ...$args)
    {
        global $wpdb;

        $functionArgs = func_get_args();

        return call_user_func_array([$wpdb, 'prepare'], $functionArgs);
    }

    public function escape($data)
    {
        return esc_sql($data);
    }

    /**
     * @param string[]|string
     * @param bool
     *
     * @return array
     */
    public function modifyStructure($queries = '', $execute = true)
    {
        if (! function_exists('dbDelta')) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        return dbDelta($queries, $execute);
    }

    /**
     * @param string $query
     * @param string $output
     * @return array|object|null
     */
    public function getResults($query = null, $output = 'OBJECT')
    {
        global $wpdb;

        return $wpdb->get_results($query, $output);
    }

    /**
     * @param string $tableName
     *
     * @return void
     */
    public function dropTable($tableName)
    {
        global $wpdb;

        $wpdb->query('DROP TABLE IF EXISTS `' . esc_sql($tableName) . '`');
    }
}
