<?php

class Offer {
    
    function offer_update($data) {
        global $wpdb;
        $status = $wpdb->update($wpdb->prefix . 'new_offer', $data['offer'], $data['where']);
        $offer_id = $data['where']['id'];
        if ($status == false) { 
            return FALSE;
            die();
        }
        
        
        $this->delete_offer_meta($wpdb, $offer_id);
        
        $offer = $data['offer'];
        $job_type = $offer['job_type'];
        $this->insert_offer_meta($wpdb, 'JOB_TYPE', $job_type);
        
        $meta_data = $data['meta_data'];
        $this->insert_new_offer_meta($wpdb, $offer_id, $meta_data);
        
        return TRUE;
    }
    
    
    
    function offer_save($data) {
        global $wpdb;
        $new_offer = $wpdb->insert($wpdb->prefix . 'new_offer', $data['offer']);
        $offer_id = $wpdb->insert_id;
        
        if ($new_offer == FALSE) {
            die();
            return '';
        }
        
        $offer = $data['offer'];
        $job_type = $offer['job_type'];
        $this->insert_offer_meta($wpdb, 'JOB_TYPE', $job_type);
        
        $meta_data = $data['meta_data'];
        $this->insert_new_offer_meta($wpdb, $offer_id, $meta_data);
        
        return $offer_id;
        
    }
    
    function delete_offer_meta($wpdb, $offer_id) {
        try {
            $result = $wpdb->delete($wpdb->prefix . 'new_offer_meta', array('offer_id' => $offer_id));
            if (false == $result) {
                return FALSE;
            }
            return TRUE;
        } catch (Exception $e) {
            return FALSE;
        }
    }
    
    function insert_new_offer_meta($wpdb, $offer_id, $data) {
        if (!empty($data)) {
            foreach ($data as $item) {
                $meta_id = $this->get_meta_id_by_code_name($wpdb, $item['code'], $item['name']);
                
                if ($meta_id == 0) {
                    $offer_meta = $wpdb->insert($wpdb->prefix . "offer_meta", array('code' => $item['code'], 'name' => $item['name']));
                    $meta_id = $wpdb->insert_id;
                    $wpdb->insert($wpdb->prefix . "new_offer_meta", array('offer_id' => $offer_id, 'meta_id' => $meta_id));
                } else {
                    $wpdb->insert($wpdb->prefix . "new_offer_meta", array('offer_id' => $offer_id, 'meta_id' => $meta_id));
                }
            }
        }
    }
    
    function insert_offer_meta($wpdb, $code, $name) {
        try {
            $is_check = $this->is_exist_meta_by_code_name($wpdb, $code, $name);
            if(FALSE == $is_check) {
                $wpdb->insert($wpdb->prefix . "offer_meta", array('code' => $code, 'name' => $name));
                return $wpdb->insert_id;
            }
        } catch (Exception $e) {
            return 0;
        }
    }
    
    function is_exist_meta_by_code_name($wpdb, $code, $name) {
        try {
            $sql = "select * from " . $wpdb->prefix . "offer_meta where code = '". $code . "' and lower(name) = '" . strtolower($name) ."' ";
            
            $result = $wpdb->get_results($sql);
            if (!empty($result)) {
                return TRUE;
            }
            return FALSE;
        } catch (Exception $e) {
            return FALSE;
        }
    }
    
    function get_meta_id_by_code_name($wpdb, $code, $name) {
        try {
            $sql = "select * from " . $wpdb->prefix . "offer_meta where lower(code) = '" .strtolower($code) . "' and lower(name) = '" . strtolower($name) . "' ";
            $result = $wpdb->get_results($sql);
            if (empty($result)) return 0;
            return $result[0]->id;
        } catch (Exception $e) {
            return 0;
        }
    }
    
    function find_meta_by_id($wpdb, $id) {
        try {
            $sql = "select * from " . $wpdb->prefix . "offer_meta where id = " . $id;
            $result = $wpdb->get_results($sql);
            if (!empty($result))
                return $result[0]->id;
            return 0;
        } catch (Exception $ex) {
            return 0;
        }
    }
    
    function search($data) {
        global $wpdb;
        $user = wp_get_current_user();
        
        $sql = "select id, title, place_code, place_text, level, posted_date, ";
        $sql .= "case when status = 0 then 'Bản nháp' else 'Đang mở' end as status_name ";
        $sql .= " from " . $wpdb->prefix . "new_offer where user_id = " . $user->ID;
        $results = $wpdb->get_results($sql);
        
        return $results;
    }
    
    function find_offer_by_id($id) {
        global $wpdb;
        $user = wp_get_current_user();
        
        $sql = "select * from " . $wpdb->prefix . "new_offer where user_id = " . $user->ID . " and id = " . $id;
        $results = $wpdb->get_results($sql);
        if (!empty($results)) return $results[0];
        return NULL;
    }
    
    function get_offer_meta_name_by_id($offer_id) {
        global $wpdb;
        try {
            $sql = "select m.code, m.name from " . $wpdb->prefix . "offer_meta m join " . $wpdb->prefix . "new_offer_meta ofm on m.id = ofm.meta_id and ofm.offer_id = " . $offer_id;
            $results = $wpdb->get_results($sql);
            return $results;
        } catch (Exception $e) {
            return '';
        }
    }
}