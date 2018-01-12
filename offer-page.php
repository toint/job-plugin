<?php
/*
 * Copy right of LuckyIT 2017
 *
 * @author ToiNT
 * @since Dec 14, 2017, 1:28:16 PM
 * 
*/


function list_offer_page() {
?>
<br/>
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="title"><?php echo __('All Offers');?></div>
		</div>
		<div class="panel-body">
			<table id="tblNewOffer" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th><?php echo __('Job Title');?></th>
						<th><?php echo __('Job Place'); ?></th>
						<th><?php echo __('Level'); ?></th>
						<th><?php echo __('Post date'); ?></th>
						<th><?php echo __('Status'); ?></th>
						<th><?php echo __('Action'); ?></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th><?php echo __('Job Title');?></th>
						<th><?php echo __('Job Place'); ?></th>
						<th><?php echo __('Level'); ?></th>
						<th><?php echo __('Post date'); ?></th>
						<th><?php echo __('Status'); ?></th>
						<th><?php echo __('Action'); ?></th>
					</tr>
				</tfoot>
			</table>
		</div>
		
	</div>
</div>
<?php
}