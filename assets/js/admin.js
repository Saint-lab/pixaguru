jQuery(document).ready(function ($) {
    "use strict";
	var ajaxurl = $('#base_url').val();
	var template_reach = 24;
	var page_user = 0;
	if($('.data_table_id').length){
		$('.data_table_id').DataTable({
		});
	} 
	if($('#users_table').length){
		$('#users_table').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": ajaxurl + 'admin/get_user/' + page_user
		});
	}
	if($('#coupon_table').length){
		$('#coupon_table').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": ajaxurl + 'coupon/view/' + page_user
		});
	}
	if($('#subscription_table').length){
		$('#subscription_table').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": ajaxurl + 'subscription/view/' + page_user
		});
	} 
	if($('#subscription_table_list').length){
		$('#subscription_table_list').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": ajaxurl + 'subscription/subscription_view/' + page_user
		});
	} 
    	
    	if($('.pg-popup-link').length){
    		$('.pg-popup-link').magnificPopup({
    			callbacks:{
    				elementParse: function(item) {					
    				}
    			}
    		});
    	}
    	if($('.ed_open_image').length){
    		$(document).on('click', '.ed_open_image', function(e){
    			e.preventDefault();
    			$.magnificPopup.open({
    				items: {
    					src: $(this).attr('href')
    				},
    				type: 'image'
    			}, 0);
    		});
    	}
    	$(document).on('click', '.pg-edit-user-link', function(e){
    		e.preventDefault();
    		$.magnificPopup.open({
    			items: {
    				src: $(this).attr('href')
    			},
    			type: 'ajax',
    			callbacks: { 
    				ajaxContentAdded: function(){
    					$('#update_suggestion').on('click',function(e){
    						e.preventDefault(); 
    						var suggestion_qust = $('#suggestion_qust').val();
    						var suggestion_txt = $('#suggestion_txt').val();
    						var s_cat_id = $('#s_cat_id').val();
    						var ts_cat_id = $('#ts_cat_id').val();
    						var s_frontend = 0, s_otos = 0;
    						if($("#s_frontend").prop('checked') == true){
    							s_frontend = 1;
    						}
    						if($("#s_otos").prop('checked') == true){
    							s_otos = 1;
    						}
    						if(suggestion_txt != '' && s_cat_id != '' && suggestion_qust != ''){
    							var data = { 'suggestion':suggestion_txt, 's_cat_id':s_cat_id, 'suggestion_qust':suggestion_qust, 'action':'create', 'ts_cat_id':ts_cat_id, 's_frontend':s_frontend, 's_otos':s_otos };
    							var suggestion_id = $('#suggestion_id').val();
    							if(suggestion_id != '' && suggestion_id != undefined){
    								data['suggestion_id'] = suggestion_id;
    								data['action'] = 'update';
    							}
    							$.ajax({
    								type:'post',
    								url: ajaxurl + 'admin/suggestion',
    								data:data,
    								success:function(data){
    									var result = jQuery.parseJSON(data);
    									if(result.status){
    										$.toaster(result.msg, 'Success', 'success');
    										setTimeout(function(){ location.reload(); }, 300);
    									}else{
    										$.toaster(result.msg, 'Error', 'danger');
    									}
    								}
    							});
    						}else{
    							$.toaster('All fields are required.', 'Error', 'danger');
    						}
    					});
    					$('#update_category').on('click',function(e){
    						e.preventDefault();
    						var name = $('#subcategory_name').val();
    						var cat_id = $('#category_id').val();
    						if(name != ''){
    							var data = { 'name':name, 'action':'create', 'cat_id':cat_id };
    							var sub_cat_id = $('#subcategory_id').val();
    							if(sub_cat_id != '' && sub_cat_id != undefined){
    								data['sub_cat_id'] = sub_cat_id;
    								data['action'] = 'update';
    							}
    							$.ajax({
    								type:'post',
    								url: ajaxurl + 'admin/category',
    								data:data,
    								success:function(data){
    									var result = jQuery.parseJSON(data);
    									if(result.status){
    										$.toaster(result.msg, 'Success', 'success');
    										setTimeout(function(){ location.reload(); }, 300);
    									}else{
    										$.toaster(result.msg, 'Error', 'danger');
    									}
    								}
    							});
    						}else{
    							$.toaster('All fields are required.', 'Error', 'danger');
    						}
    					});
    					$('#update_user').on('click',function(e){
    						e.preventDefault();
    						var name = $('#user_name').val();
    						var email = $('#user_email').val();
    						var password = $('#user_password').val();
    						var user_id = $('#user_id').val();
    						var status = $('#status').val();
    						if(name != '' && email != ''){
    							var send_mail = 0;
    							if ($('#send_user_detail').is(":checked")){
    								send_mail = 1;
    							}
    							var access_level = $('#access_level').val();
    							var data = {'action':'update', 'name':name, 'email':email, 'password':password, 'user_id':user_id, 'status':status, 'send_mail':send_mail, 'access_level':access_level};
    							$.ajax({
    								type:'post',
    								url: ajaxurl + 'admin/user_action',
    								data:data,
    								success:function(data){
    									var result = jQuery.parseJSON(data);
    									if(result.status){
    										$.toaster(result.msg, 'Success', 'success');
    										setTimeout(function(){ location.reload(); }, 300);
    									}else{
    										$.toaster(result.msg, 'Error', 'danger');
    									}
    								}
    							});
    						}else{
    							$.toaster('All fields are required.', 'Error', 'danger');
    						}
    					});
    
    					$('#update_template').on('click',function(e){
    						e.preventDefault();
    						var template_name = $('#template_name').val();
    						var category_id = $('#category_id').val();
    						var sub_category_id = $('#sub_category_id').val();
    						var template_size = $('#template_size').val();
    						var template_id = $('#template_id').val();
    						if(template_name != '' && category_id != '' && sub_category_id != ''){
    							$.ajax({
    								type:'post',
    								url: ajaxurl + 'admin/create_template',
    								data:{'template_name':template_name,'cat_id':category_id,'sub_cat_id':sub_category_id,'template_id':template_id,'template_size':template_size},
    								success:function(data){
    								    var result = jQuery.parseJSON(data);
    									if(result.status){
    										$.toaster(result.msg, 'Success', 'success');
    										setTimeout(function(){ window.location = result.url }, 300);
    									}
    								}
    							});
    						}else{
    							$.toaster('All fields are required.', 'Error', 'danger');
    						}
    					});
    				}
    			}
    		});
    	});
    	$(document).on('change', '.ed_template_status_update', function(e){
    		e.preventDefault();
    		var template_id = $(this).data('template_id');
    		var status = $(this).val();
    		status = status == 1 ? 0 : 1;
    		if(status == 0){
    			$(this).val(0);
    			$(this).parents('.pg-template-box').addClass('pg-inactive-template');				
    		}else{
    			$(this).val(1);
    			$(this).parents('.pg-template-box').removeClass('pg-inactive-template');    			
    		}
    		$.ajax({
    			type:'post',
    			url: ajaxurl + 'admin/template_status_update',
    			data:{'template_id':template_id,'status':status},
    			success:function(data){
    				var result = jQuery.parseJSON(data);
    				console.log(result);
    			}
    		});
    	});
    	$('#create_category').on('click',function(e){
    		e.preventDefault();
    		var name = $('#subcategory_name').val();
    		var cat_id = $('#category_id').val();
    		if(name != ''){
    			var data = { 'name':name, 'action':'create', 'cat_id':cat_id };
    			$.ajax({
    				type:'post',
    				url: ajaxurl + 'admin/category',
    				data:data,
    				success:function(data){
    					var result = jQuery.parseJSON(data);
    					if(result.status){
    						$.toaster(result.msg, 'Success', 'success');
    						setTimeout(function(){ location.reload(); }, 300); 
    					}else{
    						$.toaster(result.msg, 'Error', 'danger');
    					}
    				}
    			});
    		}else{
    			$.toaster('All fields are required.', 'Error', 'danger');
    		}
    	});
    	$('.ed_delete_category').on('click',function(e){
    		e.preventDefault();
    		var sub_cat_id = $(this).data('sub_cat_id');
    		if(confirm('Are you sure?')){
    			var data = { 'sub_cat_id' : sub_cat_id, 'action' : 'delete' }
    			$.ajax({
    				type:'post',
    				url: ajaxurl + 'admin/category',
    				data:data,
    				success:function(data){
    					var result = jQuery.parseJSON(data);
    					if(result.status){
    						$.toaster(result.msg, 'Success', 'success');
    						setTimeout(function(){ location.reload(); }, 300);
    					}else{
    						$.toaster(result.msg, 'Error', 'danger');
    					}
    				}
    			});
    		}
    	});
    	$('#create_suggestion').on('click',function(e){
    		e.preventDefault();
    		var suggestion_qust = $('#suggestion_qust').val();
    		var suggestion_txt = $('#suggestion_txt').val();
    		var s_cat_id = $('#s_cat_id').val();
    		var ts_cat_id = $('#ts_cat_id').val();
    		var s_frontend = 0, s_otos = 0;
    		if($("#s_frontend").prop('checked') == true){
    			s_frontend = 1;
    		}
    		if($("#s_otos").prop('checked') == true){
    			s_otos = 1;
    		}
    		if(suggestion_txt != '' && s_cat_id != '' && suggestion_qust != ''){
    			var data = { 'suggestion':suggestion_txt, 's_cat_id':s_cat_id, 'suggestion_qust': suggestion_qust, 'action':'create', 'ts_cat_id':ts_cat_id, 's_frontend':s_frontend, 's_otos':s_otos };
    			$.ajax({
    				type:'post',
    				url: ajaxurl + 'admin/suggestion',
    				data:data,
    				success:function(data){
    					var result = jQuery.parseJSON(data);
    					if(result.status){
    						$.toaster(result.msg, 'Success', 'success');
    						setTimeout(function(){ location.reload(); }, 300);
    					}else{
    						$.toaster(result.msg, 'Error', 'danger');
    					}
    				}
    			});
    		}else{
    			$.toaster('All fields are required.', 'Error', 'danger');
    		}
    	});
    	$('.ed_delete_suggestion').on('click',function(e){
    		e.preventDefault();
    		var suggestion_id = $(this).data('suggestion_id');
    		if(confirm('Are you sure?')){
    			var data = { 'suggestion_id' : suggestion_id, 'action' : 'delete' }
    			$.ajax({
    				type:'post',
    				url: ajaxurl + 'admin/suggestion',
    				data:data,
    				success:function(data){
    					var result = jQuery.parseJSON(data);
    					if(result.status){
    						$.toaster(result.msg, 'Success', 'success');
    						setTimeout(function(){ location.reload(); }, 300);
    					}else{
    						$.toaster(result.msg, 'Error', 'danger');
    					}
    				}
    			});
    		}
    	});
    	$('#create_user').on('click',function(e){
    		e.preventDefault();
    		var name = $('#user_name').val();
    		var email = $('#user_email').val();
    		var password = $('#user_password').val();
    		if(name != '' && email != '' && password != ''){
    			var send_mail = 0;
    			if ($('#send_user_detail').is(":checked")){
    				send_mail = 1;
    			}
    			var access_level = $('#access_level').val();
    			var data = {'action':'create', 'name':name, 'email':email, 'password':password, 'send_mail':send_mail, 'access_level':access_level};
    			$.ajax({
    				type:'post',
    				url: ajaxurl + 'admin/user_action',
    				data:data,
    				success:function(data){
    					var result = jQuery.parseJSON(data);
    					if(result.status){
    						$.toaster(result.msg, 'Success', 'success');
    						setTimeout(function(){ location.reload(); }, 300);
    					}else{
    						$.toaster(result.msg, 'Error', 'danger');
    					}
    				}
    			});
    		}else{
    			$.toaster('All fields are required.', 'Error', 'danger');
    		}
    	});
    	$(document).on('click', '.pg-delete-user', function(e){
    		e.preventDefault();
    		var user_id = $(this).data('user_id');
    		if(confirm('Are you sure?')){
    			var data = { 'user_id' : user_id, 'action' : 'delete' }
    			$.ajax({
    				type:'post',
    				url: ajaxurl + 'admin/user_action',
    				data:data,
    				success:function(data){
    					var result = jQuery.parseJSON(data);
    					if(result.status){
    						$.toaster(result.msg, 'Success', 'success');
    						setTimeout(function(){ location.reload(); }, 300);
    					}else{
    						$.toaster(result.msg, 'Error', 'danger');
    					}
    				}
    			});
    		}
    	});
    	if($('.get_sub_category').length){
    		$('.get_sub_category').on('change',function(e){
    			e.preventDefault();
    			var cat_id = $(this).val();
    			$.ajax({
    				type:'post',
    				url: ajaxurl + 'admin/get_sub_category',
    				data:{'cat_id':cat_id},
    				success:function(data){
    					var result = jQuery.parseJSON(data);
    					if(result.status){
    						$('#sub_category_id option').remove();
    						$.each(result.data, function (i, item) {
    							$('#sub_category_id').append($('<option>', { 
    								value: item.sub_cat_id,
    								text : item.name 
    							}));
    						});
    					}
    				}
    			});
    		});
    		$('.get_sub_category').change();
    	}
    	$('#create_template').on('click',function(e){
    		e.preventDefault();
    		var template_name = $('#template_name').val();
    		var category_id = $('#category_id').val();
    		var sub_category_id = $('#sub_category_id').val();
    		var template_size = $('#template_size').val();
            var custom_size = 0;
			if(template_size=='create_custom_size'){
			   custom_size = $('#template_width').val()+'x'+$('#template_height').val();
			} 
			if(template_name != '' && category_id != '' && sub_category_id != ''){
    			$.ajax({
    				type:'post',
    				url: ajaxurl + 'admin/create_template',
    				data:{'template_name':template_name,'cat_id':category_id,'sub_cat_id':sub_category_id,'template_size':template_size,'custom_size':custom_size},
    				success:function(data){
    					var result = jQuery.parseJSON(data);
    					if(result.status){
    						$.toaster(result.msg, 'Success', 'success');
    						setTimeout(function(){ window.location = result.url }, 300);
    					}
    				}
    			});
    		}else{
    			$.toaster('All fields are required.', 'Error', 'danger');
    		}
    	});

		/**
		 * Custom Template Size
		 */
		$('#template_size').on('change',function(e){
            let template_size = $('#template_size').val();
		    if(template_size=='create_custom_size'){
                $('#template_custom_size').show();
			}else{
				$('#template_custom_size').hide();
			}
		});

    	
    	$('#move_other_size').on('change',function(){
    		var size = $(this).val();
    		window.location = ajaxurl + 'admin/templates/' + size;
    	});
    	
    	/**
    	 * Filter Inactive Template
    	 */ 
    	$('#pg_inactive_active').on('change',function(){
    	   let filter_type = $('#pg_inactive_active').val();
    	   var size = $('#move_other_size').val();
    	   window.location = ajaxurl+'admin/templates/'+size+'/'+filter_type;
    	});
    	/* template action */
    	$(document).on('click', '.template_action', function(e){
    		e.preventDefault();
    		var action = $(this).data('action');
    		var template_id = $(this).data('template_id');
    		var data = { 'action' : action, 'template_id' : template_id };
    		if(action == 'delete'){
    			if(!confirm('Are you sure?')){
    				return false;
    			}
    		}
    		var obj = $(this);
    		$.ajax({
    			type:'post',
    			url: ajaxurl + 'admin/template_action',
    			data:data,
    			success:function(data){
    				var result = jQuery.parseJSON(data);
    				if(result.status){
    					$.toaster(result.msg, 'Success', 'success');
    					if(action == 'copy'){
    						setTimeout(function(){ location.reload(); },300);
    					}
    					if(action == 'delete'){
    						var remove = obj.parents('.pg-screen-container').find('.template_count');
    						remove.text( parseInt( remove.text() ) - 1 );
    						obj.parents('.ed_template_remove').remove();
    					}
    					 window.location.reload();
    				}else{
    					$.toaster(result.msg, 'Error', 'danger');
    				}
    			}
    		});
    	});	
    	/* template action */
    	/* load More */
    	$('.pg-load-more-btn').on('click',function(e){
    		e.preventDefault();
    		var start = template_reach;
    		var size = $(this).data('size');
    		var active_inactive = $('#pg_inactive_active').val();
    	    var data = { 'reach':template_reach, 'size':size,'active_inactive':active_inactive };
    		var obj = $(this);
    		$('.pg-preloader-wrap').css('display','none');
    		$.ajax({
    			type:'post',
    			url: ajaxurl + 'admin/get_more_template',
    			data:data,
    			success:function(data){
    				var result = jQuery.parseJSON(data);
    				if(result.status){
    					template_reach = result.reach;
    					var html = '';
    					for( var i =0; i < result.data.length; i++ ){
    						html = add_template(result.data[i]);
    						$('#pg-template-conteiner').append(html);
    					}					
    					if(result.hide){
    						obj.hide();
    					}
    					$('.pg-preloader-wrap').hide();
    				}else{
    					$.toaster(result.msg, 'Error', 'danger');
    				}
    			}
    		});
    	});
    	/* load More */
    	function add_template(template){
    		var template_name = template.template_name == '' ? 'Unnamed' : template.template_name;
    		var html = '';
    		html += '<div class="pg-template-box ed_template_remove">';
    			html += '<div class="pg-template-box-inner '+(template.status != 1 ? 'pg-inactive-template' : '')+'">';
    				html += '<div class="pg-template-thumb">';
    					html += '<img src="'+(template.thumb !=  '' ? ajaxurl + template.thumb : ajaxurl + 'assets/images/'+(template.template_size == '628x628' ? 'empty_campaign.jpg' : 'empty_campaign_long.jpg'))+'" alt="">';
    					html += '<a href="'+ajaxurl+'editor/admin_edit/'+template.template_id+'" class="pg-template-status">';
    						html += '<div class="pg-switch">';
    							html += '<input type="checkbox" id="temp_switch'+template.template_id+'" data-template_id="'+template.template_id+'" value="'+template.status+'" class="ed_template_status_update" '+( template.status != 1 ? '' : 'checked')+'>';
    							html += ' <label for="temp_switch'+template.template_id+'"></label>';
    						html += '</div>';
    						html += '<span class="pg-template-status-center">';
    							html += '<span class="pg-create-icon"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 477.873 477.873"><g><path d="M392.533 238.937c-9.426 0-17.067 7.641-17.067 17.067V426.67c0 9.426-7.641 17.067-17.067 17.067H51.2c-9.426 0-17.067-7.641-17.067-17.067V85.337c0-9.426 7.641-17.067 17.067-17.067H256c9.426 0 17.067-7.641 17.067-17.067S265.426 34.137 256 34.137H51.2C22.923 34.137 0 57.06 0 85.337V426.67c0 28.277 22.923 51.2 51.2 51.2h307.2c28.277 0 51.2-22.923 51.2-51.2V256.003c0-9.425-7.641-17.066-17.067-17.066z" /><path d="M458.742 19.142A65.328 65.328 0 0 0 412.536.004a64.85 64.85 0 0 0-46.199 19.149L141.534 243.937a17.254 17.254 0 0 0-4.113 6.673l-34.133 102.4c-2.979 8.943 1.856 18.607 10.799 21.585 1.735.578 3.552.873 5.38.875a17.336 17.336 0 0 0 5.393-.87l102.4-34.133c2.515-.84 4.8-2.254 6.673-4.13l224.802-224.802c25.515-25.512 25.518-66.878.007-92.393zm-24.139 68.277L212.736 309.286l-66.287 22.135 22.067-66.202L390.468 43.353c12.202-12.178 31.967-12.158 44.145.044a31.215 31.215 0 0 1 9.12 21.955 31.043 31.043 0 0 1-9.13 22.067z" /></g></svg></span>';
    						html += '</span>';
    					html += '</a>';
    					html += '<div class="pg-camp-options">';
    				    	html += '<ul>';
    							html += '<li><a href="'+ajaxurl+'admin/get_popup/tduplicate/'+template.template_id+'" title="Duplicate" class="pg-edit-user-link"><img src="/assets/images/admin/copy.svg" alt="copy"></a></li>';
    							html += '<li><a href="'+ajaxurl+'admin/get_popup/template/'+template.template_id+'" title="Rename" data-template_id="'+template.template_id+'" data-template_name="'+template_name+'" class="pg-edit-user-link" ><img src="/assets/images/admin/rename.svg" alt=""></a></li>';
    							html += '<li><a href="'+(template.thumb !=  '' ? ajaxurl + template.thumb : ajaxurl + 'assets/images/'+(template.size == '628x628' ? 'empty_campaign.jpg' : 'empty_campaign_long.jpg'))+'" title="View Template" class="ed_open_image"><img src="/assets/images/admin/view.svg" alt=""></a></li>';
    							html += '<li><a href="#" class="template_action" title="Delete" data-action="delete" data-template_id="'+template.template_id+'" ><img src="/assets/images/admin/delete.svg" alt="delete"></a></li>';
    						html += '</ul>';
    					html += '</div>';
    				html += '</div>';
    				html += '<div class="pg-camp-content">';
    					html += '<h3>'+template_name+'</h3>';
    					html += '<p>Created at - '+template.datetime+'</p>';
    				html += '</div>';
    			html += '</div>';
    		html += '</div>';
    		return html;
    	}
    
    /**
     * Coupon Code Generated
     */
    var generated = [];
    $(document).on('click','#generated_code',function(e){
    	e.preventDefault(); 
    	let result = '';
    	length = 12;
    	const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    	const charactersLength = characters.length;
    	let counter = 0;
    	while (counter < length) {
    	result += characters.charAt(Math.floor(Math.random() * charactersLength));
    	counter += 1;
    	}
    	$('#coupone_code').val(result);
    });
    
    /**
     * Coupon Code Save in db
     */
    $(document).on('submit','#coupon_form',function(e) {
    e.preventDefault();
    let offer_name = $('#offer_name').val();
    let coupon_code = $('#coupone_code').val();
    let discount_set = $('#discount_set').val();
    let discount_per_price = $('#discount_per_price').val();
    let discount_create_time = $('#discount_create_time').val();
    let discount_expire_time = $('#discount_expire_time').val();
    $('.ed_preloader').show();
    var data = { 
    			'action':'gen_coupon',
    			'offer_name':offer_name,
    			'coupon_code':coupon_code,
    			'discount_set':discount_set,
    			'discount_per_price':discount_per_price,
    			'discount_create_time':discount_create_time,
    			'discount_expire_time':discount_expire_time
    			}; 
    $.ajax({
    		type:'post',
    		url: ajaxurl + 'Coupon/gen_coupon',
    		data:data,
    		success:function(data){
    			console.log(data);
    			var result = jQuery.parseJSON(data);
    			if(result.status){
    				$.toaster(result.msg, 'Success', 'success');
    				location.reload();
    			}else{ 
    				$.toaster(result.msg, 'Error', 'danger');
    			}
    			$('.ed_preloader').hide();
    		}
    	});
    });
    
    /**
     * Delete Coupon Code
     */
    $(document).on('click', '.pg-delete-coupon', function(e){
    	e.preventDefault();
    	var coupon_id = $(this).data('coupon_id');
    	if(confirm('Are you sure?')){
    		var data = { 'coupon_id' : coupon_id, 'action' : 'delete' }
    		$.ajax({
    			type:'post',
    			url: ajaxurl + 'coupon/destroy_coupon',
    			data:data,
    			success:function(data){
    				var result = jQuery.parseJSON(data);
    				if(result.status){
    					$.toaster(result.msg, 'Success', 'success');
    					setTimeout(function(){ location.reload(); }, 300);
    				}else{
    					$.toaster(result.msg, 'Error', 'danger');
    				}
    			}
    		});
    	}
    }); 
    /**
     * Update Coupon Code
     */
    $(document).on('submit','#update_coupon_form',function(e){
    	e.preventDefault();
    	let coupon_id = $('#coupon_id').val();
    	let offer_name = $('#offer_name').val();
    	let coupon_code = $('#coupone_code').val();
    	let discount_set = $('#discount_set').val();
    	let discount_per_price = $('#discount_per_price').val();
    	let discount_create_time = $('#discount_create_time').val();
    	let discount_expire_time = $('#discount_expire_time').val();
    	$('.ed_preloader').show();
    	if(offer_name != '' && coupon_code != ''){
    		var data = { 
    			'coupon_id':coupon_id,
    			'action':'update',
    			'offer_name':offer_name,
    			'coupon_code':coupon_code,
    			'discount_set':discount_set,
    			'discount_per_price':discount_per_price,
    			'discount_create_time':discount_create_time,
    			'discount_expire_time':discount_expire_time
    		}; 
    		$.ajax({
    			type:'post',
    			url: ajaxurl + 'coupon/update_coupon',
    			data:data,
    			success:function(data){
    				var result = jQuery.parseJSON(data);
    				if(result.status){
    					$.toaster(result.msg, 'Success', 'success');
    					setTimeout(function(){ location.reload(); }, 300);
    				}else{
    					$.toaster(result.msg, 'Error', 'danger');
    				}
    			}
    		});
    	}else{
    		$.toaster('All fields are required.', 'Error', 'danger');
    	}
    });
    
    /**
     * Subscription Plan Js
     */
    $(document).on('submit','#pricing_plan_form',function(e){
    	e.preventDefault();
    	let plan_name = $('#plan_name').val();
    	let plan_price = $('#price_plans').val();
    	let currency_set = $('#currency_set').val();
    	let interval_set = $('#interval_set').val();
    	let plane_description = $('#plane_description').val();
    	$('.ed_preloader').show();  
    	if(plan_name != ''){ 
    		var data = { 
    			'plan_name':plan_name,
    			'action':'pricing_plan',
    			'plan_price':plan_price,
    			'currency_set':currency_set,
    			'interval_set':interval_set,
    			'plane_description':plane_description,
    		}; 
    		$.ajax({
    			type:'post',
    			url: ajaxurl + 'subscription/create_subscription_plan',
    			data:data,
    			success:function(data){
    				var result = jQuery.parseJSON(data);
    				if(result.status){
    					$.toaster(result.msg, 'Success', 'success');
    					setTimeout(function(){ location.reload(); }, 300);
    				}else{
    					$.toaster(result.msg, 'Error', 'danger');
    				}
    			}
    		});
    	}else{
    		$.toaster('All fields are required.', 'Error', 'danger');
    	}
    }); 
    /**
    * Update Pricing Plan 
    */
    $(document).on('submit','#update_pricing_plan_form',function(e){
    	e.preventDefault();
    	let plan_id = $('#plan_id').val();
    	let plan_name = $('#plan_name').val();
    	let plan_price = $('#price_plans').val();
    	let currency_set = $('#currency_set').val();
    	let interval_set = $('#interval_set').val();
    	let plane_description = $('#plane_description').val();
    	$('.ed_preloader').show();  
    	if(plan_name != ''){ 
    		var data = { 
    			'plan_id':plan_id,
    			'plan_name':plan_name,
    			'action':'update',
    			'plan_price':plan_price,
    			'currency_set':currency_set,
    			'interval_set':interval_set,
    			'plane_description':plane_description,
    		};  
    		$.ajax({
    			type:'post',
    			url: ajaxurl + 'subscription/update_plan',
    			data:data,
    			success:function(data){
    				var result = jQuery.parseJSON(data);
    				if(result.status){
    					$.toaster(result.msg, 'Success', 'success');
    					setTimeout(function(){ location.reload(); }, 300);
    				}else{
    					$.toaster(result.msg, 'Error', 'danger');
    				}
    			}
    		});
    	}else{
    		$.toaster('All fields are required.', 'Error', 'danger');
    	}
    });

    /**
     * Delete Price plan
     */
    $(document).on('click', '.pg-delete-plan-id', function(e){
    	e.preventDefault();
    	var plan_id = $(this).data('plan_id');
    	if(confirm('Are you sure?')){
    		var data = { 'plan_id' : plan_id, 'action' : 'delete' }
    		$.ajax({
    			type:'post',
    			url: ajaxurl + 'subscription/destroy_plan',
    			data:data,
    			success:function(data){
    				var result = jQuery.parseJSON(data);
    				if(result.status){
    					$.toaster(result.msg, 'Success', 'success');
    					setTimeout(function(){ location.reload(); }, 300);
    				}else{
    					$.toaster(result.msg, 'Error', 'danger');
    				}
    			}
    		});
    	}
    });
    
    /**
     * Data Template Imports
     */ 
    $(document).on('click', '#pg_import_template_load', function(e){
        if(confirm('Are you sure?')){
    		var data = {}
    		$.ajax({
    			type:'post',
    			url: ajaxurl + 'import_export_template/import_ajax_request',
    			data:data,
    			success:function(data){
    				var result = jQuery.parseJSON(data);
    				if(result.status){
    					$.toaster(result.msg, 'Success', 'success');
    					setTimeout(function(){ location.reload(); }, 300);
    				}else{
    					$.toaster(result.msg, 'Error', 'danger');
    				}
    			}
    		});
    	}
    });

	/**
     * Subscribe Newsletter
     */ 
    $(document).on('click', '#subscribe_newsletter', function(e){
		e.preventDefault();
        let name = $('#user_name').val();
		let email = $('#user_email').val();
        if(email == ''){ 
		  $.toaster('Please Enter Email Address', 'Error', 'danger');
	      $('.error_images').html('<span style="color:red;">Please Enter Email Address</span>'); 
          return false;
		}else{
    		var data = {name:name,email:email}
    		$.ajax({
    			type:'post',
    			url: ajaxurl + 'Import_export_template/pix_subscribe_newsletter',
    			data:data, 
    			success:function(data){
					console.log(data);

					var result = jQuery.parseJSON(data);
    				if(result.status == true){
    					$.toaster(result.message, 'Success', 'success');
                        window.location = result.download_url;
    					//setTimeout(function(){ location.reload(); }, 300);
    				}else{
    					$.toaster(result.message, 'Error', 'danger');
    				}

    			}
    		});
    	}
    });
    
    // User Toggle Sript 
    $('.pg-user-info').on("click", function() {
    	$('.pg-user-useful-links').toggleClass('active');
    	$(this).toggleClass('active');
    });
    $(".pg-user-useful-links, .pg-user-info").on('click', function(e) {
    	e.stopPropagation();
    });
    $('body').on("click", function() {
    	$('.pg-user-useful-links').removeClass('active');
    	$(".pg-user-info").removeClass('active');
    });
    
    // Responsive Togggle 
    
    $('.pg-menu-toggle').on("click", function() {
    	$('body').toggleClass('pg-sidebar-showshow');
    });
    
    $(".pg-menu-toggle").on('click', function(e) {
    	e.stopPropagation();
    });
    
    $('body').on("click", function() {
    	$('body').removeClass('pg-sidebar-showshow');
    });
    $(window).scroll(function() {   
    if($(window).scrollTop() + $(window).height() == $(document).height()) {
    	$('.pg-load-more-btn').click();
    }
    });

	/**
	 * Theme Setting Logo Images Changes
	 */
	$(document).on('submit', '#pg_logo_image_save', function(e){
		e.preventDefault();
		$('.uploadBtn').html('Uploading ...');
        $('.uploadBtn').prop('Disabled');
		
        var file_data = $('#logo_images_file').prop('files')[0];
		var form_data = new FormData();
		form_data.append('logo_images_file', file_data);

		if ($('#logo_images_file').val() == '') {
            $.toaster("Choose File", 'Error', 'danger');
			$('.uploadBtn').html('Upload');
			$('.uploadBtn').prop('enabled');
			document.getElementById("pg_logo_image_save").reset();
        } else {
            $.ajax({
				url: ajaxurl+"/admin/logo_changes",
				method: "POST",
				data: new FormData(this),
				processData: false,
				contentType: false,
				cache: false,
				dataType: "json", 
				success: function (res) { 
					if(res.status == true) {
						$.toaster(res.msg, 'Success', 'success');
						location.reload();
					}else if (res.status == false) {
						$.toaster(res.msg, 'Error', 'danger');
					}
					$('.uploadBtn').html('Upload');
					$('.uploadBtn').prop('Enabled');
					location.reload(); 
				}
			}); 
        } 
    });

	/**
	 * Theme Favicon change
	 */
	$(document).on('submit', '#pg_favicon_image_save', function(e){
		e.preventDefault();
		$('.uploadBtn').html('Uploading ...');
        $('.uploadBtn').prop('Disabled');
		var file_data = $('#favicon_images_file').prop('files')[0];
		var form_data = new FormData();
		form_data.append('favicon_images_file', file_data);
        if ($('#favicon_images_file').val() == '') {
            $.toaster("Choose File", 'Error', 'danger');
			$('.uploadBtn').html('Upload');
			$('.uploadBtn').prop('enabled');
			document.getElementById("pg_favicon_image_save").reset();
        } else {
            $.ajax({
				url: ajaxurl+"/admin/favicon_changes",
				method: "POST", 
				data: new FormData(this),
				processData: false,
				contentType: false,
				cache: false,
				dataType: "json", 
				success: function (res) { 
					if(res.status == true) {
						$.toaster(res.msg, 'Success', 'success');
						location.reload();
					}else if (res.status == false) {
						$.toaster(res.msg, 'Error', 'danger');
					}
					$('.uploadBtn').html('Upload');
					$('.uploadBtn').prop('Enabled');
					location.reload(); 
				}
			}); 
        } 
    });

	/**
	 * Preloader Image
	 */
	$(document).on('submit', '#pg_preloader_image_save', function(e){
		e.preventDefault();
		$('.uploadBtn').html('Uploading ...');
        $('.uploadBtn').prop('Disabled');
		var file_data = $('#preloader_images_file').prop('files')[0];
		var form_data = new FormData();
		form_data.append('preloader_images_file', file_data);
        if ($('#preloader_images_file').val() == '') {
            $.toaster("Choose File", 'Error', 'danger');
			$('.uploadBtn').html('Upload');
			$('.uploadBtn').prop('enabled');
			document.getElementById("pg_preloader_image_save").reset();
        } else {
            $.ajax({
				url: ajaxurl+"/admin/preloader_changes",
				method: "POST", 
				data: new FormData(this),
				processData: false,
				contentType: false,
				cache: false,
				dataType: "json", 
				success: function (res) { 
					if(res.status == true) {
						$.toaster(res.msg, 'Success', 'success');
						location.reload(); 
					}else if (res.status == false) {
						$.toaster(res.msg, 'Error', 'danger');
					}
					$('.uploadBtn').html('Upload');
					$('.uploadBtn').prop('Enabled');
					
				}
			}); 
        } 
    });

	/**
	 * Delete images
	 */
	$(document).on('click', '.pg_delete_images', function(e){
		e.preventDefault();
		let file_name = $(this).attr('data-imgename');
		let image_type = $(this).attr('data-image_type');
		if(confirm("Are You Sure ?")){
			$.ajax({
				url: ajaxurl+"/admin/delete_images_changes",
				method: "POST", 
				data: {file_name:file_name,image_type:image_type},
				success: function (res) { 
					if(res.status == true) {
						$.toaster(res.msg, 'Success', 'success');
						location.reload(); 
					}else if (res.status == false) {
						$.toaster(res.msg, 'Error', 'danger');
					}
					location.reload(); 
				}
			});  
	    }

	});

	$(document).on('click', '.open_embed', function(e){
		e.preventDefault();
       let template_name = $(this).attr('data-template_name');
	   let embed_url = $(this).attr('data-embed_url');
	   let ifrmae ='<iframe src="'+embed_url+'" title="'+template_name+'"></iframe>';
       $('#pg_embed_code').val(ifrmae);
	  
	});
	// Textarea Text Copy
	$("#ai_text_copy").click(function() {				
		$("#pg_embed_code").select();
		document.execCommand("copy");
		$('#pg_wait_message').html('Copied');
	}); 
	// Textarea Text Copy
	$(document).on('click', '#ChangeURL', function(e){
	     var formdata = new FormData($(this).closest('form')[0]);
		$.ajax({
			url: ajaxurl+"admin/sqlimporter",
			method: "POST", 
			data: formdata,
			processData: false,
			success: function (res) { 
				console.log(res);
			}
		});  
	});

	/**
	 * Social Share
	 */
	$(document).on('click','.pxg-img-share-btn',function(e){
		e.preventDefault();
		let share_uri = $(this).attr('data-shareuri');
		let share_title = $(this).attr('data-sharename');
		$('.share_post_images').attr('template_url',share_uri);
		$('.share_post_images').attr('title',share_title);
		
		$(".pxg_share_facebook").attr('href', 'https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(share_uri));
		$(".pxg_share_twitter").attr('href', 'https://www.linkedin.com/cws/share?url='+encodeURIComponent(share_uri));
		$(".pxg_share_whatsapp").attr('href', 'https://twitter.com/intent/tweet?text='+share_title+'&amp;url='+encodeURIComponent(share_uri)+'&amp;via=Miraculous');
		$(".pxg_share_linkedin").attr('href', 'https://api.whatsapp.com/send?text='+encodeURIComponent(share_uri));
	 });             
});  
function onFileUpload(input, id) {
	id = id || '#ajaxImgUpload';
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			//$(id).attr('src', e.target.result).width(100)
	    	$(id).append('<img class="mb-3" alt="Preview Image" src="'+e.target.result+'" />'); 
		};
		reader.readAsDataURL(input.files[0]);
	}
}

