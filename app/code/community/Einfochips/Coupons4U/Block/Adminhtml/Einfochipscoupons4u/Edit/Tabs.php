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
 * EinfochipsCoupons4U admin edit tabs
 *
 * @category	Einfochips
 * @package		Einfochips_Coupons4U
 * @author 		e-Infochips
 */
class Einfochips_Coupons4U_Block_Adminhtml_Einfochipscoupons4u_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author e-Infochips
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('einfochipscoupons4u_tabs');
		$this->setDestElementId('edit_form');
		
		$this->setTitle(Mage::helper('coupons4u')->__('EinfochipsCoupons4U'));
	}
	/**
	 * before render html
	 * @access protected
	 * @return Einfochips_Coupons4U_Block_Adminhtml_Einfochipscoupons4u_Edit_Tabs
	 * @author e-Infochips
	 */
	protected function _beforeToHtml(){
		$this->addTab('form_einfochipscoupons4u', array(
			'label'		=> Mage::helper('coupons4u')->__('View Details'),
			'title'		=> Mage::helper('coupons4u')->__('View Details'),
			'content' 	=> $this->getLayout()->createBlock('coupons4u/adminhtml_einfochipscoupons4u_edit_tab_viewassigncoupons')->toHtml(),
		));
		return parent::_beforeToHtml();
	}
}