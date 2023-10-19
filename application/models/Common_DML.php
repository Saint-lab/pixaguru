<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_DML extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
		$this->load->database();
    }
    
    public function get_data( $table_name, $where = array(), $field = '*', $order = array() ){
        $this->db->select( $field );
		$this->db->from( $table_name );
		if( !empty($where) ){
			 $this->db->where( $where );
		}
		if(!empty($order)){
			foreach($order as $k=>$v){
				$this->db->order_by($k, $v);
			}
		}
		$query = $this->db->get();
        return $query->result_array();   
    }

    public function get_data_row( $table_name, $where = array(), $field = '*', $order = array() ){
        $this->db->select( $field );
		$this->db->from( $table_name );
		if( !empty($where) ){
			 $this->db->where( $where );
		}
		if(!empty($order)){
			foreach($order as $k=>$v){
				$this->db->order_by($k, $v);
			}
		}
		$query = $this->db->get();
        return $query->row();   
    }
    
    public function put_data( $table_name, $what = array() ){
        $this->db->insert($table_name,$what);
		return $this->db->insert_id();
    }
    
    public function set_data( $table_name, $what = array() , $where = array()){
        $this->db->where($where);
		$this->db->update($table_name,$what);
    }
	
	public function delete_data( $table_name, $what = array() ){
        $this->db->delete( $table_name, $what);
    }
	
	public function get_data_limit( $table_name, $where = array(), $field = '*', $limit = array(), $orderby = '', $order = '', $where_in = array()){
		$this->db->select( $field );
		$this->db->from( $table_name );
		if( !empty($where) ){
			$this->db->where( $where );
		}
		if( !empty($where_in) ){
			foreach($where_in as $k=>$v){
				$this->db->where_in( $k, $v );
			}
		}
		
		if(isset($limit[1]) && $limit[1] !== '' && $limit[0] !== ''){
			$this->db->limit($limit[1], $limit[0]);
		}
		
		if($orderby != '' && $order != ''){
			$this->db->order_by($orderby, $order);
		}
		
		$query = $this->db->get();
        return $query->result_array();
	}
	
	public function search_Mediadata( $table_name, $where = array(), $like = '', $value = '', $pos = '' ){
		$this->db->select( '*' );
		$this->db->from( $table_name );
		if( !empty($where) ){
			$this->db->where( $where );
		}
		
		if(!empty($like)){
			if($pos == '')
				$this->db->like($like, $value);
			else
				$this->db->like($like, $value, $pos);
		}
		$this->db->order_by('id', 'desc');
		
		$query = $this->db->get();		
        return $query->result_array();
	}
	
	public function get_join_data( $table_name, $join_table, $on, $where = array(), $field = '*', $order = array(), $join = 'inner', $group = '' ){
		$this->db->select( $field );
		$this->db->from( $table_name );
		
		if(!empty($join_table) && !empty($on)){
			$this->db->join( $join_table, $on, $join );
		}
		
		if( !empty($where) ){
			$this->db->where( $where );
		}
		
		if(!empty($order)){
			foreach($order as $k=>$v){
				$this->db->order_by($k, $v);
			}
		}
		
		if( !empty($group) ){
			$this->db->group_by( $group ); 
		}
		
		$query = $this->db->get();
        return $query->result_array();
	}
	
	public function get_inornot_data( $table_name=false, $where = array(), $field = '*', $target=false, $where_in=false, $in=false ){
		$this->db->select( $field );
		$this->db->from( $table_name );
				
		if( !empty($where_in) ){
			if($in == 'yes'){
				$this->db->where_in( $target, $where_in );
			}else{
				$this->db->where_not_in( $target, $where_in );
			}
		}
		
		if( !empty($where) ){
			$this->db->where( $where );
		}
		
		$query = $this->db->get();
        return $query->result_array();
	}
	
	public function get_multijoin_data( $table_name, $join_table = array(), $where = array(), $field = '*', $join = 'left', $group = '' , $orderby = '' , $limit = '' ){
		$this->db->select( $field );
		$this->db->from( $table_name );
		
		if(!empty($join_table)){
			foreach($join_table as $table=>$on){
				$this->db->join( $table, $on, $join );
			}
		}
		
		if( !empty($where) ){
			$this->db->where( $where );
		}
		
		if( !empty($group) ){
			$this->db->group_by( $group ); 
		}
		
		if( !empty($limit) ){
			$this->db->limit($limit[0], $limit[1]);
		}
		
		if( !empty($orderby) ){
			$this->db->order_by($orderby[0], $orderby[1]);
		}
		
		$query = $this->db->get();
        return $query->result_array();
	}
	
	public function get_like_data( $table_name, $where = array(), $like = array() , $field = '*', $group = '', $orderby = '' ) {
		$this->db->select( $field );
		$this->db->from( $table_name );
		if( !empty($where) ){
			$this->db->where( $where );
		}
		if( !empty($group) ){
			$this->db->group_by( $group ); 
		}
		if( !empty($like) ){
			$this->db->like($like[0], $like[1] );
		}
		if( !empty($orderby) ){
			$this->db->order_by($orderby[0], $orderby[1]);
		}
		$query = $this->db->get();
        return $query->result_array();
	}
	
	public function query( $query, $return = true ){
		$query = $this->db->query( $query );
		if($return){
			return $query->result_array();
		}
	}
	
	function select_data_lp($field , $table , $where = '' , $limit = '' , $order = '' , $like = '' , $join_array = '' , $group = ''){ 
		$this->db->select($field);
		$this->db->from($table);
		if($where != ""){ 
			$this->db->where($where);
		}
	
		if($join_array != ''){
			if(in_array('multiple',$join_array)){
				foreach($join_array['1'] as $joinArray){
					$this->db->join($joinArray[0], $joinArray[1]);
				}
			}else{
				$this->db->join($join_array[0], $join_array[1]);
			}
		}
		
		if($order != ""){
			$this->db->order_by($order['0'] , $order['1']);
		}
		
		if($group != ""){
			$this->db->group_by($group);
		}
		
		if($limit != ""){
			if(count($limit)>1){
				$this->db->limit($limit['0'] , $limit['1']);
			}else{
				$this->db->limit($limit);
			}
			
		}
		
		
		if($like != ""){
			if( $like['1'] != "0" )
			{
				$like_key = explode(',',$like['0']);
				$like_data = explode(',',$like['1']);
				if( count($like_key) == 1 ){
					$this->db->like($like_key[0] , $like_data[0]);
				}
				else{
					if( count($like_data) == 1 ){
						for($i=0; $i<count($like_key); $i++){
							if( $i == 0 )
								$this->db->like($like_key[$i] , $like_data[0]);
							else
								$this->db->or_like($like_key[$i] , $like_data[0]);
						}
					}
					else{
						for($i=0; $i<count($like_key); $i++){
							if($like_data[$i] != ''){
								if( $i == 0 )
									$this->db->like($like_key[$i] , $like_data[$i]);
								else
									$this->db->or_like($like_key[$i] , $like_data[$i]);
							}
						}
					}
				}
			} 
		}	
		return $this->db->get()->result_array();
		die();
	}
	
}
?>