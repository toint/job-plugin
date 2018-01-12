<?php

function update_company_plugin_page() 
{
    $com_obj = new Company();
    $business_type = new Business_Type();
    $com = $com_obj->get_company();
    $d = date_create_from_format('Y-m-d', $com->established_date);
    $str_d = date_format($d, 'm/d/Y');
    $err = false;
    $err_msg = '';

    $com_id = $com->id;
    $com_name = $com->name;
    $address = $com->address;
    $phone = $com->mobile;
    $fax = $com->fax;
    $email = $com->email;
    $website = $com->website;
    $com_size = $com->com_size;
    $established_date = $str_d;
    $description = $com->description;
    $business_names = array();
    $business_ids = array();
    $business_id_choosed = '';
    $company_type = new Company_type();
    $com_types = $company_type->get_all();
    $company_type_id = $com->company_type_id;

    $business_list = $business_type->find_by_com_id($com_id);

    if (!empty($business_list)) {
        foreach($business_list as $item) {
            array_push($business_names, $item->name);
            array_push($business_ids, $item->id);
            if ($item->is_choosed == 1) {
                $business_id_choosed = $item->id;
            }
        }
    }

    if (isset($_POST['comName']) 
    && isset($_POST['address']) 
    && isset($_POST['phone']) 
    && isset($_POST['fax']) 
    && isset($_POST['email']) 
    && isset($_POST['website']) 
    && isset($_POST['comSize'])
    && isset($_POST['establishedDate'])
    && isset($_POST['description'])
    && isset($_POST['businessNames'])
    && isset($_POST['businessIds'])
    && isset($_POST['companyType'])) {
        $com_name = $_POST['comName'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $fax = $_POST['fax'];
        $email = $_POST['email'];
        $website = $_POST['website'];
        $com_size = $_POST['comSize'];
        $established_date = $_POST['establishedDate'];
        $description = $_POST['description'];
        $business_ids = $_POST['businessIds'];
        $business_names = $_POST['businessNames'];
        $business_id_choosed = $_POST['businessChoised'];
        $company_type_id = $_POST['companyType'];

        if (empty($com_name)) {
            $err_msg = '<div class="alert alert-danger" role="alert">' . __('Company Name is required.') .'</div>';
            $err = true;
        }
        if (empty($address)) {
            $err_msg = '<div class="alert alert-danger" role="alert">' . __('Address is required.') .'</div>';
            $err = true;
        }
        if (empty($phone)) {
            $err_msg = '<div class="alert alert-danger" role="alert">' . __('Phone is required.') .'</div>';
            $err = true;
        }
        if (empty($email)) {
            $err_msg = '<div class="alert alert-danger" role="alert">' . __('Email is required.') .'</div>';
            $err = true;
        }
        if (empty($website)) {
            $err_msg = '<div class="alert alert-danger" role="alert">' . __('Website is required.') .'</div>';
            $err = true;
        }
        if (empty($com_size)) {
            $err_msg = '<div class="alert alert-danger" role="alert">' . __('Company Size is required.') .'</div>';
            $err = true;
        }
        if (empty($established_date)) {
            $err_msg = '<div class="alert alert-danger" role="alert">' . __('Established Date Size is required.') .'</div>';
            $err = true;
        }
        if (empty($business_ids) || empty($business_names)) {
            $err_msg = '<div class="alert alert-danger" role="alert">' . __('You must select at least one the Business Type.') .'</div>';
            $err = true;
        }
        if (empty($company_type_id) || NULL == $company_type_id) {
            $err_msg = '<div class="alert alert-danger" role="alert">' . __('You must select an the Company Type.') .'</div>';
            $err = true;
        }

        if (!$err) {
            $com_data = array(
                'id' => $com_id,
                'name' => $com_name,
                'address' => $address,
                'mobile' => $phone,
                'fax' => $fax,
                'email' => $email,
                'website' => $website,
                'com_size' => $com_size,
                'established_date' => format_date($established_date),
                'description' => $description,
                'updated_date' => date('Y-m-d h:m:s'),
                'company_type_id' => $company_type_id
            );
            $new_com_data = array('id' => $com_id, 'data' => $com_data);

            $update_status = $com_obj->update($new_com_data);

            if (FALSE == $update_status) {
                $err_msg = '<div class="alert alert-danger" role="alert">' . __('Update data failed.') .'</div>';
                $err = true;
            }

            $bus_datas = array();

            for($i = 0; $i < count($business_ids); $i++) {
                $bus_id = $business_ids[$i];
                $bus_name = $business_names[$i];

                $bus_data = array(
                    'company_id' => $com_id,
                    'business_type_id' => $bus_id,
                    'name' => $bus_name,
                    'is_choosed' => $business_id_choosed
                );
                array_push($bus_datas, $bus_data);
            }
            $business_type->insert_com_business($bus_datas);
        }
    }
?>
    
    <br/>
    <div class="container">
        <?php 
        if ($err) {
            echo $err_msg;
        }
        ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo __('Update Company Info'); ?>
            </div>
            <div class="panel-body">
                <form method="post" id="frmCompany" action="admin.php?page=company_main_menu">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                                <label for="comName"><?php echo __('Company Name'); ?>*</label>
                                <input type="text" maxlength="250" name="comName" class="form-control" value="<?php echo $com_name;?>" />
                            </div>
                            <div class="form-group">
                                <label for="address"><?php echo __('Address')?>*</label>
                                <input type="text" maxlength="250" name="address" class="form-control" value="<?php echo $address; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="mobile"><?php echo __('Phone') ?>*</label>
                                <input type="text" maxlength="50" name="phone" class="form-control" value="<?php echo $phone; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="fax"><?php echo __('Fax') ?></label>
                                <input type="text" maxlength="50" name="fax" class="form-control" value="<?php echo $fax; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="email"><?php echo __('Email') ?>*</label>
                                <input type="text" maxlength="50" name="email" class="form-control" value="<?php echo $email;?>" />
                            </div>
                            <div class="form-group">
                                <label for="fax"><?php echo __('Website') ?>*</label>
                                <input type="text" maxlength="50" name="website" class="form-control" value="<?php echo $website;?>" />
                            </div>
                            <div class="form-group">
                                <label for="comSize"><?php echo __('Company Size') ?>*</label>
                                <input type="text" maxlength="50" name="comSize" class="form-control" value="<?php echo $com_size; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="estdate"><?php echo __('Established date') ?>*</label>
                                <input type="text" name="establishedDate" id="establishedDate" class="form-control" value="<?php echo $established_date; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="description"><?php echo __('Description'); ?></label>
                                <textarea rows="3" name="description" class="form-control"><?php echo $description; ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="page-header">
                                <h4><?php echo __('Bussiness type'); ?></h4>
                            </div>
                            <div class="form-group">
                                <input type="text" id="businessTypeSearch" class="form-control" placeholder="<?php echo __('Search ...') ?>" />
                                <input type="hidden" id="businessId" />
                            </div>
                            <div class="form-group">
                                <div class="list-group" id="list-business-type">
                                    <?php
                                        if (!empty($business_names)) {
                                            for ($i = 0; $i < count($business_names); $i++) {
                                                $bus_name = $business_names[$i];
                                                $bus_id = $business_ids[$i];
                                                $css_active = '';
                                                if ($bus_id == $business_id_choosed || $bus_name == $business_id_choosed) {
                                                    $css_active = 'active';
                                                }
                                                echo '<a href="javascript:void(0);" class="list-group-item item-business-type '. $css_active .'">'. $bus_name .'<input type="hidden" name="businessNames[]" value="'. $bus_name .'" /><input type="hidden" name="businessIds[]" value="'. $bus_id .'" /></a>';
                                            }
                                        }
                                    ?>
                                </div>
                                <input type="hidden" id="businessChoised" name="businessChoised" />
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="page-header">
                                <h4><?php echo __('Company Type'); ?></h4>
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="companyType" name="companyType">
                                        <?php
                                            foreach($com_types as $type) {
                                                $selected = '';
                                                if ($company_type_id != NULL && $type->id == $company_type_id) {
                                                    $selected = 'selected';
                                                }
                                                echo '<option value="'. $type->id.'"'. $selected .'>'. $type->name . '</option>';
                                            }
                                        ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-default" id="btnUpdateCompany"><?php echo __('Save'); ?></button>
                </form>
            </div>
        </div>
    </div>
<?php
}