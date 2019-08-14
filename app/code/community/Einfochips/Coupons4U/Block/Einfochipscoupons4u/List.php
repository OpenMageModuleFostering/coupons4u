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
 * EinfochipsCoupons4U list block
 *
 * @category	Einfochips
 * @package		Einfochips_Coupons4U
 * @author 		e-Infochips
 */
class Einfochips_Coupons4U_Block_Einfochipscoupons4u_List extends Mage_Core_Block_Template{
	/**
	 * initialize
	 * @access public
	 * @return void
	 * @author e-Infochips
	 */
 	public function __construct(){
		parent::__construct();
 		$einfochipscoupons4us = Mage::getResourceModel('coupons4u/einfochipscoupons4u_collection')
 						->addStoreFilter(Mage::app()->getStore())
				->addFilter('status', 1)
		;
		$einfochipscoupons4us->setOrder('coupon_id', 'asc');
		$this->setEinfochipscoupons4us($einfochipscoupons4us);
	}
	/**
	 * prepare the layout
	 * @access protected
	 * @return Einfochips_Coupons4U_Block_Einfochipscoupons4u_List
	 * @author e-Infochips
	 */
	protected function _prepareLayout(){
		parent::_prepareLayout();
		$pager = $this->getLayout()->createBlock('page/html_pager', 'coupons4u.einfochipscoupons4u.html.pager')
			->setCollection($this->getEinfochipscoupons4us());
		$this->setChild('pager', $pager);
		$this->getEinfochipscoupons4us()->load();
		return $this;
	}
	/**
	 * get the pager html
	 * @access public
	 * @return string
	 * @author e-Infochips
	 */
	public function getPagerHtml(){
		return $this->getChildHtml('pager');
	}
}