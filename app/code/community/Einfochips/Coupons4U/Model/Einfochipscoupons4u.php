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
 * EinfochipsCoupons4U model
 *
 * @category	Einfochips
 * @package		Einfochips_Coupons4U
 * @author e-Infochips
 */
class Einfochips_Coupons4U_Model_Einfochipscoupons4u extends Mage_Core_Model_Abstract{
	/**
	 * Entity code.
	 * Can be used as part of method name for entity processing
	 */
	const ENTITY= 'coupons4u_einfochipscoupons4u';
	const CACHE_TAG = 'coupons4u_einfochipscoupons4u';
	/**
	 * Prefix of model events names
	 * @var string
	 */
	protected $_eventPrefix = 'coupons4u_einfochipscoupons4u';
	
	/**
	 * Parameter name in event
	 * @var string
	 */
	protected $_eventObject = 'einfochipscoupons4u';
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author e-Infochips
	 */
	public function _construct(){
		parent::_construct();
		$this->_init('coupons4u/einfochipscoupons4u');
	}
	/**
	 * before save einfochipscoupons4u
	 * @access protected
	 * @return Einfochips_Coupons4U_Model_Einfochipscoupons4u
	 * @author e-Infochips
	 */
	protected function _beforeSave(){
		parent::_beforeSave();
		$now = Mage::getSingleton('core/date')->gmtDate();
		if ($this->isObjectNew()){
			$this->setCreatedAt($now);
		}
		$this->setUpdatedAt($now);
		return $this;
	}
	/**
	 * get the url to the einfochipscoupons4u details page
	 * @access public
	 * @return string
	 * @author e-Infochips
	 */
	public function getEinfochipscoupons4uUrl(){
		if ($this->getUrlKey()){
			return Mage::getUrl('', array('_direct'=>$this->getUrlKey()));
		}
		return Mage::getUrl('coupons4u/einfochipscoupons4u/view', array('id'=>$this->getId()));
	}
	/**
	 * check URL key
	 * @access public
	 * @param string $urlKey
	 * @param bool $active
	 * @return mixed
	 * @author e-Infochips
	 */
	public function checkUrlKey($urlKey, $active = true){
		return $this->_getResource()->checkUrlKey($urlKey, $active);
	}
	/**
	 * save einfochipscoupons4u relation
	 * @access public
	 * @return Einfochips_Coupons4U_Model_Einfochipscoupons4u
	 * @author e-Infochips
	 */
	protected function _afterSave() {
		return parent::_afterSave();
	}
}