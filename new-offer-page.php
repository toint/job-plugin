<?php

function new_offer_page()
{
    
    $levels = get_offer_meta(null, 'LEVEL');
    $durations = get_offer_meta(null, 'CONTRACT_DURATION');
    $list_hours = get_offer_meta(null, 'HOURS_PER_WEEK');
    $occupations = get_offer_meta(null, 'OCCUPATION');
    
    $offer = new Offer();
    
    $txt_job_title = '';
    $txt_place_code = '';
    $txt_place_name = '';
    $txt_job_type = '';
    $txt_occupation = '';
    $txt_level = '';
    $txt_job_activity = '';
    $txt_contract_duration = '';
    $txt_hours_per_week = '';
    $txt_negociation = '0';
    $txt_salary = '';
    $txt_post_date = '';
    $update_flag = false;
    $update_msg = '';
    $err_msg = '';
    $err_flag = false;
    $arr_job_activity = array();
    $arr_it_skill = array();
    $arr_language = array();
    $arr_human_skill = array();
    $status = '0';
    
    $offer_id = '';
    if (isset($_GET['id'])) {
        $offer_id = $_GET['id'];
        if (empty($offer_id)) {
            echo __('Page not found.');
            die();
        }
        $offer_data = $offer->find_offer_by_id($offer_id);
        if (NULL == $offer_data) {
            echo __('Page not found.');
            die();
        }
        $txt_job_title = $offer_data->title;
        $txt_place_code = $offer_data->place_code;
        $txt_place_name = $offer_data->place_text;
        $txt_job_type = $offer_data->job_type;
        $txt_occupation = $offer_data->occupation;
        $txt_level = $offer_data->level;
        $txt_contract_duration = $offer_data->contract_duration;
        $txt_hours_per_week = $offer_data->hours_per_week;
        $txt_salary = $offer_data->salary;
        $txt_negociation = $offer_data->negociation;
        $status = $offer_data->status;
        $txt_post_date = date_to_MDY($offer_data->posted_date);
        
        $offer_meta = $offer->get_offer_meta_name_by_id($offer_id);
        if (!empty($offer_meta)) {
            foreach ($offer_meta as $meta) {
                if ($meta->code == 'JOB_ACTIVITY') {
                    array_push($arr_job_activity, $meta->name);
                } elseif ($meta->code == 'IT_SKILL') {
                    array_push($arr_it_skill, $meta->name);
                } elseif ($meta->code == 'LANGUAGE') {
                    array_push($arr_language, $meta->name);
                } elseif ($meta->code == 'HUMAN_SKILL') {
                    array_push($arr_human_skill, $meta->name);
                }
            }
        }
    }
    
    if (isset($_POST['placeCode'])) {
        if (isset($_POST['placeCode'])) {
            $txt_place_code = $_POST['placeCode'];
        }
        if (isset($_POST['placeName'])) {
            $txt_place_name = $_POST['placeName'];
        }
        if (isset($_POST['jobTitle'])) {
            $txt_job_title = $_POST['jobTitle'];
        }
        if (isset($_POST['jobType'])) {
            $txt_job_type = $_POST['jobType'];
        }
        if (isset($_POST['occupation'])) {
            $txt_occupation = $_POST['occupation'];
        }
        if (isset($_POST['level'])) {
            $txt_level = $_POST['level'];
        }
        if (isset($_POST['contractDuration'])) {
            $txt_contract_duration = $_POST['contractDuration'];
        }
        if (isset($_POST['hoursPerWeek'])) {
            $txt_hours_per_week = $_POST['hoursPerWeek'];
        }
        if (isset($_POST['negociation'])) {
            $txt_negociation = $_POST['negociation'];
        }
        if (isset($_POST['salary'])) {
            $txt_salary = $_POST['salary'];
        }
        if (isset($_POST['postDate'])) {
            $txt_post_date = $_POST['postDate'];
        }
        if (isset($_POST['arrJobActivityName'])) {
            $arr_job_activity = $_POST['arrJobActivityName'];
        } else {
            $arr_job_activity = array();
        }
        if (isset($_POST['arrItSkill'])) {
            $arr_it_skill = $_POST['arrItSkill'];
        }
        if (isset($_POST['arrLanguages'])) {
            $arr_language = $_POST['arrLanguages'];
        } else {
            $arr_it_skill = array();
        }
        if (isset($_POST['arrHumanSkill'])) {
            $arr_human_skill = $_POST['arrHumanSkill'];
        } else {
            $arr_human_skill = array();
        }

        if (empty($txt_place_code) || empty($txt_job_title) 
            || empty($txt_job_type) || empty($txt_occupation) 
            || empty($txt_level) || empty($txt_contract_duration)
            || empty($txt_hours_per_week) || empty($txt_post_date)) {
            $status = 0;
        } else {
            $status = 1;
        }
        if (empty($txt_job_title)) {
            $txt_job_title = __('The Title New Offer');
        }
        
        if ($txt_negociation == 'on') {
            $txt_negociation = '1';
        } else {
            $txt_negociation = '0';
        }
        
        $user = wp_get_current_user();
        $offer_data = array(
            'post_url' => sanitize_title($txt_job_title),
            'title' => $txt_job_title,
            'place_code' => $txt_place_code,
            'place_text' => $txt_place_name,
            'job_type' => $txt_job_type,
            'occupation' => $txt_occupation,
            'contract_duration' => $txt_contract_duration,
            'hours_per_week' => $txt_hours_per_week,
            'level' => $txt_level,
            'salary' => $txt_salary,
            'negociation' => $txt_negociation,
            'version' => '1.0',
            'user_id' => $user->ID,
            'status' => $status,
            'posted_date' => format_date($txt_post_date),
        	'updated_date' => date('Y-m-d h:m:s')
        );
        
        $meta_data = array();
        if (!empty($arr_job_activity)) {
            for ($i = 0; $i < count($arr_job_activity); $i++) {
                array_push($meta_data, array('code' => 'JOB_ACTIVITY', 'name' => $arr_job_activity[$i]));
            }
        }
        if (!empty($arr_it_skill)) {
            for ($i = 0; $i < count($arr_it_skill); $i++) {
                array_push($meta_data, array('code' => 'IT_SKILL', 'name' => $arr_it_skill[$i]));
            }
        }
        if (!empty($arr_language)) {
            for ($i = 0; $i < count($arr_language); $i++) {
                array_push($meta_data, array('code' => 'LANGUAGE', 'name' => $arr_language[$i]));
            }
        }
        if (!empty($arr_human_skill)) {
            for ($i = 0; $i < count($arr_human_skill); $i++) {
                array_push($meta_data, array('code' => 'HUMAN_SKILL', 'name' => $arr_human_skill[$i]));
            }
        }
        
        $update_flag = true;
        if ($offer_id == '' || $offer_id == 0) {
            $data = array('offer' => $offer_data, 'meta_data' => $meta_data);
            $offer_id = $offer->offer_save($data);
            if ($offer_id != '' && $offer_id != 0) {
                $update_msg = __('Add New Offer Successfully!');
            } else {
                $update_msg = __('Add New Offer Failed!');
            }
        } else {
            $data = array('offer' => $offer_data, 'where' => array('id' => $offer_id), 'meta_data' => $meta_data);
            $status_update = $offer->offer_update($data);
            if ($status_update == TRUE) {
                $update_msg = __('Update New Offer Successfully!');
            } else {
                $update_msg = __('Update New Offer Failed!');
            }
        }
    }
    
?>
<br/>
<?php 
//if ($err_flag) { echo $err_msg; }
if ($update_flag) {
    echo $update_msg;
}
?>
<br/>
	<div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo __('New Offer') ?>
            </div>
            <div class="panel-body">
                <form method="post" id="frmNewOffer" class="form-horizontal">
                <input type="hidden" name="id" value="<?php echo $offer_id; ?>" /> 
                	<div>
                		<ul class="nav nav-tabs" role="tablist">
                			<li role="presentation" class="active">
                				<a href="#general" aria-controls="general" role="tab" data-toggle="tab"><?php echo __('General');?></a>
                			</li>
                			<li role="presentation">
                				<a href="#skills" aria-controls="skills" role="tab" data-toggle="tab"><?php echo __('Skills');?></a>
                			</li>
                		</ul>
                		<div class="tab-content">
                			<div role="tabpanel" class="tab-pane active" id="general">
                				<br/>
                				<div class="form-group">
                                    <label for="place" class="col-sm-2 control-label"><?php echo __('Job Place'); ?></label>
                                    <div class="col-sm-6">
                                        <input type="text" name="placeName" id="placeName" class="form-control" readonly="readonly" value="<?php echo $txt_place_name;?>"/>
                                        <input type="hidden" name="placeCode" id="placeCode" value="<?php echo $txt_place_code; ?>" />
                                    </div>
                                    <div class="col-sm-4">
                                    <button type="button" class="btn btn-default full-width" id="btnPlace"><?php echo __('Choose on map'); ?></button>
                                    </div>
                                </div>
                                <div class="form-group">
                                	<label for="jobTitle" class="col-sm-2 control-label"><?php echo __('Job Title');?></label>
                                	<div class="col-sm-10">
                                		<input type="text" value="<?php echo $txt_job_title;?>" name="jobTitle" class="form-control" maxlength="250" />
                                	</div>
                                </div>
                                <div class="form-group">
                                    <label for="jobType" class="col-sm-2 control-label"><?php echo __('Job Type');?></label>
                                    <div class="col-sm-10">
                                        <input value="<?php echo $txt_job_type;?>" type="text" class="form-control" name="jobType" id="jobType" placeholder="<?php echo __('Enter Job Type'); ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="occupation" class="col-sm-2 control-label"><?php echo __('Occupation'); ?></label>
                                    <div class="col-sm-10">
                                    	<select class="form-control" id="occupation" name="occupation">
                                    		<?php 
                                    		foreach ($occupations as $item) {
                                    		    $selected = '';
                                    		    if ($item->name == $txt_occupation) $selected = 'selected';
                                    		?>
                                    		<option <?php echo $selected;?> value="<?php echo $item->name;?>"><?php echo $item->name;?></option>
                                    		<?php }?>
                                    	</select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="level" class="col-sm-2 control-label"><?php echo __('Level'); ?></label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="level" name="level">
                                            <?php 
                                                foreach($levels as $item) {
                                                    $selected = '';
                                                    if ($item->name == $txt_level) {
                                                        $selected = 'selected';
                                                    }
                                                    echo '<option '. $selected .' value="' . $item->name .'">'. __($item->name) . '</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jobActivity" class="col-sm-2 control-label"><?php echo __('Job Activity Description'); ?></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="jobActivity" id="jobActivity" placeholder="<?php echo __('Search ...');?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                	<div class="col-sm-2"></div>
                                	<ul class="col-sm-10" id="list-job-activity">
                                	<?php 
                                	if (!empty($arr_job_activity)) { 
                                	    for($i = 0; $i < count($arr_job_activity); $i++) {
                                	    ?>
                                	<li class="list-group-item" id="list-job-activity-item-<?php echo $i; ?>">
                                		<span class="badge"><a href="javascript:void(0);" onclick="remove_list_group('list-job-activity-item-<?php echo $i;?>')"><?php echo __('Delete')?></a></span>
                                		<?php echo $arr_job_activity[$i];?><input type="hidden" name="arrJobActivityName[]" value="<?php echo $arr_job_activity[$i];?>" />
                                	</li>
                                	<?php 
                                	} }
                                	?>
                                	</ul>
                                </div>
                                <div class="form-group">
                                    <label for="contractDuration" class="col-sm-2 control-label"><?php echo __('Contract duration'); ?></label>
                                    <div class="col-sm-10">
                                        <select id="contractDuration" name="contractDuration" class="form-control">
                                            <?php 
                                                foreach($durations as $item) {
                                                    $selected = '';
                                                    if ($item->name == $txt_contract_duration) {
                                                        $selected = 'selected';
                                                    }
                                                    echo '<option '. $selected .' value="' . $item->name .'">'. __($item->name) . '</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="howrsPerWeek" class="col-sm-2 control-label"><?php echo __('Hours per week'); ?></label>
                                    <div class="col-sm-10">
                                        <select name="hoursPerWeek" id="howrsPerWeek" class="form-control" id="hoursPerWeek">
            								<?php 
            								    foreach ($list_hours as $item) {
            								        $selected = '';
            								        if ($item->name == $txt_hours_per_week) {
            								            $selected = 'selected';
            								        }
            								        echo '<option '. $selected .' value="' . $item->name . '">'. __($item->name) . '</option>';
            								    }
            								?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <div class="checkbox">
                                            <label>
                                            	<?php 
                                            	$is_negociation_checked = '';
                                            	if ($txt_negociation == 1) {
                                            	    $is_negociation_checked = 'checked';
                                            	}
                                            	?>
                                                <input type="checkbox" name="negociation" id="negociation" <?php echo $is_negociation_checked;?> /> <?php echo __('Open for negociation'); ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="salary" class="col-sm-2 control-label"><?php echo __('Salary'); ?></label>
                                    <div class="col-sm-10">
                                        <input value="<?php echo $txt_salary;?>" type="text" name="salary" id="salary" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="salary" class="col-sm-2 control-label"><?php echo __('Post date'); ?></label>
                                    <div class="col-sm-10">
                                        <input value="<?php echo $txt_post_date;?>" type="text" name="postDate" id="postDate" class="form-control" />
                                    </div>
                                </div>
                			</div>
                			<div role="tabpanel" class="tab-pane" id="skills">
                				<br/>
                				<div class="form-group">
                					<label for="itSkill" class="col-sm-2 control-label"><?php echo __('IT skills');?></label>
                					<div class="col-sm-10">
                						<input type="text" class="form-control" id="itSkill" name="itSkill" placeholder="<?php echo __('Search ...');?>"/>
                					</div>
                				</div>
                				<div class="form-group">
                                	<div class="col-sm-2"></div>
                                	<ul class="col-sm-10" id="list-itSkills">
                                	<?php 
                                	if (!empty($arr_it_skill)) {
                                	    for($i = 0; $i < count($arr_it_skill); $i++) {
                                	?>
                                	<li class="list-group-item" id="list-itSkills-item-<?php echo $i;?>">
                                		<span class="badge"><a href="javascript:void(0);" onclick="remove_list_group('list-itSkills-item-<?php echo $i;?>')"><?php echo __('Delete')?></a></span>
                                		<?php echo $arr_it_skill[$i];?><input type="hidden" name="arrItSkill[]" value="<?php echo $arr_it_skill[$i];?>" />
                                	</li>
                                	<?php 
                                	}}
                                	?>
                                	</ul>
                                </div>
                				<div class="form-group">
                					<label for="languages" class="col-sm-2 control-label"><?php echo __('Languages');?></label>
                					<div class="col-sm-10">
                						<input type="text" class="form-control" id="languages" name="languages" placeholder="<?php echo __('Search ...');?>"/>
                					</div>
                				</div>
                				<div class="form-group">
                                	<div class="col-sm-2"></div>
                                	<ul class="col-sm-10" id="list-languages">
                                	<?php 
                                	if (!empty($arr_language)) {
                                	    for($i = 0; $i < count($arr_language); $i++) {
                                	?>
                                	<li class="list-group-item" id="list-languages-item-<?php echo $i;?>">
                                		<span class="badge"><a href="javascript:void(0);" onclick="remove_list_group('list-languages-item-<?php echo $i;?>')"><?php echo __('Delete')?></a></span>
                                		<?php echo $arr_language[$i];?><input type="hidden" name="arrLanguages[]" value="<?php echo $arr_language[$i];?>" />
                                	</li>
                                	<?php 
                                	}}
                                	?>
                                	</ul>
                                </div>
                				<div class="form-group">
                					<label for="humanSkill" class="col-sm-2 control-label"><?php echo __('Human skills');?></label>
                					<div class="col-sm-10">
                						<input type="text" class="form-control" id="humanSkill" name="humanSkill" placeholder="<?php echo __('Search ...');?>"/>
                					</div>
                				</div>
                				<div class="form-group">
                                	<div class="col-sm-2"></div>
                                	<ul class="col-sm-10" id="list-human-skill">
                                	<?php 
                                	if (!empty($arr_human_skill)) {
                                	    for($i = 0; $i < count($arr_human_skill); $i++) {
                                	?>
                                	<li id="list-human-skill-item-<?php echo $i;?>" class="list-group-item">
                                		<span class="badge"><a href="javascript:void(0);" onclick="remove_list_group('list-human-skill-item-<?php echo $i;?>')"><?php echo __('Delete')?></a></span>
                                		<?php echo $arr_human_skill[$i];?>
                                		<input type="hidden" name="arrHumanSkill[]" value="<?php echo $arr_human_skill[$i];?>" />
                                	</li>
                                	<?php 
                                	}}
                                	?>
                                	</ul>
                                </div>
                			</div>
                		</div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-default" id="btnSave"><?php echo __('Save'); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
	</div>

    <div id="vector-map-modal" title="Map">
        <div id="map-viet-nam" style="width: 320px; height: 360px;"></div>
    </div>
    
<?php
}
?>