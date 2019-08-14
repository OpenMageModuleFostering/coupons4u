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
 * Coupons4U module install script
 *
 * @category	Einfochips
 * @package		Einfochips_Coupons4U
 * @author e-Infochips
 */
$this->startSetup();
$table = $this->getConnection()
	->newTable($this->getTable('coupons4u/einfochipscoupons4u'))
	->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'identity'  => true,
		'nullable'  => false,
		'primary'   => true,
		), 'EinfochipsCoupons4U ID')
	->addColumn('rule_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'unsigned'  => true,
		), 'RuleId')

	->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'unsigned'  => true,
		), 'CustomerId')

	->addColumn('coupon_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'nullable'  => false,
		'unsigned'  => true,
		), 'CouponId')

	->addColumn('code', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		), 'CouponCode')

	->addColumn('url_key', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		), 'URL key')

	->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		), 'Status')

	->addColumn('meta_title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		), 'Meta title')

	->addColumn('meta_keywords', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
		), 'Meta keywords')

	->addColumn('meta_description', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
		), 'Meta description')

	->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
		), 'EinfochipsCoupons4U Creation Time')
	->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
		), 'EinfochipsCoupons4U Modification Time')
	->setComment('EinfochipsCoupons4U Table');
$this->getConnection()->createTable($table);

$table = $this->getConnection()
	->newTable($this->getTable('coupons4u/einfochipscoupons4u_store'))
	->addColumn('einfochipscoupons4u_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
		'nullable'  => false,
		'primary'   => true,
		), 'EinfochipsCoupons4U ID')
	->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
		'unsigned'  => true,
		'nullable'  => false,
		'primary'   => true,
		), 'Store ID')
	->addIndex($this->getIdxName('coupons4u/einfochipscoupons4u_store', array('store_id')), array('store_id'))
	->addForeignKey($this->getFkName('coupons4u/einfochipscoupons4u_store', 'einfochipscoupons4u_id', 'coupons4u/einfochipscoupons4u', 'entity_id'), 'einfochipscoupons4u_id', $this->getTable('coupons4u/einfochipscoupons4u'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
	->addForeignKey($this->getFkName('coupons4u/einfochipscoupons4u_store', 'store_id', 'core/store', 'store_id'), 'store_id', $this->getTable('core/store'), 'store_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
	->setComment('EinfochipsCoupons4U To Store Linkage Table');
$this->getConnection()->createTable($table);
$this->endSetup();