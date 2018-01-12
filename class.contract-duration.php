<?php
class Contract_Duration {

    function get_contract_durations() {
        global $wpdb;
        $sql = "select * from " . $wpdb->prefix . "offer_meta where code = 'CONTRACT_DURATION' ";

        $results = $wpdb->get_results($sql);
        return $results;
    }

}