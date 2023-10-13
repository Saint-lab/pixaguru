<div class="pg-screen-container">
	<div class="pg-page-title-head">
        <h3>
			<?php echo isset($use) && $use ? 'Select ' : ''; ?><?php echo html_escape($this->lang->line('ltr_prebuild_temp_title')); ?> 
        </h3>
        <a data-mfp-src="#user-prebuild-existing-template" class="pg-btn pg-popup-link" data-template_userID="" data-get_template_id=""><?php echo html_escape($this->lang->line('ltr_prebuild_temp_title_btn')); ?> </a>
    </div>
	<div class="pg-content-wrapper">
		<div class="pg-template-filter-wrapper">
			<?php if(!(isset($use) && $use)){ ?>
				<div class="pg-template-filter">
					<p><?php echo html_escape($this->lang->line('ltr_prebuild_filter_title')); ?></p>					
					<?php $size_key = array_column($template_size_count, 'template_size'); ?>					
					<select  id="redirect_bundle">
						<option value=""><?php echo html_escape($this->lang->line('ltr_prebuild_temp_sel_cat')); ?> </option>
						<option value="custom"> <?php echo html_escape($this->lang->line('ltr_prebuild_temp_create_custom')); ?> </option>
						<optgroup label="WordPress Images">
							<option value="1200x885" <?php echo $size == '1200x885' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_prebuild_temp_video_thumb')); ?></option>
							<option value="1200x1200" <?php echo $size == '1200x1200' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_prebuild_temp_video_squre')); ?></option>
						</optgroup>
						<optgroup label="Social Media">
							<option value="940x940" <?php echo $size == '940x940' ? 'selected' : ''; ?> > <?php echo html_escape($this->lang->line('ltr_prebuild_temp_fb_post')); ?></option>
							<option value="628x628" <?php echo $size == '628x628' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_prebuild_temp_fb_squre')); ?></option>
							<option value="1080x1080" <?php echo $size == '1080x1080' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_prebuild_temp_insta_post')); ?></option>
							<option value="735x1102" <?php echo $size == '735x1102' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_prebuild_temp_pint_pins')); ?></option>
							<option value="1024x512" <?php echo $size == '1024x512' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_prebuild_temp_twit_post')); ?></option>
							<option value="497x373" <?php echo $size == '497x373' ? 'selected' : ''; ?> > <?php echo html_escape($this->lang->line('ltr_prebuild_temp_g_post')); ?></option>
							<option value="851x315" <?php echo $size == '851x315' ? 'selected' : ''; ?> > <?php echo html_escape($this->lang->line('ltr_prebuild_temp_fb_covers')); ?></option>
							<option value="1500x500" <?php echo $size == '1500x500' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_prebuild_temp_twit_header')); ?></option>
						</optgroup>
						<optgroup label="AD Images">
							<option value="1200x628" <?php echo $size == '1200x628' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_prebuild_temp_fb_web_conv')); ?></option>
							<option value="1200x900" <?php echo $size == '1200x900' ? 'selected' : ''; ?> > <?php echo html_escape($this->lang->line('ltr_prebuild_temp_fb_page_post_eng')); ?></option>
							<option value="1200x444" <?php echo $size == '1200x444' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_prebuild_temp_fb_page_likes')); ?></option>
							<option value="800x200" <?php echo $size == '800x200' ? 'selected' : ''; ?> > <?php echo html_escape($this->lang->line('ltr_prebuild_temp_twit_lead')); ?></option>
							<option value="590x295" <?php echo $size == '590x295' ? 'selected' : ''; ?> > <?php echo html_escape($this->lang->line('ltr_prebuild_temp_twit_promoted')); ?></option>    
							<option value="300x250" <?php echo $size == '300x250' ? 'selected' : ''; ?> > <?php echo html_escape($this->lang->line('ltr_prebuild_temp_adword_md')); ?></option>    
							<option value="336x280" <?php echo $size == '336x280' ? 'selected' : ''; ?> > <?php echo html_escape($this->lang->line('ltr_prebuild_temp_adword_lg')); ?></option>    
							<option value="728x90" <?php echo $size == '728x90' ? 'selected' : ''; ?> > <?php echo html_escape($this->lang->line('ltr_prebuild_temp_adword_leader')); ?></option>
							<option value="250x250" <?php echo $size == '250x250' ? 'selected' : ''; ?> > <?php echo html_escape($this->lang->line('ltr_prebuild_temp_adword_250')); ?></option>                           
							<option value="300x600" <?php echo $size == '300x600' ? 'selected' : ''; ?> > <?php echo html_escape($this->lang->line('ltr_prebuild_temp_adword_300')); ?></option>                           
						</optgroup>
						<optgroup label="Website Headers">
							<option value="1920x250" <?php echo $size == '1920x250' ? 'selected' : ''; ?> > <?php echo html_escape($this->lang->line('ltr_prebuild_temp_web_head')); ?></option>
						</optgroup>
						<optgroup label="Miscellaneous">
							<option value="1920x1080" <?php echo $size == '1920x1080' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_prebuild_temp_web_banner')); ?></option>
						</optgroup>
					</select>
				</div>
			<?php } ?>
			<div class="pg-template-filter">
				<p> <?php echo html_escape($this->lang->line('ltr_prebuild_temp_sort_by')); ?></p>
				<select class="get_template_sub_cat">
					<option value="all"> <?php echo html_escape($this->lang->line('ltr_prebuild_temp_sort_by_all')); ?></option>
					<?php for($sc=0;$sc<count($subcat);$sc++){ ?>
						<option value="<?php echo $subcat[$sc]['sub_cat_id']; ?>"><?php echo $subcat[$sc]['name']; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="pg-template-filter pg-input-holder pg-search-filter">
				<p> <?php echo html_escape($this->lang->line('ltr_prebuild_temp_search_by')); ?></p>
				<input type="text" Placeholder="Template name" id="ed_search_template_nm" >
				<span class="pg-search-filter-icon search"></span>
			</div>
		</div>

		<div class="pg-selected-category-wrap">
			<h3 class="pg-selected-category-title"></h3>
		</div>
		
		<!-- Empty Container  -->
		<?php if(isset($total) && $total == 0){ ?>
		<div class="pg-empty-campain-wrap">
			<div class="pg-empty-campain">
				<span class="pg-empty-icon">
					<img src="<?php echo base_url(); ?>assets/images/empty-folder.png" alt="">
				</span>
				<h3> <?php echo html_escape($this->lang->line('ltr_prebuild_temp_no_temp_title')); ?></h3>
				<p> <?php echo html_escape($this->lang->line('ltr_prebuild_temp_no_temp_desc')); ?></p>
				<a href="#user-prebuild-existing-template" class="pg-popup-link pg-btn pg-btn-lg mt-3"> <?php echo html_escape($this->lang->line('ltr_prebuild_temp_no_temp_btn')); ?></a>
			</div>
		</div>
		<?php return ''; } ?>

		<div class="pg-template-conteiner pg-append-template-row">
			<?php if(count($templates)){ ?>
				<?php for($i=0;$i<count($templates);$i++){ ?>
					<div class="pg-template-box">
						<div class="pg-template-box-inner">
							<div class="pg-template-thumb">
								<img src="<?php echo $templates[$i]['thumb'] !=  '' ? base_url() . $templates[$i]['thumb'] : base_url() . 'assets/images/'.($templates[$i]['template_size'] == '628x628' ? 'empty_campaign.jpg' : 'empty_campaign_long.jpg'); ?>" alt="">
								<?php if(!(isset($use) && $use)){ ?>
									<a href="" class="pg-template-status" title="<?php echo empty($templates[$i]['template_name']) ? 'Unnamed' : $templates[$i]['template_name']; ?>">
										<span class="pg-template-status-center">
											<span class="pg-btn ed_open_image" data-mfp-src="<?php echo $templates[$i]['thumb'] != '' ? base_url() . $templates[$i]['thumb'] : base_url() . 'assets/images/empty_campaign.jpg'; ?>"> <?php echo html_escape($this->lang->line('ltr_prebuild_temp_view_temp_btn')); ?></span>
											<span data-mfp-src="#user-prebuild-existing-template" class="pg-btn pg-popup-link" data-template_userID="<?php echo $templates[$i]['user_id']; ?>" data-get_template_id="<?php echo $templates[$i]['template_id']; ?>"><?php echo html_escape($this->lang->line('ltr_prebuild_temp_use_temp')); ?></span>
										</span>
									</a>
								<?php }else{ ?>
									<a href="<?php echo base_url() . 'campaign/use_template/'.$templates[$i]['user_id'].'/'.$templates[$i]['template_id']; ?>" class="pg-template-status">
										<span class="pg-template-status-center">
											<span class="pg-btn use_temp_btn"> <?php echo html_escape($this->lang->line('ltr_prebuild_temp_use_this')); ?></span>
										</span>
									</a>
								<?php } ?>
							</div>
							<div class="pg-camp-content">
								<h3><?php echo empty($templates[$i]['template_name']) ? 'Unnamed' : $templates[$i]['template_name']; ?></h3>
								<p> <?php echo html_escape($this->lang->line('ltr_prebuild_temp_created_at')); ?> <?php echo date( 'd-m-Y', strtotime($templates[$i]['datetime']) ); ?></p>
							</div>
						</div>
					</div>					
				<?php } ?>
			<?php } ?>
		</div>

		<!-- Load More Button  -->
		<div class="pg-load-more-wrap">
			<a class="pg-btn pg-load-more-btn hide" data-size="<?php echo $size; ?>" data-use="<?php echo isset($use) && $use ? true : false; ?>"> <?php echo html_escape($this->lang->line('ltr_prebuild_temp_load_more')); ?></a>
		</div>
	</div>
</div>

<!-- Social Modal  --> 
<div id="imgShareModal" class="pg-modal-wrapper">
	<div class="pg-modal-inner-row">
		<div class="pg-modal-title-wrap">
			<h3>Share Image</h3>
		</div>
		<div class="pg-modal-body">
			<div class="pxg-share-img-box">
				<div class="pxg-social-links mb-3">
					<ul class="justify-content-center">
						<li>
							<a href="javascript:void(0);" title="Facebook" class="pxg_share_facebook share_post_images" template_url="">
								<svg version="1.1" x="0" y="0" viewBox="0 0 155.139 155.139" xml:space="preserve" class=""><g><path d="M89.584 155.139V84.378h23.742l3.562-27.585H89.584V39.184c0-7.984 2.208-13.425 13.67-13.425l14.595-.006V1.08C115.325.752 106.661 0 96.577 0 75.52 0 61.104 12.853 61.104 36.452v20.341H37.29v27.585h23.814v70.761h28.48z" fill="currentColor" data-original="#010002"></path></g></svg>
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" title="Twitter" class="pxg_share_twitter share_post_images" template_url="">
								<svg version="1.1" x="0" y="0" viewBox="0 0 512 512" xml:space="preserve"><g><path d="M512 97.248c-19.04 8.352-39.328 13.888-60.48 16.576 21.76-12.992 38.368-33.408 46.176-58.016-20.288 12.096-42.688 20.64-66.56 25.408C411.872 60.704 384.416 48 354.464 48c-58.112 0-104.896 47.168-104.896 104.992 0 8.32.704 16.32 2.432 23.936-87.264-4.256-164.48-46.08-216.352-109.792-9.056 15.712-14.368 33.696-14.368 53.056 0 36.352 18.72 68.576 46.624 87.232-16.864-.32-33.408-5.216-47.424-12.928v1.152c0 51.008 36.384 93.376 84.096 103.136-8.544 2.336-17.856 3.456-27.52 3.456-6.72 0-13.504-.384-19.872-1.792 13.6 41.568 52.192 72.128 98.08 73.12-35.712 27.936-81.056 44.768-130.144 44.768-8.608 0-16.864-.384-25.12-1.44C46.496 446.88 101.6 464 161.024 464c193.152 0 298.752-160 298.752-298.688 0-4.64-.16-9.12-.384-13.568 20.832-14.784 38.336-33.248 52.608-54.496z" fill="currentColor" data-original="#000000"></path></g></svg>
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" title="WhatsApp" class="pxg_share_whatsapp share_post_images" template_url="">
								<svg version="1.1" x="0" y="0" viewBox="0 0 24 24" xml:space="preserve"><g><path d="m17.507 14.307-.009.075c-2.199-1.096-2.429-1.242-2.713-.816-.197.295-.771.964-.944 1.162-.175.195-.349.21-.646.075-.3-.15-1.263-.465-2.403-1.485-.888-.795-1.484-1.77-1.66-2.07-.293-.506.32-.578.878-1.634.1-.21.049-.375-.025-.524-.075-.15-.672-1.62-.922-2.206-.24-.584-.487-.51-.672-.51-.576-.05-.997-.042-1.368.344-1.614 1.774-1.207 3.604.174 5.55 2.714 3.552 4.16 4.206 6.804 5.114.714.227 1.365.195 1.88.121.574-.091 1.767-.721 2.016-1.426.255-.705.255-1.29.18-1.425-.074-.135-.27-.21-.57-.345z" fill="currentColor" data-original="#000000"></path><path d="M20.52 3.449C12.831-3.984.106 1.407.101 11.893c0 2.096.549 4.14 1.595 5.945L0 24l6.335-1.652c7.905 4.27 17.661-1.4 17.665-10.449 0-3.176-1.24-6.165-3.495-8.411zm1.482 8.417c-.006 7.633-8.385 12.4-15.012 8.504l-.36-.214-3.75.975 1.005-3.645-.239-.375c-4.124-6.565.614-15.145 8.426-15.145a9.865 9.865 0 0 1 7.021 2.91 9.788 9.788 0 0 1 2.909 6.99z" fill="currentColor" data-original="#000000"></path></g></svg>
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" title="LinkedIn" class="pxg_share_linkedin share_post_images" template_url="">
								<svg version="1.1" x="0" y="0" viewBox="0 0 100 100" xml:space="preserve"><g><path d="M90 90V60.7c0-14.4-3.1-25.4-19.9-25.4-8.1 0-13.5 4.4-15.7 8.6h-.2v-7.3H38.3V90h16.6V63.5c0-7 1.3-13.7 9.9-13.7 8.5 0 8.6 7.9 8.6 14.1v26H90zM11.3 36.6h16.6V90H11.3zM19.6 10c-5.3 0-9.6 4.3-9.6 9.6s4.3 9.7 9.6 9.7 9.6-4.4 9.6-9.7-4.3-9.6-9.6-9.6z" fill="currentColor" data-original="#000000"></path></g></svg>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div> 
	 </div> 
</div>


<!-- Modal  -->
<div id="user-prebuild-existing-template" class="pg-modal-wrapper mfp-hide">
    <div class="pg-modal-inner-row">
        <div class="pg-modal-title-wrap">
            <h3> <?php echo html_escape($this->lang->line('ltr_prebuild_temp_create_new')); ?></h3>
        </div>
        <div class="pg-modal-body">
			<div class="pg-input-holder">
				<?php if(isset($campaigns) && !empty($campaigns)){ ?>
					<label> <?php echo html_escape($this->lang->line('ltr_prebuild_temp_select_web')); ?></label>
					<select id="campaign_id" class="form-control ed_campaign_select_chng">
						<option value=""> <?php echo html_escape($this->lang->line('ltr_prebuild_temp_create_web')); ?></option>
						<?php foreach($campaigns as $cam){ ?>
							<option value="<?php echo $cam['campaign_id']; ?>"><?php echo $cam['name']; ?></option>
						<?php } ?>
					</select>
				<?php } ?>
				<label> <?php echo html_escape($this->lang->line('ltr_prebuild_temp_web_name')); ?></label>
				<input type="text"  value="" placeholder="Website Name" id="campaign_name">
            </div>
            <div class="pg-input-holder">
                <label><?php echo html_escape($this->lang->line('ltr_prebuild_temp_img_name')); ?></label>
                <input type="text"  value="" id="template_name">
            </div>
			<div class="custom_html_size"></div>
            <div class="pg-modal-btn-wrap">
				<input type="hidden" id="template_userID" value="">
				<input type="hidden" id="get_template_id" value="">
				<input type="hidden" id="m_template_size" value="<?php echo $size; ?>">
                <a href="#" class="pg-btn pg-btn-lg" id="ed_create_template"> <?php echo html_escape($this->lang->line('ltr_prebuild_temp_create_btn')); ?></a> 
            </div>
        </div> 
    </div>
</div>