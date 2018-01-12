<?php
class Company_Type {

    function get_all() {
        global $wpdb;
        $sql = "select * from ". $wpdb->prefix . "company_type";
        $results = $wpdb->get_results($sql);

        return $results;
    }
    
    function find_by_id($id) {
        global $wpdb;
        $sql = "select * from " . $wpdb->prefix . "company_type where id = " . $id;
        $results = $wpdb->get_results($sql);
        if (!empty($results)) return $results[0];
        return NULL;
    }

}