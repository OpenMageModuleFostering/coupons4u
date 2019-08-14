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
 * EinfochipsCoupons4U helper
 *
 * @category	Einfochips
 * @package		Einfochips_Coupons4U
 * @author e-Infochips
 */
class Einfochips_Coupons4U_Helper_Einfochipscoupons4u extends Mage_Core_Helper_Abstract{
	/**
	 * check if breadcrumbs can be used
	 * @access public
	 * @return bool
	 * @author e-Infochips
	 */
	public function getUseBreadcrumbs(){
		return Mage::getStoreConfigFlag('coupons4u/einfochipscoupons4u/breadcrumbs');
	}
}