<?php
class Company {  

    function get_company() {
        global $wpdb;
        
        $user = wp_get_current_user();

        $sql = "select * from ". $wpdb->prefix ."company where delete_flag = '0' and user_id = " . $user->ID;
        $results = $wpdb->get_results($sql);

        if (empty($results)) return NULL;
        return $results[0];
    }

    function update($data) {
        global $wpdb;
        $user = wp_get_current_user();

        $result = $wpdb->update($wpdb->prefix . 'company',$data['data'], array('id' => $data['id']));
        return $result;
    }

}