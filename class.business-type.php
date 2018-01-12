<?php
class Business_Type {

    function find_by_name($name) {
        global $wpdb;
        $sql = "select * from ". $wpdb->prefix . "business_type where 1 =1 ";
        if (!empty($name)) {
            $sql .= " and lower(name) like '%" . strtolower($name) . "%'";
        }
        $results = $wpdb->get_results($sql);
        return $results;
    }

    function find_by_com_id($com_id) {
        global $wpdb;
        $sql = "select bt.id, bt.name, cb.is_choosed from " . $wpdb->prefix . "business_type as bt ";
        $sql .= " join ". $wpdb->prefix . "com_business_type cb on cb.business_type_id = bt.id ";
        $sql .= " where cb.company_id = " . $com_id;

        $results = $wpdb->get_results($sql);
        return $results;
    }

    function insert_com_business($datas) {
        global $wpdb;
        try {
            $data = (object) $datas[0];
            $wpdb->delete($wpdb->prefix . 'com_business_type', array('company_id' => $data->company_id));
        } catch (Exception $e) {}

        foreach ($datas as $data_arr) {
            $data = (object) $data_arr;
            $user = wp_get_current_user();
            $business_id = $data->business_type_id;
            try {
                $total = 0;
                if (is_numeric($business_id)) {
                    $sql = "select count(*) from " . $wpdb->prefix . "business_type where id = " . $business_id;
                    $total = $wpdb->get_var($sql);
                }
                if (NULL == $total || $total <= 0) {
                    $data_business = array('name' => $data->name, 'created_user' => $user->ID);
                    $wpdb->insert($wpdb->prefix . 'business_type', $data_business);
                    $business_id = $wpdb->insert_id;
                }
            } catch (Exception $e) {}
            $choosed = 0;
            if ($business_id == $data->is_choosed || $data->name == $data->is_choosed) {
                $choosed = 1;
            }
            
            $data_bus_type = array('business_type_id' => $business_id, 'company_id' => $data->company_id, 'is_choosed' => $choosed);
            $result = $wpdb->insert($wpdb->prefix . 'com_business_type', $data_bus_type);
        }
    }

}