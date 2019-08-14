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
 * EinfochipsCoupons4U admin widget chooser
 *
 * @category	Einfochips
 * @package		Einfochips_Coupons4U
 * @author e-Infochips
 */
class Einfochips_Coupons4U_Block_Adminhtml_Einfochipscoupons4u_Widget_Chooser extends Mage_Adminhtml_Block_Widget_Grid{
	/**
	 * Block construction, prepare grid params
	 * @access public
	 * @param array $arguments Object data
	 * @return void
	 * @author e-Infochips
	 */
	public function __construct($arguments=array()){
		parent::__construct($arguments);
		$this->setDefaultSort('entity_id');
		$this->setDefaultDir('ASC');
		$this->setUseAjax(true);
		$this->setDefaultFilter(array('chooser_status' => '1'));
	}
	/**
	 * Prepare chooser element HTML
	 * @access public
	 * @param Varien_Data_Form_Element_Abstract $element Form Element
	 * @return Varien_Data_Form_Element_Abstract
	 * @author e-Infochips
	 */
	public function prepareElementHtml(Varien_Data_Form_Element_Abstract $element){
		$uniqId = Mage::helper('core')->uniqHash($element->getId());
		$sourceUrl = $this->getUrl('coupons4u/adminhtml_coupons4u_einfochipscoupons4u_widget/chooser', array('uniq_id' => $uniqId));
		$chooser = $this->getLayout()->createBlock('widget/adminhtml_widget_chooser')
				->setElement($element)
				->setTranslationHelper($this->getTranslationHelper())
				->setConfig($this->getConfig())
				->setFieldsetId($this->getFieldsetId())
				->setSourceUrl($sourceUrl)
				->setUniqId($uniqId);
		if ($element->getValue()) {
			$einfochipscoupons4u = Mage::getModel('coupons4u/einfochipscoupons4u')->load($element->getValue());
			if ($einfochipscoupons4u->getId()) {
				$chooser->setLabel($einfochipscoupons4u->getCouponId());
			}
		}
		$element->setData('after_element_html', $chooser->toHtml());
		return $element;
	}
	/**
	 * Grid Row JS Callback
	 * @access public
	 * @return string
	 * @author e-Infochips
	 */
	public function getRowClickCallback(){
		$chooserJsObject = $this->getId();
		$js = '
			function (grid, event) {
				var trElement = Event.findElement(event, "tr");
				var einfochipscoupons4uId = trElement.down("td").innerHTML.replace(/^\s+|\s+$/g,"");
				var einfochipscoupons4uTitle = trElement.down("td").next().innerHTML;
				'.$chooserJsObject.'.setElementValue(einfochipscoupons4uId);
				'.$chooserJsObject.'.setElementLabel(einfochipscoupons4uTitle);
				'.$chooserJsObject.'.close();
			}
		';
		return $js;
	}
	/**
	 * Prepare a static blocks collection
	 * @access protected
	 * @return Einfochips_Coupons4U_Block_Adminhtml_Einfochipscoupons4u_Widget_Chooser
	 * @author e-Infochips
	 */
	protected function _prepareCollection(){
		$collection = Mage::getModel('coupons4u/einfochipscoupons4u')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	/**
	 * Prepare columns for the a grid
	 * @access protected 
	 * @return Einfochips_Coupons4U_Block_Adminhtml_Einfochipscoupons4u_Widget_Chooser
	 * @author e-Infochips
	 */
	protected function _prepareColumns(){
		$this->addColumn('chooser_id', array(
			'header'	=> Mage::helper('coupons4u')->__('Id'),
			'align' 	=> 'right',
			'index' 	=> 'entity_id',
			'type'		=> 'number',
			'width' 	=> 50
		));
		
		$this->addColumn('chooser_coupon_id', array(
			'header'=> Mage::helper('coupons4u')->__('CouponId'),
			'align' => 'left',
			'index' => 'coupon_id',
		));
		if (!Mage::app()->isSingleStoreMode()) {
			$this->addColumn('store_id', array(
				'header'=> Mage::helper('coupons4u')->__('Store Views'),
				'index' => 'store_id',
				'type'  => 'store',
				'store_all' => true,
				'store_view'=> true,
				'sortable'  => false,
			));
		}
		$this->addColumn('chooser_status', array(
			'header'=> Mage::helper('coupons4u')->__('Status'),
			'index' => 'status',
			'type'  => 'options',
			'options'   => array(
				0 => Mage::helper('coupons4u')->__('Disabled'),
				1 => Mage::helper('coupons4u')->__('Enabled')
			),
		));
		return parent::_prepareColumns();
	}
	/**
	 * get url for grid
	 * @access public
	 * @return string
	 * @author e-Infochips
	 */
	public function getGridUrl(){
		return $this->getUrl('adminhtml/coupons4u_einfochipscoupons4u_widget/chooser', array('_current' => true));
	}
	/**
	 * after collection load
	 * @access protected
	 * @return Einfochips_Coupons4U_Block_Adminhtml_Einfochipscoupons4u_Widget_Chooser
	 * @author e-Infochips
	 */
	protected function _afterLoadCollection(){
		$this->getCollection()->walk('afterLoad');
		parent::_afterLoadCollection();
	}
}