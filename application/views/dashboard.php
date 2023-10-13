<div class="pg-screen-container">
    <?php if(count($campaign)){ ?>
		<div class="pg-page-title-head">
			<h3>
				<?php echo html_escape($this->lang->line('ltr_dash_page_title')); ?> (<span class="campaign_count"><?php echo count($campaign); ?></span>)
			</h3>
			<a href="#create_new_popup" class="pg-popup-link pg-btn"><?php echo html_escape($this->lang->line('ltr_dash_create_web')); ?></a>
		</div>
	<?php }else{ ?>
		<div class="pg-empty-campain-wrap">
			<div class="pg-empty-campain">
				<span class="pg-empty-icon">
					<img src="<?php echo base_url(); ?>assets/images/empty-folder.png" alt="">
				</span>
				<h3><?php echo html_escape($this->lang->line('ltr_dash_empty_titl')); ?></h3>
				<p><?php echo html_escape($this->lang->line('ltr_dash_empty_desc')); ?></p>
				<a href="#create_new_popup" class="pg-popup-link pg-btn pg-btn-lg mt-3"><?php echo html_escape($this->lang->line('ltr_dash_empty_btn')); ?></a>
			</div>
		</div>
	<?php } ?>
	<div class="ed-user-prepend-campaign-wrapper">
	<?php for($i=0;$i<count($campaign);$i++){ ?>	
		<div class="pg-remove-campaigns">
			<div class="pg-remove-campaigns-row">
				<div class="pg-remove-campaigns-img">
					<div class="pg-remove-campaigns-img-list">
						<?php
						if(!empty($campaign[$i]['templ_thumb'])){
							$thumb = explode(',', $campaign[$i]['templ_thumb']);
							for($j=0;$j<4;$j++){
							?>
							<div class="pg-remove-campaigns-list-item">
								<?php if(!empty($thumb[$j])){ ?>
								<img style="background-image:url(<?php echo base_url().$thumb[$j]; ?>)" src="<?php echo base_url(); ?>assets/images/empty.png" alt="">
								<?php }else{ ?>
								<img src="<?php echo base_url(); ?>assets/images/empty_campaign.jpg" alt="">
								<?php } ?>
							</div> 
							<?php
							}
						}else{ ?>
						<div class="pg-remove-campaigns-list-item">
							<img src="<?php echo base_url(); ?>assets/images/empty_campaign.jpg" alt="">
						</div><div class="pg-remove-campaigns-list-item">
							<img src="<?php echo base_url(); ?>assets/images/empty_campaign.jpg" alt="">
						</div><div class="pg-remove-campaigns-list-item">
							<img src="<?php echo base_url(); ?>assets/images/empty_campaign.jpg" alt="">
						</div><div class="pg-remove-campaigns-list-item">
							<img src="<?php echo base_url(); ?>assets/images/empty_campaign.jpg" alt="">
						</div>
						<?php } ?>
					</div>
					<a href="<?php echo base_url(); ?>campaign/i/<?php echo $campaign[$i]['campaign_id']; ?>" class="pg-template-status">
						<span class="pg-template-status-center">
							<span><svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 477.873 477.873"><g><path d="M392.533 238.937c-9.426 0-17.067 7.641-17.067 17.067V426.67c0 9.426-7.641 17.067-17.067 17.067H51.2c-9.426 0-17.067-7.641-17.067-17.067V85.337c0-9.426 7.641-17.067 17.067-17.067H256c9.426 0 17.067-7.641 17.067-17.067S265.426 34.137 256 34.137H51.2C22.923 34.137 0 57.06 0 85.337V426.67c0 28.277 22.923 51.2 51.2 51.2h307.2c28.277 0 51.2-22.923 51.2-51.2V256.003c0-9.425-7.641-17.066-17.067-17.066z" /><path d="M458.742 19.142A65.328 65.328 0 0 0 412.536.004a64.85 64.85 0 0 0-46.199 19.149L141.534 243.937a17.254 17.254 0 0 0-4.113 6.673l-34.133 102.4c-2.979 8.943 1.856 18.607 10.799 21.585 1.735.578 3.552.873 5.38.875a17.336 17.336 0 0 0 5.393-.87l102.4-34.133c2.515-.84 4.8-2.254 6.673-4.13l224.802-224.802c25.515-25.512 25.518-66.878.007-92.393zm-24.139 68.277L212.736 309.286l-66.287 22.135 22.067-66.202L390.468 43.353c12.202-12.178 31.967-12.158 44.145.044a31.215 31.215 0 0 1 9.12 21.955 31.043 31.043 0 0 1-9.13 22.067z" /></g></svg></span>
						</span>
					</a>
				</div>
				<div class="pg-remove-campaigns-site-content">
					<h3><?php echo $campaign[$i]['name']; ?></h3>
					<p><?php echo html_escape($this->lang->line('ltr_dash_creat_date')); ?>  <?php echo date( 'd/m/Y', strtotime($campaign[$i]['datetime']) ); ?></p>
				</div>
				<div class="pg-remove-campaigns-site-option">
					<ul>
						<li>
							<a href="#ed_campaign_rename" title="Rename" class="pg-popup-link" data-campaign_id="<?php echo $campaign[$i]['campaign_id']; ?>" data-campaign_name="<?php echo $campaign[$i]['name']; ?>">
							<img src="<?php echo base_url(); ?>assets/images/admin/rename.svg" alt="">
                            <span><?php echo html_escape($this->lang->line('ltr_dash_remane_label')); ?></span>
							</a>
						</li>
						<?php if($campaign[$i]['campaign_id'] != 1){ ?>
						<li>
							<a href="" title="Delete" class="campaign_action" data-action="delete" data-campaign_id="<?php echo $campaign[$i]['campaign_id']; ?>">
									<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 512 512"><g><path d="M436 60h-75V45c0-24.813-20.187-45-45-45H196c-24.813 0-45 20.187-45 45v15H76c-24.813 0-45 20.187-45 45 0 19.928 13.025 36.861 31.005 42.761L88.76 470.736C90.687 493.875 110.385 512 133.604 512h244.792c23.22 0 42.918-18.125 44.846-41.271l26.753-322.969C467.975 141.861 481 124.928 481 105c0-24.813-20.187-45-45-45zM181 45c0-8.271 6.729-15 15-15h120c8.271 0 15 6.729 15 15v15H181V45zm212.344 423.246c-.643 7.712-7.208 13.754-14.948 13.754H133.604c-7.739 0-14.305-6.042-14.946-13.747L92.294 150h327.412l-26.362 318.246zM436 120H76c-8.271 0-15-6.729-15-15s6.729-15 15-15h360c8.271 0 15 6.729 15 15s-6.729 15-15 15z" /><path d="m195.971 436.071-15-242c-.513-8.269-7.67-14.558-15.899-14.043-8.269.513-14.556 7.631-14.044 15.899l15 242.001c.493 7.953 7.097 14.072 14.957 14.072 8.687 0 15.519-7.316 14.986-15.929zM256 180c-8.284 0-15 6.716-15 15v242c0 8.284 6.716 15 15 15s15-6.716 15-15V195c0-8.284-6.716-15-15-15zM346.927 180.029c-8.25-.513-15.387 5.774-15.899 14.043l-15 242c-.511 8.268 5.776 15.386 14.044 15.899 8.273.512 15.387-5.778 15.899-14.043l15-242c.512-8.269-5.775-15.387-14.044-15.899z"/></g></svg>
								<span><?php echo html_escape($this->lang->line('ltr_dash_del_label')); ?></span>
							</a>
						</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	<?php } ?>				
	</div>
	<?php for($i=0;$i<count($sub_user_campaign);$i++){ ?>
		<div class="col-md-12">
			<div class="ed_heading">
				<h3><?php echo $sub_user_campaign[$i]['name']; ?> <?php echo html_escape($this->lang->line('ltr_dash_title')); ?>(<span class="campaign_count"><?php echo count($sub_user_campaign[$i]['campaign']); ?></span>) </h3>
			</div>
		</div>
		<?php $campaign = $sub_user_campaign[$i]['campaign']; ?>
		<div>
		<?php for($j=0;$j<count($campaign);$j++){ ?>
			<div class="pg-template-box pg-remove-campaigns">
				<div class="pg-template-box-inner">
					<div class="pg-template-thumb">
						<div class="pg-template-thumb_list">
							<?php
							if(!empty($campaign[$j]['templ_thumb'])){
								$thumb = explode(',', $campaign[$j]['templ_thumb']);
								for($k=0;$k<4;$k++){
								?>
								<div class="pg-remove-campaigns-list-item">
									<?php if(!empty($thumb[$k])){ ?>
									<img style="background-image:url(<?php echo base_url().$thumb[$k]; ?>)" src="<?php echo base_url(); ?>assets/images/empty.png" alt="">
									<?php }else{ ?>
									<img src="<?php echo base_url(); ?>assets/images/empty_campaign.jpg" alt="">
									<?php } ?>
								</div> 
								<?php
								}
							}else{ ?>
							<div class="pg-remove-campaigns-list-item">
								<img src="<?php echo base_url(); ?>assets/images/empty_campaign.jpg" alt="">
							</div><div class="pg-remove-campaigns-list-item">
								<img src="<?php echo base_url(); ?>assets/images/empty_campaign.jpg" alt="">
							</div><div class="pg-remove-campaigns-list-item">
								<img src="<?php echo base_url(); ?>assets/images/empty_campaign.jpg" alt="">
							</div><div class="pg-remove-campaigns-list-item">
								<img src="<?php echo base_url(); ?>assets/images/empty_campaign.jpg" alt="">
							</div>
							<?php } ?>                         
						</div>
						<a href="<?php echo base_url(); ?>campaign/o/<?php echo $campaign[$j]['campaign_id']; ?>/<?php echo $sub_user_campaign[$i]['id']; ?>" class="pg-template-status">
							<span class="pg-template-status-center">
								<span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" width="30px" height="30px" viewBox="0 0 469.331 469.331" style="enable-background:new 0 0 469.331 469.331;" xml:space="preserve" width="512px" height="512px"><g><path d="M438.931,30.403c-40.4-40.5-106.1-40.5-146.5,0l-268.6,268.5c-2.1,2.1-3.4,4.8-3.8,7.7l-19.9,147.4 c-0.6,4.2,0.9,8.4,3.8,11.3c2.5,2.5,6,4,9.5,4c0.6,0,1.2,0,1.8-0.1l88.8-12c7.4-1,12.6-7.8,11.6-15.2c-1-7.4-7.8-12.6-15.2-11.6 l-71.2,9.6l13.9-102.8l108.2,108.2c2.5,2.5,6,4,9.5,4s7-1.4,9.5-4l268.6-268.5c19.6-19.6,30.4-45.6,30.4-73.3 S458.531,49.903,438.931,30.403z M297.631,63.403l45.1,45.1l-245.1,245.1l-45.1-45.1L297.631,63.403z M160.931,416.803l-44.1-44.1 l245.1-245.1l44.1,44.1L160.931,416.803z M424.831,152.403l-107.9-107.9c13.7-11.3,30.8-17.5,48.8-17.5c20.5,0,39.7,8,54.2,22.4 s22.4,33.7,22.4,54.2C442.331,121.703,436.131,138.703,424.831,152.403z" fill="#FFFFFF"/></g></svg></span>
							</span>
						</a>
						<div class="pg-camp-options">
							<ul>
								<li><a href="#ed_campaign_rename" title="Rename" class="pg-popup-link" data-campaign_id="<?php echo $campaign[$j]['campaign_id']; ?>" data-campaign_name="<?php echo $campaign[$j]['name']; ?>" data-sub_user_id="<?php echo $campaign[$j]['user_id']; ?>"><img src="<?= base_url('assets/images/icon/rename.svg') ?>" alt=""><span><?php echo html_escape($this->lang->line('ltr_dash_camp_renam')); ?> </span></a></li>
								<?php if($campaign[$j]['campaign_id'] != 1){ ?>
								<li><a href="" title="Delete" class="campaign_action" data-action="delete" data-campaign_id="<?php echo $campaign[$j]['campaign_id']; ?>" data-sub_user_id="<?php echo $campaign[$j]['user_id']; ?>"><img src="<?= base_url('assets/images/icon/delete.svg') ?>" alt=""><span> <?php echo html_escape($this->lang->line('ltr_dash_camp_del')); ?></span></a></li>
								<?php } ?>
							</ul>
						</div>
					</div>
					<div class="pg-camp-content">
						<h3><?php echo $campaign[$j]['name']; ?></h3>
						<p><?php echo html_escape($this->lang->line('ltr_dash_camp_create')); ?> <?php echo date( 'd/m/Y', strtotime($campaign[$j]['datetime']) ); ?></p>
					</div>
				</div>
			</div>
		<?php } ?>	
		</div>
	<?php } ?>	
</div>

<!-- Modal  -->
<div id="create_new_popup" class="pg-modal-wrapper mfp-hide">
    <div class="pg-modal-inner-row">
        <div class="pg-modal-title-wrap">
            <h3><?php echo html_escape($this->lang->line('ltr_dash_mdl_title')); ?> </h3>
        </div>
        <div class="pg-modal-body">
            <div class="pg-input-holder">
                <label><?php echo html_escape($this->lang->line('ltr_dash_mdl_webname')); ?></label>
                <input type="text"  value="" id="campaign_name">
            </div>
            <div class="pg-modal-btn-wrap">
                <a href="<?php echo base_url(); ?>editor" class="pg-btn pg-btn-lg ed_campaign_create"><?php echo html_escape($this->lang->line('ltr_dash_mdl_create_btn')); ?> </a> 
            </div>
        </div> 
    </div>
</div>
<div id="ed_campaign_rename" class="pg-modal-wrapper mfp-hide">
    <div class="pg-modal-inner-row">
        <div class="pg-modal-title-wrap">
            <h3><?php echo html_escape($this->lang->line('ltr_dash_mdl_rename_wbsit')); ?> </h3>
        </div>
        <div class="pg-modal-body">
            <div class="pg-input-holder">
                <label><?php echo html_escape($this->lang->line('ltr_dash_mdl_web_name')); ?> </label>
                <input type="text"  value="" id="campaign_rename">
                <input type="hidden"  value="" id="campaign_id">
                <input type="hidden"  value="" id="sub_user_id">
            </div>
            <div class="pg-modal-btn-wrap">
                <a href="<?php echo base_url(); ?>editor" class="pg-btn pg-btn-lg campaign_action" data-action="rename"><?php echo html_escape($this->lang->line('ltr_dash_mdl_rename_btn')); ?> </a>
            </div>
        </div> 
    </div>
</div>