(function($) {
    "use strict";
    $(window).on('load', function(){
    	$('body').addClass('pg-site-loaded');
    });

	/**
	 * Google Analytics Header Script 
	 */
	$(document).on('submit', '#pg_google_analytics_header_scripte', function(e){
		e.preventDefault();
        let header_script = $('#header_script').val();
        if(header_script == ''){
		   $.toaster("Please Add Script Code", 'Error', 'danger');
	    }else{
			let ajaxurl = $('#base_url').val(); 
			$.ajax({
				url: ajaxurl+"/theme_setting/google_analytics_header_script_save",
				method: "POST", 
				data: {header_script:header_script},
				success: function (res) { 
					console.log(res);
					if(res.status == true) {
						$.toaster(res.msg, 'Success', 'success');
					}else if (res.status == false) {
						$.toaster(res.msg, 'Error', 'danger');
					}
				}
			}); 
	    }
    });
	/**
	 * Google Analytics Footer Script
	 */ 
	$(document).on('submit', '#pg_google_analytics_footer_scripte', function(e){
		e.preventDefault();
        let footer_script = $('#footer_script').val();
		if(footer_script == ''){
		  $.toaster("Please Add Script Code", 'Error', 'danger');
	    }else{
		let ajaxurl = $('#base_url').val(); 
			$.ajax({
				url: ajaxurl+"/theme_setting/google_analytics_footer_script_save",
				method: "POST", 
				data: {footer_script:footer_script},
				success: function (res) { 
					console.log(res);
					if(res.status == true) {
						$.toaster(res.msg, 'Success', 'success');
					}else if (res.status == false) {
						$.toaster(res.msg, 'Error', 'danger');
					}
				}
			}); 
	    }
    });


})(jQuery);