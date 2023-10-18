<div class="pg-screen-container">
    <div class="pg-page-title-head">
        <h3>
        <?php echo html_escape($this->lang->line('ltr_admin_templ_total_image')); ?> (<?php echo html_escape($tot_A[0]['total']); ?>)  
            <p class="pg-imgs-status">
                <span><?php echo html_escape($this->lang->line('ltr_admin_templ_active')); ?> <span><?php echo html_escape($tot_A[0]['total']); ?></span> </span>
                <span><?php echo html_escape($this->lang->line('ltr_admin_templ_inactive')); ?> <span><?php echo html_escape($tot_I[0]['total']); ?> </span></span>
            </p>
        </h3>
        <a href="#create_new_popup" class="pg-popup-link pg-btn"><?php echo html_escape($this->lang->line('ltr_admin_templ_create_new')); ?></a>
    </div> 
    <div class="pg-content-wrapper">
        <?php $size_key = array_column($template_size_count, 'template_size'); ?>				
        <div class="pg-template-filter-wrapper">
            <div class="pg-template-filter pg-template-filter-admin">                            
                <select class="pg-input" id="move_other_size">                
                    <optgroup label="WordPress Theme Preview">
                        <option value="1200x885" <?php echo html_escape($size) == '1200x885' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_templ_thumbnail_1200_885')); ?> (<?php $k = array_search('1200x885', $size_key); if(!empty($template_size_count[$k]['tot'])): echo $template_size_count[$k]['tot']; endif; ?>)</option>
                        <option value="1200x1200" <?php echo html_escape($size) == '1200x1200' ? 'selected' : ''; ?> > <?php echo html_escape($this->lang->line('ltr_admin_templ_thumbnail_squre_1200_1200')); ?> (<?php $k = array_search('1200x1200', $size_key); if(!empty($template_size_count[$k]['tot'])): echo $template_size_count[$k]['tot']; endif; ?>)</option>
                    </optgroup>
                    <optgroup label="Social Media">
                        <option value="940x940" <?php echo html_escape($size) == '940x940' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_templ_facebook_post_940_940')); ?>(<?php $k = array_search('940x940', $size_key); if(!empty($template_size_count[$k]['tot'])): echo $template_size_count[$k]['tot']; endif; ?>)</option>
                        <option value="628x628" <?php echo html_escape($size) == '628x628' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_templ_facebook_squre_628_628')); ?>(<?php $k = array_search('628x628', $size_key); if(!empty($template_size_count[$k]['tot'])): echo $template_size_count[$k]['tot']; endif; ?>)</option>
                        <option value="1080x1080" <?php echo html_escape($size) == '1080x1080' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_templ_instagram_post_1080_1080')); ?>(<?php $k = array_search('1080x1080', $size_key); if(!empty($template_size_count[$k]['tot'])): echo $template_size_count[$k]['tot']; endif; ?>)</option>
                        <option value="735x1102" <?php echo html_escape($size) == '735x1102' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_templ_pinterest_pins_735_1102')); ?>(<?php $k = array_search('735x1102', $size_key); if(!empty($template_size_count[$k]['tot'])): echo $template_size_count[$k]['tot']; endif; ?>)</option>
                        <option value="1024x512" <?php echo html_escape($size) == '1024x512' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_templ_twitter_post_1024_512')); ?>(<?php $k = array_search('1024x512', $size_key); if(!empty($template_size_count[$k]['tot'])): echo $template_size_count[$k]['tot']; endif; ?>)</option>
                        <option value="497x373" <?php echo html_escape($size) == '497x373' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_templ_google_post_497_373')); ?> (<?php $k = array_search('497x373', $size_key); if(!empty($template_size_count[$k]['tot'])): echo $template_size_count[$k]['tot']; endif; ?>)</option>
                        <option value="851x315" <?php echo html_escape($size) == '851x315' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_templ_facebook_covers_851_315')); ?>(<?php $k = array_search('851x315', $size_key); if(!empty($template_size_count[$k]['tot'])): echo $template_size_count[$k]['tot']; endif; ?>)</option>
                        <option value="1500x500" <?php echo html_escape($size) == '1500x500' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_templ_twitter_header_1500_500')); ?>(<?php $k = array_search('1500x500', $size_key); if(!empty($template_size_count[$k]['tot'])): echo $template_size_count[$k]['tot']; endif; ?>)</option>
                    </optgroup>
                    <optgroup label="AD Images">
                        <option value="1200x628" <?php echo html_escape($size) == '1200x628' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_templ_facebook_website_conversions_1200_628')); ?>(<?php $k = array_search('1200x628', $size_key); if(!empty($template_size_count[$k]['tot'])): echo $template_size_count[$k]['tot']; endif; ?>)</option>
                        <option value="1200x900" <?php echo html_escape($size) == '1200x900' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_templ_facebook_page_post_engagements_1200_900')); ?>(<?php $k = array_search('1200x900', $size_key); if(!empty($template_size_count[$k]['tot'])): echo $template_size_count[$k]['tot']; endif; ?>)</option>
                        <option value="1200x444" <?php echo html_escape($size) == '1200x444' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_templ_facebook_page_likes_1200_444')); ?>(<?php $k = array_search('1200x444', $size_key); if(!empty($template_size_count[$k]['tot'])): echo $template_size_count[$k]['tot']; endif; ?>)</option>
                        <option value="800x200" <?php echo html_escape($size) == '800x200' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_templ_twitter_lead_gen_card_800_200')); ?>(<?php $k = array_search('800x200', $size_key); if(!empty($template_size_count[$k]['tot'])): echo html_escape($template_size_count[$k]['tot']); endif; ?>)</option>
                        <option value="590x295" <?php echo html_escape($size) == '590x295' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_templ_twitter_promoted_tweet_590_295')); ?>(<?php $k = array_search('590x295', $size_key); if(!empty($template_size_count[$k]['tot'])): echo html_escape($template_size_count[$k]['tot']); endif; ?>)</option>    
                        <option value="300x250" <?php echo html_escape($size) == '300x250' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_templ_adwords_medium_rectangle_300_250')); ?>(<?php $k = array_search('300x250', $size_key); if(!empty($template_size_count[$k]['tot'])): echo $template_size_count[$k]['tot']; endif; ?>)</option>    
                        <option value="336x280" <?php echo html_escape($size) == '336x280' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_templ_adwords_large_rectangle_336_280')); ?>(<?php $k = array_search('336x280', $size_key); if(!empty($template_size_count[$k]['tot'])): echo $template_size_count[$k]['tot']; endif; ?>)</option>    
                        <option value="728x90" <?php echo html_escape($size) == '728x90' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_templ_adwords_leaderboard_728_90')); ?>(<?php $k = array_search('728x90', $size_key); if(!empty($template_size_count[$k]['tot'])): echo $template_size_count[$k]['tot']; endif; ?>)</option>
                        <option value="250x250" <?php echo html_escape($size) == '250x250' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_templ_adwords_250_250')); ?>(<?php $k = array_search('250x250', $size_key); if(!empty($template_size_count[$k]['tot'])): echo $template_size_count[$k]['tot']; endif; ?>)</option>                           
                        <option value="300x600" <?php echo html_escape($size) == '300x600' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_templ_adwords_300_600')); ?>(<?php $k = array_search('300x600', $size_key); if(!empty($template_size_count[$k]['tot'])): echo $template_size_count[$k]['tot']; endif; ?>)</option>                           
                    </optgroup>
                    <optgroup label="Miscellaneous">
                        <option value="1920x1080" <?php echo html_escape($size) == '1920x1080' ? 'selected' : ''; ?> ><?php echo html_escape($this->lang->line('ltr_admin_templ_website_banners_1920_1080')); ?>(<?php $k = array_search('1920x1080', $size_key); if(!empty($template_size_count[$k]['tot'])): echo $template_size_count[$k]['tot']; endif; ?>)</option>
                    </optgroup>
                    <optgroup label="Create Custom size">
                        <option value="create_custom_size">Create Custom size</option>
                    </optgroup>
                </select>
            </div>
            <div class="pg-inactive-filter <?php echo html_escape($active_tem) == '1' ? 'pg-active-tem' : 'pg-inactive-tem'; ?>">                
            <select class="pg-input" id="pg_inactive_active" name="pg_inactive_active">
                <option value="1" <?php echo html_escape($active_tem) == '1' ? 'selected' : ''; ?>>Active</option>    
                <option value="0" <?php echo html_escape($active_tem) == '0' ? 'selected' : ''; ?>>Inactive</option>
            </select> 
            </div>
            <h6> 
                <span>
                    <?php echo html_escape($this->lang->line('ltr_admin_templ_images')); ?>
                    <?php echo html_escape($active_templates[0]['total']) + html_escape($inactive_templates[0]['total']); ?>
                </span> 
                <span>
                    <?php echo html_escape($this->lang->line('ltr_admin_templ_active')); ?>
                    <?php echo html_escape($active_templates[0]['total']); ?>
                </span>
                <span>
                    <?php echo html_escape($this->lang->line('ltr_admin_templ_inactive')); ?>
                    <?php echo html_escape($inactive_templates[0]['total']); ?>
                </span>
            </h6>
        </div>
        <div class="pg-template-conteiner" id="pg-template-conteiner">	
            <?php 
            // echo "<pre>";print_r($templates);
            // die;
            for($i=0;$i<count($templates);$i++){ 
                
            ?>
                <div class="pg-template-box">
                    <div class="pg-template-box-inner <?php echo html_escape($templates[$i]['status']) != 1 ? 'pg-inactive-template' : ''; ?>">
                        <div class="pg-template-thumb">
							<!--- Share Button -->
							<a href="#imgShareModal" class="pxg-img-share-btn pg-popup-link pxg_share_img" data-shareuri="<?php echo html_escape($templates[$i]['thumb']) !=  '' ? base_url() . html_escape($templates[$i]['thumb']) : base_url() . 'assets/images/'.($size == '628x628' ? 'empty_campaign.jpg' : 'empty_campaign_long.jpg'); ?>" data-sharename= "<?php echo $templates[$i]['template_name']; ?>">
								<svg version="1.1" x="0" y="0" viewBox="0 0 512 512" xml:space="preserve"><g><path d="M453.332 85.332c0 38.293-31.039 69.336-69.332 69.336s-69.332-31.043-69.332-69.336C314.668 47.043 345.707 16 384 16s69.332 31.043 69.332 69.332zm0 0" fill="currentColor" data-original="#000000"></path><path d="M384 170.668c-47.063 0-85.332-38.273-85.332-85.336C298.668 38.273 336.938 0 384 0s85.332 38.273 85.332 85.332c0 47.063-38.27 85.336-85.332 85.336zM384 32c-29.418 0-53.332 23.938-53.332 53.332 0 29.398 23.914 53.336 53.332 53.336s53.332-23.938 53.332-53.336C437.332 55.938 413.418 32 384 32zM453.332 426.668C453.332 464.957 422.293 496 384 496s-69.332-31.043-69.332-69.332c0-38.293 31.039-69.336 69.332-69.336s69.332 31.043 69.332 69.336zm0 0" fill="currentColor" data-original="#000000"></path><path d="M384 512c-47.063 0-85.332-38.273-85.332-85.332 0-47.063 38.27-85.336 85.332-85.336s85.332 38.273 85.332 85.336c0 47.059-38.27 85.332-85.332 85.332zm0-138.668c-29.418 0-53.332 23.938-53.332 53.336C330.668 456.063 354.582 480 384 480s53.332-23.938 53.332-53.332c0-29.398-23.914-53.336-53.332-53.336zM154.668 256c0 38.293-31.043 69.332-69.336 69.332C47.043 325.332 16 294.293 16 256s31.043-69.332 69.332-69.332c38.293 0 69.336 31.039 69.336 69.332zm0 0" fill="currentColor" data-original="#000000"></path><path d="M85.332 341.332C38.273 341.332 0 303.062 0 256s38.273-85.332 85.332-85.332c47.063 0 85.336 38.27 85.336 85.332s-38.273 85.332-85.336 85.332zm0-138.664C55.914 202.668 32 226.602 32 256s23.914 53.332 53.332 53.332c29.422 0 53.336-23.934 53.336-53.332s-23.914-53.332-53.336-53.332zm0 0" fill="currentColor" data-original="#000000"></path><path d="M135.703 245.762c-7.426 0-14.637-3.864-18.562-10.774-5.825-10.218-2.239-23.254 7.98-29.101l197.95-112.852c10.218-5.867 23.253-2.281 29.1 7.977 5.825 10.218 2.24 23.254-7.98 29.101L146.238 242.965a21.195 21.195 0 0 1-10.535 2.797zM333.633 421.762c-3.586 0-7.211-.899-10.54-2.797L125.142 306.113c-10.22-5.824-13.801-18.86-7.977-29.101 5.8-10.239 18.856-13.844 29.098-7.977l197.953 112.852c10.219 5.824 13.8 18.86 7.976 29.101-3.945 6.91-11.156 10.774-18.558 10.774zm0 0" fill="currentColor" data-original="#000000"></path></g></svg>
							</a>
                            <img src="<?php echo html_escape($templates[$i]['thumb']) !=  '' ? base_url() . html_escape($templates[$i]['thumb']) : base_url() . 'assets/images/'.($size == '628x628' ? 'empty_campaign.jpg' : 'empty_campaign_long.jpg'); ?>" alt="">
                            <a href="<?php echo base_url(). 'editor/admin_edit/',html_escape($templates[$i]['template_id']); ?>" class="pg-template-status">
                                <div class="pg-switch">
                                    <input type="checkbox" id="temp_switch<?php echo $templates[$i]['template_id']; ?>" data-template_id="<?php echo html_escape($templates[$i]['template_id']); ?>" value="<?php echo $templates[$i]['status']; ?>" class="ed_template_status_update" <?php echo $templates[$i]['status'] != 1 ? '' : 'checked'; ?>>
                                    <label for="temp_switch<?php echo html_escape($templates[$i]['template_id']); ?>"></label>
                                </div>
                                <span class="pg-template-status-center">
                                    <span><svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 477.873 477.873"><g><path d="M392.533 238.937c-9.426 0-17.067 7.641-17.067 17.067V426.67c0 9.426-7.641 17.067-17.067 17.067H51.2c-9.426 0-17.067-7.641-17.067-17.067V85.337c0-9.426 7.641-17.067 17.067-17.067H256c9.426 0 17.067-7.641 17.067-17.067S265.426 34.137 256 34.137H51.2C22.923 34.137 0 57.06 0 85.337V426.67c0 28.277 22.923 51.2 51.2 51.2h307.2c28.277 0 51.2-22.923 51.2-51.2V256.003c0-9.425-7.641-17.066-17.067-17.066z" /><path d="M458.742 19.142A65.328 65.328 0 0 0 412.536.004a64.85 64.85 0 0 0-46.199 19.149L141.534 243.937a17.254 17.254 0 0 0-4.113 6.673l-34.133 102.4c-2.979 8.943 1.856 18.607 10.799 21.585 1.735.578 3.552.873 5.38.875a17.336 17.336 0 0 0 5.393-.87l102.4-34.133c2.515-.84 4.8-2.254 6.673-4.13l224.802-224.802c25.515-25.512 25.518-66.878.007-92.393zm-24.139 68.277L212.736 309.286l-66.287 22.135 22.067-66.202L390.468 43.353c12.202-12.178 31.967-12.158 44.145.044a31.215 31.215 0 0 1 9.12 21.955 31.043 31.043 0 0 1-9.13 22.067z" /></g></svg></span>
                                </span>
                            </a>
                            <div class="pg-camp-options">
                                <ul>
                                    <li>
                                        <a href="<?php echo base_url() . 'admin/get_popup/tduplicate/'.$templates[$i]['template_id']; ?>" title="Duplicate" class="pg-edit-user-link" >
                                            <img src="<?php echo base_url(); ?>assets/images/admin/copy.svg" alt="copy">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url() . 'admin/get_popup/template/'.html_escape($templates[$i]['template_id']); ?>" title="Rename" class="pg-edit-user-link">
                                            <img src="<?php echo base_url(); ?>assets/images/admin/rename.svg" alt="">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo html_escape($templates[$i]['thumb']) !=  '' ? base_url() . html_escape($templates[$i]['thumb']) : base_url() . 'assets/images/'.($size == '628x628' ? 'empty_campaign.jpg' : 'empty_campaign_long.jpg'); ?>" title="View Template" class="ed_open_image">
                                            <img src="<?php echo base_url(); ?>assets/images/admin/view.svg" alt="">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="" title="Delete" class="template_action" data-action="delete" data-template_id="<?php echo html_escape($templates[$i]['template_id']); ?>">
                                            <img src="<?php echo base_url(); ?>assets/images/admin/delete.svg" alt="delete">
                                        </a>
                                    </li>
                                    <li>
										<a href="#embed_model_popup" title="Embed" class="pg-popup-link open_embed" data-template_name="<?php echo $templates[$i]['template_name']; ?>" data-embed_url="<?php echo base_url().'/embed/template/'.base64_encode($templates[$i]['template_id']); ?>" data-template_id="<?php echo base64_encode($templates[$i]['template_id']); ?>">
											<img src="<?php echo base_url(); ?>assets/images/admin/embed.svg" alt="embed">
										</a>
									</li> 
                                </ul> 
                            </div>
                        </div>
                        <div class="pg-camp-content">
                            <h3><?php echo $templates[$i]['template_name']; ?></h3>
                            <p><?php echo html_escape($this->lang->line('ltr_admin_templ_created_at')); ?> <?php echo date('d/m/Y',strtotime($templates[$i]['datetime'])); ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="col-md-12">
            <div class="pg-load-more-wrap">
                <a class="pg-btn pg-load-more-btn" data-size="<?php echo html_escape($size); ?>"><?php echo html_escape($this->lang->line('ltr_admin_templ_view_more')); ?></a>
            </div>
        </div>
    </div>
</div>

<!-- Embed Model Start-->
<div id="embed_model_popup" class="pg-modal-wrapper">
    <div class="pg-modal-inner-row">
        <div class="pg-modal-title-wrap">
            <h3>Embed Model</h3>
        </div>
        <div class="pg-modal-body">
            <div class="pg-sidebar-input pg-embed-copy">
            <input type="text" id="pg_embed_code"name="pg_embed_code">
            <span id="ai_text_copy"> 
                <svg x="0" y="0" viewBox="0 0 32 32" title="Copy Text" style="enable-background:new 0 0 512 512"><g><path d="M26.572 2.16H9.698A3.266 3.266 0 0 0 6.44 5.428v1.011H5.418A3.267 3.267 0 0 0 2.16 9.71v16.863a3.266 3.266 0 0 0 3.258 3.268h16.874a3.271 3.271 0 0 0 3.268-3.268v-1.011h1.012a3.272 3.272 0 0 0 3.268-3.269V5.428a3.272 3.272 0 0 0-3.268-3.268zM23.56 26.572c0 .7-.569 1.268-1.268 1.268H5.417a1.264 1.264 0 0 1-1.257-1.268V9.708c0-.7.564-1.269 1.257-1.269h16.875c.7 0 1.268.57 1.268 1.269V24.56zm4.28-4.28c0 .7-.569 1.269-1.268 1.269H25.56V9.708a3.272 3.272 0 0 0-3.268-3.269H8.44V5.428c0-.7.564-1.268 1.258-1.268h16.874c.7 0 1.268.568 1.268 1.268z"/></g></svg>
            </span>
            </div>
        </div> 
     </div> 
</div>
<!-- Embed Model Close-->

<!-- Create Modal for Template  -->
<div id="create_new_popup" class="pg-modal-wrapper mfp-hide">
    <div class="pg-modal-inner-row">
        <div class="pg-modal-title-wrap">
            <h3><?php echo html_escape($this->lang->line('ltr_admin_templ_create_new_image')); ?></h3>
        </div>
        <div class="pg-modal-body">
            <div class="pg-input-holder">
                <label><?php echo html_escape($this->lang->line('ltr_admin_templ_image_name')); ?></label>
                <input type="text"  value="" id="template_name">
            </div>
            <div class="pg-input-holder">
                <label><?php echo html_escape($this->lang->line('ltr_admin_templ_select_size')); ?></label>
                <select  id="template_size">
                    <optgroup label="WordPress Theme Preview">
                        <option value="1200x885"><?php echo html_escape($this->lang->line('ltr_admin_templ_thumbnail_1200_885')); ?></option>
                        <option value="1200x1200"> <?php echo html_escape($this->lang->line('ltr_admin_templ_thumbnail_squre_1200_1200')); ?></option>
                    </optgroup>
                    <optgroup label="Social Media">
                        <option value="940x940"><?php echo html_escape($this->lang->line('ltr_admin_templ_facebook_post_940_940')); ?></option>
                        <option value="735x1102"><?php echo html_escape($this->lang->line('ltr_admin_templ_pinterest_pins_735_1102')); ?></option>
                        <option value="1024x512"><?php echo html_escape($this->lang->line('ltr_admin_templ_twitter_post_1024_512')); ?></option>
                        <option value="497x373"><?php echo html_escape($this->lang->line('ltr_admin_templ_google_post_497_373')); ?></option>
                        <option value="851x315"><?php echo html_escape($this->lang->line('ltr_admin_templ_facebook_covers_851_315')); ?></option>
                        <option value="1500x500"><?php echo html_escape($this->lang->line('ltr_admin_templ_twitter_header_1500_500')); ?></option>
                    </optgroup>
                    <optgroup label="AD Images">
                        <option value="1200x628"><?php echo html_escape($this->lang->line('ltr_admin_templ_facebook_website_conversion_1200_628')); ?></option>
                        <option value="1200x900"><?php echo html_escape($this->lang->line('ltr_admin_templ_facebook_page_post_engagements_1200_900')); ?></option>
                        <option value="1200x444"><?php echo html_escape($this->lang->line('ltr_admin_templ_facebook_page_likes_1200_444')); ?></option>
                        <option value="800x200"><?php echo html_escape($this->lang->line('ltr_admin_templ_twitter_lead_gen_card_800_200')); ?></option>
                        <option value="590x295"><?php echo html_escape($this->lang->line('ltr_admin_templ_twitter_promoted_tweet_590_295')); ?></option>    
                        <option value="300x250"><?php echo html_escape($this->lang->line('ltr_admin_templ_adwords_medium_rectangle_300_250')); ?></option>    
                        <option value="336x280"><?php echo html_escape($this->lang->line('ltr_admin_templ_adwords_large_rectangle_336_280')); ?></option>    
                        <option value="728x90"><?php echo html_escape($this->lang->line('ltr_admin_templ_adwords_leaderboard_728_90')); ?></option>
                        <option value="250x250"><?php echo html_escape($this->lang->line('ltr_admin_templ_adwords_250_250')); ?></option>                           
                        <option value="300x600"><?php echo html_escape($this->lang->line('ltr_admin_templ_adwords_300_600')); ?></option>                           
                    </optgroup>
                    <optgroup label="Website Headers">
                        <option value="1920x250"><?php echo html_escape($this->lang->line('ltr_admin_templ_website_headers_1920_250')); ?></option>
                    </optgroup>
                    <optgroup label="Miscellaneous">
                        <option value="1920x1080"><?php echo html_escape($this->lang->line('ltr_admin_templ_gift_certificate_1920_1080')); ?></option>
                    </optgroup>
                    <optgroup label="Create Custom size">
                        <option value="create_custom_size">Create Custom size</option>
                    </optgroup>
                </select>
            </div>
            <div class="pg-input-holder" id="template_custom_size">
                <label>Custom Template Width</label>
                <input type="number" id="template_width" name="template_width">
                <label>Custom Template Height</label>
                <input type="number" id="template_height" name="template_height">
            </div>
            <div class="pg-input-holder">
                <label><?php echo html_escape($this->lang->line('ltr_admin_templ_select_category')); ?></label>
                <?php
                $sub_cat = $this->Common_DML->get_data( 'sub_category');
                ?>
                <select  id="sub_category_id">
                <?php
                if($sub_cat){
                 foreach($sub_cat as $cat){
                ?>
                <option value="<?php if(isset($cat['sub_cat_id'])): 
                                 echo html_escape($cat['sub_cat_id']); 
                                 endif; ?>">
                <?php if(isset($cat['name'])): echo html_escape($cat['name']); endif; ?></option>
                <?php 
                    }
                }
                ?>
                </select>
            </div>
            <div class="pg-modal-btn-wrap">
                <a href="" class="pg-btn pg-btn-lg" id="create_template"><?php echo html_escape($this->lang->line('ltr_admin_templ_modal_btn')); ?></a> 
            </div>
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