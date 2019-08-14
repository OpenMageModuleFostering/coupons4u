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
 * EinfochipsCoupons4U admin block
 *
 * @category	Einfochips
 * @package		Einfochips_Coupons4U
 * @author 		e-Infochips
 */
class Einfochips_Coupons4U_Block_Adminhtml_Einfochipscoupons4u extends Mage_Adminhtml_Block_Widget_Grid_Container{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author e-Infochips
	 */
	public function __construct(){
		$this->_controller 		= 'adminhtml_einfochipscoupons4u';
		$this->_blockGroup 		= 'coupons4u';
		$this->_headerText 		= Mage::helper('coupons4u')->__('EinfochipsCoupons4U');
		$this->_addButtonLabel 	= Mage::helper('coupons4u')->__('View Assign Coupons');
		parent::__construct();
	}
}