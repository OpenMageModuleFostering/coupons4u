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
 * EinfochipsCoupons4U admin edit block
 *
 * @category	Einfochips
 * @package		Einfochips_Coupons4U
 * @author 		e-Infochips
 */
class Einfochips_Coupons4U_Block_Adminhtml_Einfochipscoupons4u_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
	/**
	 * constuctor
	 * @access public
	 * @return void
	 * @author e-Infochips
	 */
	public function __construct(){
		parent::__construct();
		$this->_blockGroup = 'coupons4u';
		$this->_controller = 'adminhtml_einfochipscoupons4u';
		$this->_removeButton('save');
		$this->_removeButton('reset');
		
	}
	/**
	 * get the edit form header
	 * @access public
	 * @return string
	 * @author e-Infochips
	 */
	public function getHeaderText(){
		if( Mage::registry('einfochipscoupons4u_data') && Mage::registry('einfochipscoupons4u_data')->getId() ) {
			return Mage::helper('coupons4u')->__("Edit EinfochipsCoupons4U '%s'", $this->htmlEscape(Mage::registry('einfochipscoupons4u_data')->getCouponId()));
		} 
		else {
			return Mage::helper('coupons4u')->__('Assign Coupons');
		}
	}
}