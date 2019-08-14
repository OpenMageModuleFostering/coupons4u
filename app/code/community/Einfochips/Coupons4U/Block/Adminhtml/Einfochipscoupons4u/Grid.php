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
 * EinfochipsCoupons4U admin grid block
 *
 * @category	Einfochips
 * @package		Einfochips_Coupons4U
 * @author 		e-Infochips
 */
class Einfochips_Coupons4U_Block_Adminhtml_Einfochipscoupons4u_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author e-Infochips
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('einfochipscoupons4uGrid');
		$this->setDefaultSort('entity_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
	}
	/**
	 * prepare collection
	 * @access protected
	 * @return Einfochips_Coupons4U_Block_Adminhtml_Einfochipscoupons4u_Grid
	 * @author e-Infochips
	 */
	protected function _prepareCollection(){
				/* Get the usage coupon limit */
		$couponIds 	   = array();
		$couponAssign  = array();
		$usageLimit    = array();
		$coupons_array = array();

		$resource = Mage::getSingleton('core/resource');
		$readConnection = $resource->getConnection('core_read');
		
		
		$query = "select e.coupon_id,b.usage_limit from salesrule_coupon e   JOIN salesrule_coupon b
		ON e.times_used  <=  b.usage_limit  AND  e.coupon_id = b.coupon_id";
		
		$results = $readConnection->fetchall($query);
		
		foreach($results as $k=>$v) {
			$couponIds[]  = $v['coupon_id'];
			$usageLimit[] = $v['usage_limit'];
		}
		
		$coupons = implode(",",$couponIds);
		if($coupons=="") {
			Mage::getSingleton('adminhtml/session')->addSuccess('Coupons Not Present. Please create shopping cart rule and generate couponcode');
		}
		else {
			$query2="select coupon_id,count(coupon_id) as used
						from coupons4u_einfochipscoupons4u Where coupon_id IN (".$coupons.") GROUP BY coupon_id";
				
			$results2 = $readConnection->fetchall($query2);
			
			foreach($results2 as $k=>$v) {
				$keyVal = array_search($v['coupon_id'],$couponIds);
				if($v['used']==$usageLimit[$keyVal]) {
					$couponAssign[] = $couponIds[$keyVal];
				}
			}
		}
		$filter   = $this->getParam($this->getVarNameFilter(), null);
					
        $couponsCollection  = Mage::getResourceModel('salesrule/coupon_collection')
							->addGeneratedCouponsFilter()
					        ->addFieldToFilter('coupon_id',array('in'=>array_diff($couponIds,$couponAssign)));
		if (is_null($filter)) {
			$filter = $this->_defaultFilter;
		}
		$this->setCollection($couponsCollection);
	    return parent::_prepareCollection();
	}
	/**
	 * prepare grid collection
	 * @access protected
	 * @return Einfochips_Coupons4U_Block_Adminhtml_Einfochipscoupons4u_Grid
	 * @author e-Infochips
	 */
	protected function _prepareColumns(){
		 /* Drop Down for Rules */
		$ruleCollection =  Mage::getResourceModel('salesrule/rule_collection');
		$ruleArray = array();
		foreach($ruleCollection as $releData){
				$ruleArray[$releData->getData('rule_id')] = $releData->getData('name'); 
		}
		
		$this->addColumn('code', array(
            'header' => Mage::helper('salesrule')->__('Coupon Code'),
            'index'  => 'code'
        ));

       $this->addColumn("rule_id", array(
            'header'    => Mage::helper('salesrule')->__('Rule'),
            'type' => 'options',
			'index'    => 'rule_id',
            'options'=> $ruleArray
	        ));
        return parent::_prepareColumns();
	}
	/**
	 * prepare mass action
	 * @access protected
	 * @return Einfochips_Coupons4U_Block_Adminhtml_Einfochipscoupons4u_Grid
	 * @author e-Infochips
	 */
	protected function _prepareMassaction(){
		$this->setMassactionIdField('coupon_id');
        $this->getMassactionBlock()->setFormFieldName('ids');
		$this->getMassactionBlock()->setUseAjax(false);
        $this->getMassactionBlock()->setHideFormElement(true);

        $this->getMassactionBlock()->addItem('delete', array(
             'label'=> Mage::helper('adminhtml')->__('Assign'),
             'url'  => $this->getUrl('*/*/assign', array('_current' => true)),
             'complete' => 'refreshCouponCodesGrid'
        ));
	    return $this;
	}
	/**
	 * get the row url
	 * @access public
	 * @param Einfochips_Coupons4U_Model_Einfochipscoupons4u
	 * @return string
	 * @author e-Infochips
	 */
	public function getRowUrl($row){
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}
	/**
	 * get the grid url
	 * @access public
	 * @return string
	 * @author e-Infochips
	 */
	public function getGridUrl(){
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}
	/**
	 * after collection load
	 * @access protected
	 * @return Einfochips_Coupons4U_Block_Adminhtml_Einfochipscoupons4u_Grid
	 * @author e-Infochips
	 */
	protected function _afterLoadCollection(){
		$this->getCollection()->walk('afterLoad');
		parent::_afterLoadCollection();
	}
	/**
	 * filter store column
	 * @access protected
	 * @param Einfochips_Coupons4U_Model_Resource_Einfochipscoupons4u_Collection $collection
	 * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
	 * @return Einfochips_Coupons4U_Block_Adminhtml_Einfochipscoupons4u_Grid
	 * @author e-Infochips
	 */
	protected function _filterStoreCondition($collection, $column){
		if (!$value = $column->getFilter()->getValue()) {
        	return;
		}
		$collection->addStoreFilter($value);
		return $this;
    }
}