<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo html_escape($this->lang->line('ltr_subscribe_plan_page_title')); ?></title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
       <!-- Script fonts (Google Fonts Calling) -->
        <link href="<?php echo base_url(); ?>assets/css/fonts.css" rel="stylesheet">
        <link rel="shortcut icon" type="image/ico" href="<?php echo base_url(); ?>assets/images/favicon.png" />
	    <link rel="icon" type="image/ico" href="<?php echo base_url(); ?>assets/images/favicon.png" />
		<!-- Bootstrap Bundle -->
		<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <!-- Favicon  -->
        <link rel="icon" type="image/ico" href="<?php echo base_url(); ?>assets/images/favicon.png" />
		<!-- Custom Style  -->
        <link href="<?php echo base_url(); ?>assets/css/frontend.css" rel="stylesheet">
	</head>
	<body class="pg-front-page">
		 <!-- Preloader  -->
         <div class="pg-preloader-wrap">
            <div class="pg-preloader">
                <img src="<?php echo base_url(); ?>assets/images/preloader.gif" alt="">
            </div>
        </div>
        <div class="pg-subscription-plan-wrap">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="pg-section-tilte">
                            <h2><?php echo html_escape($this->lang->line('ltr_subscribe_plan_title')); ?></h2>
                        </div>
                    </div> 
                    <?php 
                    $pl_price = 0;
                    $i=1;
                    if(!empty($subscription_plans)){
                    foreach($subscription_plans as $plans){  
                        
                        $pl_price = $plans['pl_price'];
                       
                    ?>
                    <div class="col-xxl-3 col-xl-4 col-lg-4 col-12">
                        <div class="pg-plan-box">
                            <div class="pg-plan-box-body">
                            <?php 
                            if(!empty($plans['pl_name'])):
                                $pl_name = $plans['pl_name'];
                            ?>
                                <div class="pg-plan-head">
                                    <h5 class="pg-plan-title"><?php echo html_escape($plans['pl_name']); ?></h5>
                                </div>
                                <?php endif; 
                                    if(!empty($plans['pl_name'])):
                                    ?>
                                    <h6 class="pg-plan-detail">
                                        <span class="pg-amount">
                                            <?php
                                            echo html_escape($currency_sym[$plans['pl_currency']]);  echo html_escape($pl_price);?>
                                        </span>
                                        <span class="period">/
                                            <?php 
                                            if($plans['interval'] == '7'){
                                            echo html_escape($plan_interval= "week");
                                            }elseif($plans['interval'] == '31'){
                                            echo html_escape($plan_interval= "month");
                                            }elseif($plans['interval'] == '365'){
                                            echo html_escape($plan_interval= "year");
                                            }
                                        ?></span>
                                    </h6>
                                    <div class="pg-plan-detailed-info">
                                        <?php 
                                         echo html_entity_decode($plans['plan_description']);
                                          
                                        ?>
                                    </div>
                            
                            <a href="javascript:void(0);" open-modal="create_user_popup_<?php echo $i; ?>" class="pg-btn"><?php echo html_escape($this->lang->line('ltr_subscribe_plan_modal_btn')); ?></a>
                            <!-- Pixaguru Modal Start -->
                            <div id="create_user_popup_<?php echo $i; ?>" class="custom-modal">
                                <div class="custom-modal-dialog">
                                    <div class="custom-modal-content">
                                    <span class="close-modal" close-modal>X</span>
                                        <div class="custom-modal-body">
                                            <div class="custom-modal-inner">
                                                <!-- Contetn here -->
                                                    <?php 
                                                    if($pl_price == 0.00 || $pl_price == 0){
                                                    ?>
                                                    <form action="<?php print site_url();?>authentication/create_free_subscription" method="post" class="frmStripePayment">
                                                    <?php }else{ ?>   
                                                    <form action="<?php print site_url();?>authentication/create_subscription" method="post" class="frmStripePayment">
                                                    <?php } ?>
                                                    <div class="pg-input-holder">
                                                       <label for="user_name_<?php echo $plans['pl_id']; ?>"><?php echo html_escape($this->lang->line('ltr_subscribe_plan_form_name')); ?></label>
                                                       <input type="text"  value="" id="user_name_<?php echo $plans['pl_id']; ?>" name="user_name" class="pg-changes-user">
                                                    </div> 
                                                    <?php 
                                                   
                                                    if($pl_price == 0.00 || $pl_price == 0){
                                                    ?>
                                                    <div class="pg-input-holder">
                                                        <label for="user_send_mail_<?php echo $plans['pl_id']; ?>">Email</label>
                                                        <input type="email" id="user_send_mail_<?php echo $plans['pl_id']; ?>" value="" class="ed_manage_email" name="user_send_mail">
                                                    </div> 
                                                    <?php 
                                                    }
                                                    ?>
                                                    <div class="pg-input-holder">
                                                        <label for="user_password_<?php echo $plans['pl_id']; ?>"><?php echo html_escape($this->lang->line('ltr_subscribe_plan_form_pws')); ?></label>
                                                        <input type="password"  value="" id="user_password_<?php echo $plans['pl_id']; ?>" name="user_password" class="pg-changes-pass"> 
                                                    </div>
                                                    <div class="pg-input-holder">
                                                        <div class="pg-checkbox">
                                                            <input type="checkbox" id="send_user_detail_<?php echo $plans['pl_id']; ?>" checked="" value="1" class="ed_manage_user" name="send_mail">
                                                            <label for="send_user_detail_<?php echo $plans['pl_id']; ?>"><?php echo html_escape($this->lang->line('ltr_subscribe_plan_form_email')); ?></label> 
                                                        </div>
                                                    </div> 
                                                    <div class="pg-input-holder">
                                                        <label for="coupnCode_<?php echo $plans['pl_id']; ?>"><?php echo html_escape($this->lang->line('ltr_subscribe_plan_coupn_lable')); ?></label>
                                                        <div class="pg-input-has-btn">
                                                            <input type="text"  value="" id="coupnCode_<?php echo $plans['pl_id']; ?>" name="coupon_code">
                                                            <a href="javascript:void(0);" class="pg-btn apply_coupon_code" data-coupon_id="coupnCode_<?php echo $plans['pl_id']; ?>"><?php echo html_escape($this->lang->line('ltr_subscribe_plan_coupn_btn')); ?></a>
                                                        </div>
                                                    </div>
                                                    <div class="pg-btn-wrapper">
                                                        <?php 
                                                        
                                                        if($pl_price == 0.00 || $pl_price == 0){
                                                        ?>
                                                        <input name="plan" type="hidden" value="<?php echo $pl_name; ?>" />  
                                                        <input name="plan_id" type="hidden" value="<?php if(isset($plans['pl_id'])): echo base64_encode($plans['pl_id']); endif; ?>" />            
                                                        <input name="interval" type="hidden" value="<?php echo $plan_interval; ?>" />         
                                                        <input name="price" type="hidden" value="<?php if(isset($plans['pl_price'])): echo $plans['pl_price']; endif; ?>" />         
                                                        <input name="currency" type="hidden" value="<?php if(isset($plans['pl_currency'])): echo $plans['pl_currency']; endif; ?>" />
                                                        <input type="submit" value="Subscribe" name="">
                                                        <?php
                                                        }else{
                                                        ?>
                                                        <input name="plan" type="hidden" value="<?php echo $pl_name; ?>" />  
                                                        <input name="plan_id" type="hidden" value="<?php if(isset($plans['pl_id'])): echo base64_encode($plans['pl_id']); endif; ?>" />            
                                                        <input name="interval" type="hidden" value="<?php echo $plan_interval; ?>" />         
                                                        <input name="price" type="hidden" value="<?php if(isset($plans['pl_price'])): echo $plans['pl_price']; endif; ?>" />         
                                                        <input name="currency" type="hidden" value="<?php if(isset($plans['pl_currency'])): echo $plans['pl_currency']; endif; ?>" />
                                                        <?php if(STRIPE_PUBLISHABLE_KEY): ?>
                                                        <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                                            data-key="<?php echo STRIPE_PUBLISHABLE_KEY; ?>"
                                                            data-name="<?php echo $pl_name; ?>"
                                                            data-panel-label="Pay Now"
                                                            data-label="Subscription"
                                                            data-locale="auto">
                                                        </script>
                                                        <?php endif;
                                                        }
                                                        ?>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Pixaguru Modal End -->
                        </div>
                    </div>
                </div>
                <?php endif;
                 $i++;
                }
            }
            ?>
        </div> 
		<div class="container">
			<div class="pg-auth-note">
				<p><?php echo html_escape($this->lang->line('ltr_subscribe_plan_has_acc_msg')); ?> <a href="<?php echo base_url(); ?>authentication"><?php echo html_escape($this->lang->line('ltr_subscribe_plan_has_acc_btn')); ?></a></p>
			</div>
		</div>
	 </div>
     <span id="base_url" data-ajax_url="<?php echo site_url(); ?>"></span>
     <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
     <script src="<?php echo base_url(); ?>assets/js/jquery.toaster.js"></script>
     <script src="<?php echo base_url(); ?>assets/js/front-script.js"></script>
 </body>
</html>       