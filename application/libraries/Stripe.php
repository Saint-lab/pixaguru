<?php 
/* * ***
 * Version: 1.0.0
 *
 * Description of Stripe Payment Gateway Library
 *
 * @package: CodeIgniter
 * @category: Libraries
 * @author TechArise Team
 * @email  info@techarise.com
 *
 * *** */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class Stripe{ 
   
    function __construct(){ 
        
        require APPPATH .'third_party/stripe/stripe-php/init.php'; 
    }
        
}