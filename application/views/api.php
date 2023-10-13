<div class="pg-screen-container">
	<div class="pg-page-title-head">
		<h3><?php echo html_escape($this->lang->line('ltr_api_title')); ?>  (<?php echo count($api); ?>)</h3>
		<a href="<?php echo base_url(); ?>/dashboard/api_generate" class="pg-btn"> <?php echo html_escape($this->lang->line('ltr_api_generate')); ?></a>
	</div>
	<div class="pg-content-wrapper">
        <div class="pg-table-wrap">
            <div class="table-responsive ed_facebook_published">
				<table class="dataTable pg-table">
					<thead>
						<tr>
							<th> <?php echo html_escape($this->lang->line('ltr_api_table_sno')); ?></th>
							<th> <?php echo html_escape($this->lang->line('ltr_api_table_api')); ?></th>
							<th> <?php echo html_escape($this->lang->line('ltr_api_table_site')); ?></th>
							<th> <?php echo html_escape($this->lang->line('ltr_api_table_status')); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php for($i=0;$i<count($api);$i++){ ?>
							<tr>
								<td><?php echo $i + 1; ?></td>
								<td><?php echo $api[$i]['api']; ?></td>
								<td><?php echo $api[$i]['site']; ?></td>		
								<td><?php echo $api[$i]['status']; ?></td>	
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>