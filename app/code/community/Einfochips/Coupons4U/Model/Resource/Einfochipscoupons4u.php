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
 * EinfochipsCoupons4U resource model
 *
 * @category	Einfochips
 * @package		Einfochips_Coupons4U
 * @author e-Infochips
 */
class Einfochips_Coupons4U_Model_Resource_Einfochipscoupons4u extends Mage_Core_Model_Resource_Db_Abstract{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author e-Infochips
	 */
	public function _construct(){
		$this->_init('coupons4u/einfochipscoupons4u', 'entity_id');
	}
	
	/**
	 * Get store ids to which specified item is assigned
	 * @access public
	 * @param int $einfochipscoupons4uId
	 * @return array
	 * @author e-Infochips
	 */
	public function lookupStoreIds($einfochipscoupons4uId){
		$adapter = $this->_getReadAdapter();
		$select  = $adapter->select()
			->from($this->getTable('coupons4u/einfochipscoupons4u_store'), 'store_id')
			->where('einfochipscoupons4u_id = ?',(int)$einfochipscoupons4uId);
		return $adapter->fetchCol($select);
	}
	/**
	 * Perform operations after object load
	 * @access public
	 * @param Mage_Core_Model_Abstract $object
	 * @return Einfochips_Coupons4U_Model_Resource_Einfochipscoupons4u
	 * @author e-Infochips
	 */
	protected function _afterLoad(Mage_Core_Model_Abstract $object){
		if ($object->getId()) {
			$stores = $this->lookupStoreIds($object->getId());
			$object->setData('store_id', $stores);
		}
		return parent::_afterLoad($object);
	}

	/**
	 * Retrieve select object for load object data
	 *
	 * @param string $field
	 * @param mixed $value
	 * @param Einfochips_Coupons4U_Model_Einfochipscoupons4u $object
	 * @return Zend_Db_Select
	 */
	protected function _getLoadSelect($field, $value, $object){
		$select = parent::_getLoadSelect($field, $value, $object);
		if ($object->getStoreId()) {
			$storeIds = array(Mage_Core_Model_App::ADMIN_STORE_ID, (int)$object->getStoreId());
			$select->join(
				array('coupons4u_einfochipscoupons4u_store' => $this->getTable('coupons4u/einfochipscoupons4u_store')),
				$this->getMainTable() . '.entity_id = coupons4u_einfochipscoupons4u_store.einfochipscoupons4u_id',
				array()
			)
			->where('coupons4u_einfochipscoupons4u_store.store_id IN (?)', $storeIds)
			->order('coupons4u_einfochipscoupons4u_store.store_id DESC')
			->limit(1);
		}
		return $select;
	}
	/**
	 * Assign einfochipscoupons4u to store views
	 * @access protected
	 * @param Mage_Core_Model_Abstract $object
	 * @return Einfochips_Coupons4U_Model_Resource_Einfochipscoupons4u
	 * @author e-Infochips
	 */
	protected function _afterSave(Mage_Core_Model_Abstract $object){
		$oldStores = $this->lookupStoreIds($object->getId());
		$newStores = (array)$object->getStores();
		if (empty($newStores)) {
			$newStores = (array)$object->getStoreId();
		}
		$table  = $this->getTable('coupons4u/einfochipscoupons4u_store');
		$insert = array_diff($newStores, $oldStores);
		$delete = array_diff($oldStores, $newStores);
		if ($delete) {
			$where = array(
				'einfochipscoupons4u_id = ?' => (int) $object->getId(),
				'store_id IN (?)' => $delete
			);
			$this->_getWriteAdapter()->delete($table, $where);
		}
		if ($insert) {
			$data = array();
			foreach ($insert as $storeId) {
				$data[] = array(
					'einfochipscoupons4u_id'  => (int) $object->getId(),
					'store_id' => (int) $storeId
				);
			}
			$this->_getWriteAdapter()->insertMultiple($table, $data);
		}
		return parent::_afterSave($object);
	}	/**
	 * check url key
	 * @access public
	 * @param string $urlKey
	 * @param bool $active
	 * @return mixed
	 * @author e-Infochips
	 */
	public function checkUrlKey($urlKey, $storeId, $active = true){
		$stores = array(Mage_Core_Model_App::ADMIN_STORE_ID, $storeId);
		$select = $this->_initCheckUrlKeySelect($urlKey, $stores);
		if (!is_null($active)) {
			$select->where('e.status = ?', $active);
		}
		$select->reset(Zend_Db_Select::COLUMNS)
			->columns('e.entity_id')
			->limit(1);
		
		return $this->_getReadAdapter()->fetchOne($select);
	}
	/**
	 * init the check select
	 * @access protected
	 * @param string $urlKey
 	 * @param array $store
	 * @return Zend_Db_Select
	 * @author e-Infochips
	 */
	protected function _initCheckUrlKeySelect($urlKey, $store){
		$select = $this->_getReadAdapter()->select()
			->from(array('e' => $this->getMainTable()))
			->join(
				array('es' => $this->getTable('coupons4u/einfochipscoupons4u_store')),
				'e.entity_id = es.einfochipscoupons4u_id',
				array())
			->where('e.url_key = ?', $urlKey)
			->where('es.store_id IN (?)', $store);
		return $select;
	}
	/**
	 * Check for unique URL key
	 * @access public
	 * @param Mage_Core_Model_Abstract $object
	 * @return bool
	 * @author e-Infochips
	 */
	public function getIsUniqueUrlKey(Mage_Core_Model_Abstract $object){
		if (Mage::app()->isSingleStoreMode() || !$object->hasStores()) {
			$stores = array(Mage_Core_Model_App::ADMIN_STORE_ID);
		} 
		else {
			$stores = (array)$object->getData('stores');
		}
		$select = $this->_initCheckUrlKeySelect($object->getData('url_key'), $stores);
		if ($object->getId()) {
			$select->where('e.entity_id <> ?', $object->getId());
		}
		if ($this->_getWriteAdapter()->fetchRow($select)) {
			return false;
		}
		return true;
	}
	/**
	 * Check if the URL key is numeric
	 * @access public
	 * @param Mage_Core_Model_Abstract $object
	 * @return bool
	 * @author e-Infochips
	 */
	protected function isNumericUrlKey(Mage_Core_Model_Abstract $object){
		return preg_match('/^[0-9]+$/', $object->getData('url_key'));
	}
	/**
	 * Checkif the URL key is valid
	 * @access public
	 * @param Mage_Core_Model_Abstract $object
	 * @return bool
	 * @author e-Infochips
	 */
	protected function isValidUrlKey(Mage_Core_Model_Abstract $object){
		return preg_match('/^[a-z0-9][a-z0-9_\/-]+(\.[a-z0-9_-]+)?$/', $object->getData('url_key'));
	}
	/**
	 * validate before saving
	 * @access protected
	 * @param $object
	 * @return Einfochips_Coupons4U_Model_Resource_Einfochipscoupons4u
	 * @author e-Infochips 
	 */
	protected function _beforeSave(Mage_Core_Model_Abstract $object){
		/*if (!$this->getIsUniqueUrlKey($object)) {
			Mage::throwException(Mage::helper('coupons4u')->__('URL key already exists.'));
		}
		if (!$this->isValidUrlKey($object)) {
			Mage::throwException(Mage::helper('coupons4u')->__('The URL key contains capital letters or disallowed symbols.'));
		}
		if ($this->isNumericUrlKey($object)) {
			Mage::throwException(Mage::helper('coupons4u')->__('The URL key cannot consist only of numbers.'));
		}*/ 
		return parent::_beforeSave($object);
	}}