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
class Einfochips_Coupons4U_Block_Adminhtml_Einfochipscoupons4u_Edit_Tab_Meta extends Mage_Adminhtml_Block_Widget_Form{
	/**
	 * prepare the form
	 * @access protected
	 * @return Einfochips_Coupons4U_Block_Adminhtml_Einfochipscoupons4u_Edit_Tab_Meta
	 * @author e-Infochips
	 */
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$form->setFieldNameSuffix('einfochipscoupons4u');
		$this->setForm($form);
		$fieldset = $form->addFieldset('einfochipscoupons4u_meta_form', array('legend'=>Mage::helper('coupons4u')->__('Meta information')));
		$fieldset->addField('meta_title', 'text', array(
			'label' => Mage::helper('coupons4u')->__('Meta-title'),
			'name'  => 'meta_title',
		));
		$fieldset->addField('meta_description', 'textarea', array(
			'name'  	=> 'meta_description',
			'label' 	=> Mage::helper('coupons4u')->__('Meta-description'),
  		));
  		$fieldset->addField('meta_keywords', 'textarea', array(
			'name'  	=> 'meta_keywords',
			'label' 	=> Mage::helper('coupons4u')->__('Meta-keywords'),
  		));
  		$form->addValues(Mage::registry('current_einfochipscoupons4u')->getData());
		return parent::_prepareForm();
	}
}