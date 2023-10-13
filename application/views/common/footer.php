			</div>
		</div>
		<!-- main wrapper end -->
		<?php
			if(isset($_GET['msg']) && $_GET['msg'] == 1){
				echo '<script>';
				echo 'var profile_update = 1;';
				echo '</script>';
			}
		?>
		<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
		<input type="hidden" id="user_id" value="<?php echo $this->session->userdata( 'user_id' ); ?>">
		<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>				
		<script src="<?php echo base_url(); ?>assets/js/bootstrap-colorpicker.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/jquery.toaster.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/jquery.magnific-popup.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/datatables.min.js"></script> 
		<script src="<?php echo base_url(); ?>assets/js/main.js?q=<?= date('is') ?>"></script>	
		<script> 
		/**
		 * Color Switcher
		 */ 
		const elements = document.getElementsByClassName('pg_colormode_checkbox');
		for (let i = 0; i < elements.length; i++) {
			const element = elements[i];
			// Perform actions on the element
			let drag_style = "<?php echo base_url(); ?>assets/css/dark-style.css?q=1";
			element.addEventListener('change', function() {
				if (this.checked) {
					document.getElementById('drag_mode').href=drag_style;
					localStorage.setItem('drag_mode_onoff', 1);
				} else {
					document.getElementById('drag_mode').href='#';
					localStorage.setItem('drag_mode_onoff', 0);
				}
			});
			const checkmode = localStorage.getItem('drag_mode_onoff');
			if(checkmode == 1){
				document.getElementById('drag_mode').href=drag_style;
				elements[0].checked = true;
			}else{
				document.getElementById('drag_mode').href='#';
				elements[0].checked = false;
			}
		} 
       </script>
	   <?php 
		/**
		 * Google Analytics Script
		 */
		$where = array('data_key' =>'google_analytics_footer_script');
		$result_header_script = $this->Common_DML->get_data( 'theme_setting', $where);
		if(!empty($result_header_script[0]['data_value'])):
			echo $result_header_script[0]['data_value'];
		endif;
		?> 
	</body>
</html>