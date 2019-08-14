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
 * meta information tab
 *
 * @category	Einfochips
 * @package		Einfochips_Coupons4U
 * @author 		e-Infochips
 */
class Einfochips_Coupons4U_Block_Adminhtml_Einfochipscoupons4u_Edit_Tab_Viewassigncoupons extends Mage_Core_Block_Template{
	/**
	 * prepare the form
	 * @access protected
	 * @return Einfochips_Coupons4U_Block_Adminhtml_Einfochipscoupons4u_Edit_Tab_Viewassigncoupons
	 * @author e-Infochips
	 */
	
	protected function _construct()
    {
        parent::_construct();
		$collection = Mage::getModel('customer/customer')->getCollection();
        $this->setCollection($collection);
        
    }
	protected function _prepareLayout()
    {
        parent::_prepareLayout();
 
        $pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
        //$pager->setAvailableLimit(array(2=>2,3=>3,5=>5,'all'=>'all'));
        $pager->setCollection($this->getCollection());
        $this->setChild('pager', $pager);
        $this->getCollection()->load();
		$this->setTemplate('einfochipscoupons4u/edit/tab/viewassigncoupons.phtml');
        return $this;
    }
 
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
}