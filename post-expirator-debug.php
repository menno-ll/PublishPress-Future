<?php

/**
 * The class that adds debug entries to the database.
 */
class PostExpiratorDebug
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        global $wpdb;
        $this->debug_table = $wpdb->prefix . 'postexpirator_debug';
        $this->createDBTable();
    }

    /**
     * Create Database Table to store debugging information if it does not already exist.
     */
    private function createDBTable()
    {
        global $wpdb;

        if ($wpdb->get_var("SHOW TABLES LIKE '" . $this->debug_table . "'") !== $this->debug_table) { // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
            $sql = 'CREATE TABLE `' . $this->debug_table . '` (
                `id` INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `timestamp` TIMESTAMP NOT NULL,
                `blog` INT(9) NOT NULL,
                `message` text NOT NULL
            );';
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }

    /**
     * Drop Database Table.
     */
    public function removeDBTable()
    {
        global $wpdb;

        $wpdb->query('DROP TABLE IF EXISTS ' . $this->debug_table); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.DirectDatabaseQuery.NoCaching
    }

    /**
     * Insert into Database Table.
     */
    public function save($data)
    {
        global $wpdb;
        if (is_multisite()) {
            global $current_blog;
            $blog = $current_blog->blog_id;
        } else {
            $blog = 0;
        }
        $wpdb->query( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching
            $wpdb->prepare(
                'INSERT INTO ' . $this->debug_table . ' (`timestamp`,`message`,`blog`) VALUES (FROM_UNIXTIME(%d),%s,%s)', // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                time(),
                $data['message'],
                $blog
            )
        );
    }

    /**
     * Get the HTML of the table's data.
     */
    public function getTable()
    {
        global $wpdb;
        $results = $wpdb->get_results("SELECT * FROM {$this->debug_table} ORDER BY `id` ASC"); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
        if (empty($results)) {
            print '<p>' . esc_html__('Debugging table is currently empty.', 'post-expirator') . '</p>';

            return;
        }
        print '<table class="post-expirator-debug">';
        print '<tr><th class="post-expirator-timestamp">' . esc_html__('Timestamp', 'post-expirator') . '</th>';
        print '<th>' . esc_html__('Message', 'post-expirator') . '</th></tr>';
        foreach ($results as $result) {
            print '<tr><td>' . esc_html($result->timestamp) . '</td>';
            print '<td>' . esc_html($result->message) . '</td></tr>';
        }
        print '</table>';
    }

    /**
     * Truncate Database Table.
     */
    public function purge()
    {
        global $wpdb;
        $wpdb->query("TRUNCATE TABLE {$this->debug_table}"); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
    }
}
