<div class="pg-screen-container pg-import-wrap pg-dwnld-assets-wrapper">
    <?php 
	$curl = curl_init();
    curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://app.pixaguru.com/Import_export_template/download_template_option',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
	));
    $response = curl_exec($curl);
    curl_close($curl);
	$data_load = json_decode($response,true);
	if($data_load){
		foreach($data_load as $getoption){
		    echo $getoption;
		}
	}
    ?>
</div>
<div class="pg-note">
	<p>
	 <?php echo html_escape($this->lang->line('ltr_import_note')); ?> <a href="https://app.pixaguru.com/documentation/" target="_blank"><?php echo html_escape($this->lang->line('ltr_import_doc_link')); ?></a>
	</p>				
</div>
<!-- Subscribe Newsletter Modal -->
<div id="subscribe_newsletter_popup" class="pg-modal-wrapper mfp-hide">
    <div class="pg-modal-inner-row">
        <div class="pg-modal-title-wrap">
            <h3>Subscribe Newsletter</h3>
        </div>
        <div class="pg-modal-body">
            <div class="pg-input-holder">
                <label>Your Name</label>
                <input type="text"  value="" id="user_name" name="user_name">
            </div>
            <div class="pg-input-holder">
                <label>Your Email</label>
                <input type="text"  value="" id="user_email" name="user_email">
				<div class="error_images"></div>
            </div>
            <div class="pg-modal-btn-wrap">
			  <a href="" class="pg-btn pg-btn-lg" id="subscribe_newsletter">
			   Subscribe Now
			  </a> 
            </div>
        </div> 
    </div>
</div>