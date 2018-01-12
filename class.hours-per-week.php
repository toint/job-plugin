<?php
class Hours_Per_Week {
    
    function get_hours_per_week() {
        global $wpdb;
        $sql = "select * from " . $wpdb->prefix . "offer_meta where code = 'HOURS_PER_WEEK'";
        $results = $wpdb->get_results($sql);
        return $results;
    }
    
}