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
 * store selection tab
 *
 * @category	Einfochips
 * @package		Einfochips_Coupons4U
 * @author 		e-Infochips
 */
class Einfochips_Coupons4U_Block_Adminhtml_Einfochipscoupons4u_Edit_Tab_Stores extends Mage_Adminhtml_Block_Widget_Form{
	/**
	 * prepare the form
	 * @access protected
	 * @return Einfochips_Coupons4U_Block_Adminhtml_Einfochipscoupons4u_Edit_Tab_Stores
	 * @author e-Infochips
	 */
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$form->setFieldNameSuffix('einfochipscoupons4u');
		$this->setForm($form);
		$fieldset = $form->addFieldset('einfochipscoupons4u_stores_form', array('legend'=>Mage::helper('coupons4u')->__('Store views')));
		$field = $fieldset->addField('store_id', 'multiselect', array(
			'name'  => 'stores[]',
			'label' => Mage::helper('coupons4u')->__('Store Views'),
			'title' => Mage::helper('coupons4u')->__('Store Views'),
			'required'  => true,
			'values'=> Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
		));
		$renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
		$field->setRenderer($renderer);
  		$form->addValues(Mage::registry('current_einfochipscoupons4u')->getData());
		return parent::_prepareForm();
	}
}