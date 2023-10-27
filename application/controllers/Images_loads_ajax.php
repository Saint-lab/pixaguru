<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Images_loads_ajax extends CI_Controller {
    
    private $g_userID;
    function __construct() {
        parent::__construct();
        
    }
    
    /**
     * Shape Load
     */ 
    public function shape(){
    ?>
    <div class="panel"> 
    <div class="panel-heading">
    <h4 class="panel-title">
    	<a data-bs-toggle="collapse" data-bs-parent="#accordion" href="#acc_basic_shapes"><?php echo html_escape($this->lang->line('ltr_images_loads_shape_msg1')); ?></a>
    </h4>
    </div>
    <div id="acc_basic_shapes" class="panel-collapse collapse in pg-basic-shaps">
    <div class="panel-body">
    	<ul>
    		<?php
    		$directory = "assets/images/element/shape/basic_shapes/";
    		$directory_images = glob($directory . "*.svg");
            foreach($directory_images as $img){
    			echo '<li><a class="pg-element-svg"><img src="'.base_url() . $img.'" alt="'.html_escape($this->lang->line('ltr_images_loads_shape_msg1')).'"></a></li>';
    		}
    		?>
    	</ul>
    </div>
    </div>
    </div>
    <div class="panel"> 
    <div class="panel-heading">
    <h4 class="panel-title">
    	<a data-bs-toggle="collapse" data-bs-parent="#accordion" href="#acc_dividers"><?php echo html_escape($this->lang->line('ltr_images_loads_shape_msg2')); ?></a>
    </h4>
    </div>
    <div id="acc_dividers" class="panel-collapse collapse">
    <div class="panel-body">
    	<ul>
		<?php
		$directory = "assets/images/element/shape/dividers/";
		$directory_images = glob($directory . "*.svg");
		foreach($directory_images as $img){
			echo '<li><a class="pg-element-svg"><img src="'.base_url() . $img.'" alt="'.html_escape($this->lang->line('ltr_images_loads_shape_msg2')).'"></a></li>';
		}
		?>
    	</ul>
    </div>
    </div>
    </div>
    <div class="panel"> 
    <div class="panel-heading">
    <h4 class="panel-title">
    	<a data-bs-toggle="collapse" data-bs-parent="#accordion" href="#acc_abstract"><?php echo html_escape($this->lang->line('ltr_images_loads_shape_msg3')); ?></a>
    </h4>
    </div>
    <div id="acc_abstract" class="panel-collapse collapse">
    <div class="panel-body">
    	<ul>
		<?php
		$directory = "assets/images/element/shape/abstract_shapes/";
		$directory_images = glob($directory . "*.svg");
        foreach($directory_images as $img){
			echo '<li><a class="pg-element-svg"><img src="'.base_url() . $img.'" alt="'.html_escape($this->lang->line('ltr_images_loads_shape_msg3')).'"></a></li>';
		}
		?>
    	</ul>
    </div>
    </div>
    </div>
    <div class="panel"> 
    <div class="panel-heading">
    <h4 class="panel-title">
    	<a data-bs-toggle="collapse" data-bs-parent="#accordion" href="#acc_badges"><?php echo html_escape($this->lang->line('ltr_images_loads_shape_msg4')); ?></a>
    </h4>
    </div>
    <div id="acc_badges" class="panel-collapse collapse">
    <div class="panel-body">
    	<ul>
		<?php
		$directory = "assets/images/element/shape/badges/";
		$directory_images = glob($directory . "*.svg");

		foreach($directory_images as $img){
			echo '<li><a class="pg-element-svg"><img src="'.base_url() . $img.'" alt="'.html_escape($this->lang->line('ltr_images_loads_shape_msg4')).'"></a></li>';
		}
		?>
    	</ul>
    </div>
    </div>
    </div>
    <div class="panel"> 
    <div class="panel-heading">
    <h4 class="panel-title">
    	<a data-bs-toggle="collapse" data-bs-parent="#accordion" href="#acc_ecommerce"><?php echo html_escape($this->lang->line('ltr_images_loads_shape_msg5')); ?></a>
    </h4>
    </div>
    <div id="acc_ecommerce" class="panel-collapse collapse">
    <div class="panel-body">
    	<ul>
		<?php
		$directory = "assets/images/element/shape/ecommerce/";
		$directory_images = glob($directory . "*.svg");

		foreach($directory_images as $img){
			echo '<li><a class="pg-element-svg"><img src="'.base_url() . $img.'" alt="'.html_escape($this->lang->line('ltr_images_loads_shape_msg5')).'"></a></li>';
		}
		?>
    	</ul>
    </div>
    </div>
    </div>
    
    <div class="panel">
    <div class="panel-heading">
    <h4 class="panel-title">
    	<a data-bs-toggle="collapse" data-bs-parent="#accordion" href="#acc_arrow"><?php echo html_escape($this->lang->line('ltr_images_loads_shape_msg6')); ?></a>
    </h4>
    </div>							
    <div id="acc_arrow" class="panel-collapse collapse">
    <div class="panel-body">
    	<ul>
    	<?php
    	$directory = "assets/images/element/shape/arrow/";
		$directory_images = glob($directory . "*.svg");
        foreach($directory_images as $img){
			echo '<li><a class="pg-element-svg"><img src="'.base_url() . $img.'" alt="'.html_escape($this->lang->line('ltr_images_loads_shape_msg6')).'"></a></li>';
		}
    	?>
    	</ul>
    </div>
    </div>
    </div>
    <div class="panel"> 
    <div class="panel-heading">
    <h4 class="panel-title">
    	<a data-bs-toggle="collapse" data-bs-parent="#accordion" href="#acc_banners"><?php echo html_escape($this->lang->line('ltr_images_loads_shape_msg7')); ?></a>
    </h4>
    </div>
    <div id="acc_banners" class="panel-collapse collapse">
    <div class="panel-body">
    	<ul>
		<?php
		$directory = "assets/images/element/shape/banners/";
		$directory_images = glob($directory . "*.svg");
         foreach($directory_images as $img){
			echo '<li><a class="pg-element-svg"><img src="'.base_url() . $img.'" alt="'.html_escape($this->lang->line('ltr_images_loads_shape_msg7')).'"></a></li>';
		}
		?>
    	</ul>
    </div>
    </div>
    </div>
    <div class="panel"> 
    <div class="panel-heading">
    <h4 class="panel-title">
    	<a data-bs-toggle="collapse" data-bs-parent="#accordion" href="#acc_holiday"><?php echo html_escape($this->lang->line('ltr_images_loads_shape_msg8')); ?></a>
    </h4>
    </div>
    <div id="acc_holiday" class="panel-collapse collapse">
    <div class="panel-body">
    	<ul>
		<?php
		$directory = "assets/images/element/shape/holiday/";
		$directory_images = glob($directory . "*.svg");
        foreach($directory_images as $img){
			echo '<li><a class="pg-element-svg"><img src="'.base_url() . $img.'" alt="'.html_escape($this->lang->line('ltr_images_loads_shape_msg8')).'"></a></li>';
		}
		?>
    	</ul>
    </div>
    </div>
    </div>
    
    <div class="panel"> 
    <div class="panel-heading">
    <h4 class="panel-title">
    	<a data-bs-toggle="collapse" data-bs-parent="#accordion" href="#acc_button"><?php echo html_escape($this->lang->line('ltr_images_loads_shape_msg9')); ?></a>
    </h4>
    </div>
    <div id="acc_button" class="panel-collapse collapse">
    <div class="panel-body">
    	<ul>
		<?php
		$directory = "assets/images/element/shape/button/";
		$directory_images = glob($directory . "*.svg");
        foreach($directory_images as $img){
			echo '<li><a class="pg-element-svg"><img src="'.base_url() . $img.'" alt="'.html_escape($this->lang->line('ltr_images_loads_shape_msg9')).'"></a></li>';
		}
		?>
    	</ul>
    </div>
    </div>
    </div>
    <div class="panel"> 
    <div class="panel-heading">
    <h4 class="panel-title">
    	<a data-bs-toggle="collapse" data-bs-parent="#accordion" href="#acc_social"><?php echo html_escape($this->lang->line('ltr_images_loads_shape_msg10')); ?></a>
    </h4>
    </div>
    <div id="acc_social" class="panel-collapse collapse">
    <div class="panel-body">
    	<ul>
		<?php
		$directory = "assets/images/element/shape/social/";
		$directory_images = glob($directory . "*.svg");
        foreach($directory_images as $img){
			echo '<li><a class="pg-element-svg"><img src="'.base_url() . $img.'" alt="'.html_escape($this->lang->line('ltr_images_loads_shape_msg10')).'"></a></li>';
		}
		?>
    	</ul>
    </div>
    </div>
    </div>
    <div class="panel"> 
    <div class="panel-heading">
    <h4 class="panel-title">
    	<a data-bs-toggle="collapse" data-bs-parent="#accordion" href="#acc_emoji"><?php echo html_escape($this->lang->line('ltr_images_loads_shape_msg11')); ?></a>
    </h4>
    </div>
    <div id="acc_emoji" class="panel-collapse collapse">
    <div class="panel-body">
    	<ul>
		<?php
		$directory = "assets/images/element/shape/emoji/";
		$directory_images = glob($directory . "*.svg");
        foreach($directory_images as $img){
			echo '<li><a class="pg-element-svg"><img src="'.base_url() . $img.'" alt="'.html_escape($this->lang->line('ltr_images_loads_shape_msg11')).'"></a></li>';
		}
	    ?>
    	</ul>
    </div>
    </div>
    </div>
    <div class="panel"> 
    <div class="panel-heading">
    <h4 class="panel-title">
    	<a data-bs-toggle="collapse" data-bs-parent="#accordion" href="#acc_object"><?php echo html_escape($this->lang->line('ltr_images_loads_shape_msg12')); ?></a>
    </h4>
    </div>
    <div id="acc_object" class="panel-collapse collapse">
    <div class="panel-body">
    	<ul>
		<?php
		$directory = "assets/images/element/shape/object/";
		$directory_images = glob($directory . "*.svg");
        foreach($directory_images as $img){
			echo '<li><a class="pg-element-svg"><img src="'.base_url() . $img.'" alt="'.html_escape($this->lang->line('ltr_images_loads_shape_msg12')).'"></a></li>';
		}
		?>
    	</ul>
    </div>
    </div>
    </div>
    <div class="panel"> 
    <div class="panel-heading">
    <h4 class="panel-title">
    	<a data-bs-toggle="collapse" data-bs-parent="#accordion" href="#acc_seasonal"><?php echo html_escape($this->lang->line('ltr_images_loads_shape_msg13')); ?></a>
    </h4>
    </div>
    <div id="acc_seasonal" class="panel-collapse collapse">
    <div class="panel-body">
    	<ul>
		<?php
		$directory = "assets/images/element/shape/seasonal/";
		$directory_images = glob($directory . "*.svg");
        foreach($directory_images as $img){
			echo '<li><a class="pg-element-svg"><img src="'.base_url() . $img.'" alt="'.html_escape($this->lang->line('ltr_images_loads_shape_msg13')).'"></a></li>';
		}
		?>
    	</ul>
    </div>
    </div>
    </div>
	<?php	
    die(); 
    }
    /**
     * library Load
     */
    public function library(){
        $directory = "assets/images/background/thumb/";
		$directory_images = glob($directory . "*.jpg");
        foreach($directory_images as $img){
			echo '<div class="pg-imglist-item"><div class="ed_image pg_canvas_add_image" data-url="'.base_url() . 'assets/images/background/'.basename($img).'"><img src="'.base_url() . $img.'" alt="'.html_escape($this->lang->line('ltr_images_loads_library_msg1')).'"></div></div>';
		}
		$directory = "assets/images/background/thumb/";
		$directory_images = glob($directory . "*.png");
        foreach($directory_images as $img){
			echo '<div class="pg-imglist-item"><div class="ed_image pg_canvas_add_image" data-url="'.base_url() . 'assets/images/background/'.basename($img).'"><img src="'.base_url() . $img.'" alt="'.html_escape($this->lang->line('ltr_images_loads_library_msg1')).'"></div></div>';
		}
		$directory = "assets/images/background/thumb/";
		$directory_images = glob($directory . "*.svg");
        foreach($directory_images as $img){
			echo '<div class="pg-imglist-item"><div class="ed_image pg_canvas_add_image" data-url="'.base_url() . 'assets/images/background/'.basename($img).'"><img src="'.base_url() . $img.'" alt="'.html_escape($this->lang->line('ltr_images_loads_library_msg1')).'"></div></div>';
		}
    die(); 
    }
    /**
     * library background images
     */ 
    public function library_bg(){
        $directory = "assets/images/background/thumb/";
		$directory_images = glob($directory . "*.jpg");
        foreach($directory_images as $img){
			echo '<div class="pg-imglist-item"><div class="ed_image pg_canvas_bg_image" data-url="'.base_url() . 'assets/images/background/'.basename($img).'"><img src="'.base_url() . $img.'" alt="'.html_escape($this->lang->line('ltr_images_loads_library_bg_msg1')).'"></div></div>';
		}
		$directory = "assets/images/background/thumb/";
		$directory_images = glob($directory . "*.png");
        foreach($directory_images as $img){
			echo '<div class="pg-imglist-item"><div class="ed_image pg_canvas_bg_image" data-url="'.base_url() . 'assets/images/background/'.basename($img).'"><img src="'.base_url() . $img.'" alt="'.html_escape($this->lang->line('ltr_images_loads_library_bg_msg1')).'"></div></div>';
		}
        $directory = "assets/images/background/thumb/";
		$directory_images = glob($directory . "*.svg");
        foreach($directory_images as $img){
			echo '<div class="pg-imglist-item"><div class="ed_image pg_canvas_bg_image" data-url="'.base_url() . 'assets/images/background/'.basename($img).'"><img src="'.base_url() . $img.'" alt="'.html_escape($this->lang->line('ltr_images_loads_library_bg_msg1')).'"></div></div>';
		}
    die(); 
    }
    
    /**
     * Pattern 
     */ 
    public function pattern_load(){
        
        $directory = "assets/images/element/pattern/";
        $directory_images = glob($directory . "*.svg");
        foreach($directory_images as $img){
        	echo '<div class="pg-imglist-item ed_bg_pattern" data-pattern="'.base_url().$img.'"><div class="ed_image"><img src="'.base_url().$img.'" alt="'.html_escape($this->lang->line('ltr_images_loads_pattern_msg1')).'"></div></div>';
        }
        
     die();  
    }
    
    /**
     * AI IMAGE GENERATOR 
     */
    public function ai_image_generator(){
        $keys_words = '';
        if(isset($_POST['key_words'])):
        $keys_words = html_escape($_POST['key_words']);
        endif;
        $image_size = '';
        if(isset($_POST['image_size'])):
        $image_size = html_escape($_POST['image_size']);
        endif;
        $ogj = str_replace(" ","%20",$keys_words);
		if(!empty($image_size)){
			$size = $image_size;
		}else{
			$size = "1024x1024";
		}
        if(!empty($ogj)){
			$args = array(
				"prompt" => $ogj,
				"n"=>1,
				"size"=>$size
			); 
		$key = "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"; 	
		$data_string = json_encode($args);  
		$ch = curl_init('https://api.openai.com/v1/images/generations');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                       
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                         
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Authorization: Bearer '.$key,
		'Content-Type: application/json'
		));
		$result = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
		$a = json_decode($result,true);
            if(isset($a['data'])){
                foreach($a['data'] as $a_child){
                    $image_path = 'openai_images'.rand(10,100);
                    $img = 'uploads/ai/'.$image_path.'.png'; 
                    $imgUrl = $a_child['url'];
                    file_put_contents($img, file_get_contents($imgUrl));
                    $img_url= base_url().'/uploads/ai/'.$image_path.'.png'; 
                    echo '<div class="ed_image pg_canvas_add_image" data-url="'.$img_url.'"><img src="'.$img_url.'" alt="AI IMAGES"></div>';
                }
            }else{
                // echo '<p>'.esc_html($a['error']['message']).'</p>';
            }
        }else{
            // echo '<p>'.esc_html__('Please Enter Object Name.','gpt-blaster').'</p>';
        }
       

      die();  
    }
    /**
     * AI IMAGE GENERATOR BG
     */
    public function ai_image_generator_bg(){
        $keys_words = '';
        if(isset($_POST['key_words'])):
        $keys_words = html_escape($_POST['key_words']);
        endif;
        $image_size = '';
        if(isset($_POST['image_size'])):
        $image_size = html_escape($_POST['image_size']);
        endif;
        $ogj = str_replace(" ","%20",$keys_words);
		if(!empty($image_size)){
			$size = $image_size;
		}else{
			$size = "1024x1024";
		}
        if(!empty($ogj)){
			$args = array(
				"prompt" => $ogj,
				"n"=>1,
				"size"=>$size
			); 
		$data_string = json_encode($args);  
		$ch = curl_init('https://api.openai.com/v1/images/generations');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                       
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                         
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Authorization: Bearer '.AI_IMAGES_GENERATOR,
		'Content-Type: application/json'
		));
		$result = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
		$a = json_decode($result,true);
            if(isset($a['data'])){
                foreach($a['data'] as $a_child){
                    $image_path = 'openai_images'.rand(10,100);
                    $img = 'uploads/ai/'.$image_path.'.png'; 
                    $imgUrl = $a_child['url'];
                    file_put_contents($img, file_get_contents($imgUrl));
                    $img_url= base_url().'/uploads/ai/'.$image_path.'.png'; 
                    echo '<div class="ed_image pg_canvas_bg_image" data-url="'.$img_url.'"><img src="'.$img_url.'" alt="AI IMAGES"></div>';
                } 
            }else{
                echo '<p>'.esc_html($a['error']['message']).'</p>';
            }
        }else{
            echo '<p>'.esc_html__('Please Enter Object Name.','gpt-blaster').'</p>';
        }
      die();  
    }
    /**
     * Pixagru AI Text Generator
     */
    public function ai_text_generator(){ 
        /**
		 * Content Code
		 */
        $search_keyword = '';
        if(isset($_POST['search_key_word'])):
          $search_keyword = html_escape($_POST['search_key_word']);
        endif;
        $language = 'English';
        $presence_penalty = 0.01;
        $frequency_penalty = 0.01;
        $best_of = 1;
        $top_p = 0.01;
        $getTemperature =0.5;
        $getMaxTokens = 1000;
        $model_option = 'text-davinci-003';
		$header = array( 
			'Authorization: Bearer '.AI_IMAGES_GENERATOR,
			'Content-type: application/json; charset=utf-8',
		 );
		$params = json_encode(array( 
		    'prompt' => "$language:$search_keyword",
		    'model'	 => $model_option,
		    'temperature' => (float)$getTemperature,
		    'max_tokens' => (float)$getMaxTokens,
			'top_p' => (float)$top_p,
			'best_of' => (float)$best_of,
			"frequency_penalty" => (float)$frequency_penalty,
			"presence_penalty" => (float)$presence_penalty,
		  ));   
		$curl = curl_init('https://api.openai.com/v1/completions');
		$options = array(
			CURLOPT_POST => true,
			CURLOPT_HTTPHEADER =>$header,
			CURLOPT_POSTFIELDS => $params,
			CURLOPT_RETURNTRANSFER => true,
		);
		curl_setopt_array($curl, $options);
		$response = curl_exec($curl);
		$httpcode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        var_dump($response);
        die();
        if(200 == $httpcode){
            $json_array = json_decode($response, true);
		    $choices = $json_array['choices'];
		    $postContent = $choices[0]["text"];
            $result_data = array('status'=>$httpcode,
		                         'content_data'=>trim($postContent),
								 'message' =>'Successfully'
		                        );
        }else{
            $result_data = array('status'=>$httpcode,
		                         'content_data'=>$postContent,
								 'message' => "Something went to wrong!"
		                        );
        }
        echo json_encode($result_data);
    die();   
    }

    /**
	 * Embed Code Template Images
	 */
	public function embed_code_template_images($id){
		$templates = $this->Common_DML->get_data('user_templates', array('template_id'=>base64_decode($id)));
		if(!empty($templates[0]['thumb'])):
		echo "<img src='".base_url().$templates[0]['thumb']."' alt='".$templates[0]['template_name']."'>";
		else:
		echo "Not Found !";	
		endif;
	} 

    /**
     * Youtub Api Thumbnails Api
     */
    public function youtub_api_thumbnails_api(){
        $search_keyword = '';
        if(isset($_POST['key_words'])):
          $search_keyword = html_escape($_POST['key_words']);
        endif;
        $size_leval = '';
        if(isset($_POST['image_size'])):
          $size_leval = html_escape($_POST['image_size']);
        endif;
        $image_set_area = '';
        if(isset($_POST['image_set_area'])):
          $image_set_area = html_escape($_POST['image_set_area']);
        endif;
        $apiKey = YOUTUBE_API;
        $url = "https://www.googleapis.com/youtube/v3/search?key=$apiKey&part=snippet&q=$search_keyword";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);
        if(!empty($data)):
            foreach($data['items'] as $item) {
                $img_url = '';
                switch($size_leval){
                    case 'medium':
                        $img_youtub_url = $item['snippet']['thumbnails']['medium']['url'];
                        $image_path = 'openai_images'.rand(10,100);
                        $img = 'uploads/youtube/'.$image_path.'.png'; 
                        file_put_contents($img, file_get_contents($img_youtub_url));
                        $img_url= base_url().'/uploads/youtube/'.$image_path.'.png';  
                    break;
                    case 'high':
                        $img_youtub_url = $item['snippet']['thumbnails']['high']['url'];
                        $image_path = 'openai_images'.rand(10,100);
                        $img = 'uploads/youtube/'.$image_path.'.png'; 
                        file_put_contents($img, file_get_contents($img_youtub_url));
                        $img_url= base_url().'/uploads/youtube/'.$image_path.'.png';
                       
                    break;
                    case 'default':
                        $img_youtub_url = $item['snippet']['thumbnails']['default']['url'];
                        $image_path = 'openai_images'.rand(10,100);
                        $img = 'uploads/youtube/'.$image_path.'.png'; 
                        file_put_contents($img, file_get_contents($img_youtub_url));
                        $img_url= base_url().'/uploads/youtube/'.$image_path.'.png'; 
                        
                    break;
                }
                if($image_set_area == 'bg'):
                    echo '<div class="ed_image pg_canvas_bg_image" data-url="'.$img_url.'"><img src="'.$img_url.'" alt="thumbnails"></div>';
                else:
                    echo '<div class="ed_image pg_canvas_add_image" data-url="'.$img_url.'"><img src="'.$img_url.'" alt="thumbnails"></div>';
                endif;
            }
        else:
            echo "<h3>Some Thing Went Wrong!</h3>";
        endif;
    die();   
    }

}