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
 * EinfochipsCoupons4U edit form tab
 *
 * @category	Einfochips
 * @package		Einfochips_Coupons4U
 * @author 		e-Infochips
 */
class Einfochips_Coupons4U_Block_Adminhtml_Einfochipscoupons4u_Edit_Tab_Form extends Mage_Adminhtml_Block_Template{	
	/**
	 * prepare the form
	 * @access protected
	 * @return Coupons4U_Einfochipscoupons4u_Block_Adminhtml_Einfochipscoupons4u_Edit_Tab_Form
	 * @author e-Infochips
	 */
	
	protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('einfochipscoupons4u/edit/tab/viewassigncoupons.phtml');
	}
}