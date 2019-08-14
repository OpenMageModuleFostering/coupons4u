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
 * EinfochipsCoupons4U widget block
 *
 * @category	Einfochips
 * @package		Einfochips_Coupons4U
 * @author 		e-Infochips
 */
class Einfochips_Coupons4U_Block_Einfochipscoupons4u_Widget_View extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface{
	protected $_htmlTemplate = 'einfochips_coupons4u/einfochipscoupons4u/widget/view.phtml';
	/**
	 * Prepare a for widget
	 * @access protected
	 * @return Einfochips_Coupons4U_Block_Einfochipscoupons4u_Widget_View
	 * @author e-Infochips
	 */
	protected function _beforeToHtml() {
		parent::_beforeToHtml();
		$einfochipscoupons4uId = $this->getData('einfochipscoupons4u_id');
		if ($einfochipscoupons4uId) {
			$einfochipscoupons4u = Mage::getModel('coupons4u/einfochipscoupons4u')
				->setStoreId(Mage::app()->getStore()->getId())
				->load($einfochipscoupons4uId);
		if ($einfochipscoupons4u->getStatus()) {
				$this->setCurrentEinfochipscoupons4u($einfochipscoupons4u);
				$this->setTemplate($this->_htmlTemplate);
			}
		}
		return $this;
	}
}