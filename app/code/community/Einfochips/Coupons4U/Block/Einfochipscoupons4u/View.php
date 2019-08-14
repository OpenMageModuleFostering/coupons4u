<?php 
/**
 * Einfochips_Coupons4U extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	Einfochips
 * @package		Einfochips_Coupons4U
 * @copyright  	Copyright (c) 2014
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * EinfochipsCoupons4U view block
 *
 * @category	Einfochips
 * @package		Einfochips_Coupons4U
 * @author 		e-Infochips
 */
class Einfochips_Coupons4U_Block_Einfochipscoupons4u_View extends Mage_Core_Block_Template{
	/**
	 * get the current einfochipscoupons4u
	 * @access public
	 * @return mixed (Einfochips_Coupons4U_Model_Einfochipscoupons4u|null)
	 * @author e-Infochips
	 */
	public function getCurrentEinfochipscoupons4u(){
		return Mage::registry('current_coupons4u_einfochipscoupons4u');
	}
} 