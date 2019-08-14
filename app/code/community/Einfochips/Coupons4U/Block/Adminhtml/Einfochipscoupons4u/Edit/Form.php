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
 * EinfochipsCoupons4U edit form
 *
 * @category	Einfochips
 * @package		Einfochips_Coupons4U
 * @author      e-Infochips
 */
class Einfochips_Coupons4U_Block_Adminhtml_Einfochipscoupons4u_Edit_Form extends Mage_Adminhtml_Block_Widget_Form{
	/**
	 * prepare form
	 * @access protected
	 * @return Einfochips_Coupons4U_Block_Adminhtml_Einfochipscoupons4u_Edit_Form
	 * @author e-Infochips
	 */
	protected function _prepareForm(){
		$form = new Varien_Data_Form(array(
						'id' 		=> 'edit_form',
						'action' 	=> $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
						'method' 	=> 'post',
						'enctype'	=> 'multipart/form-data'
					)
		);
		$form->setUseContainer(true);
		$this->setForm($form);
		return parent::_prepareForm();
	}
}