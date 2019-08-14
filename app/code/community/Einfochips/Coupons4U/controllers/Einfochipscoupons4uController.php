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
 * EinfochipsCoupons4U front contrller
 *
 * @category	Einfochips
 * @package		Einfochips_Coupons4U
 * @author e-Infochips
 */
class Einfochips_Coupons4U_Einfochipscoupons4uController extends Mage_Core_Controller_Front_Action{
	/**
 	 * default action
 	 * @access public
 	 * @return void
 	 * @author e-Infochips
 	 */
 	public function indexAction(){
		$this->loadLayout();
 		if (Mage::helper('coupons4u/einfochipscoupons4u')->getUseBreadcrumbs()){
			if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')){
				$breadcrumbBlock->addCrumb('home', array(
							'label'	=> Mage::helper('coupons4u')->__('Home'), 
							'link' 	=> Mage::getUrl(),
						)
				);
				$breadcrumbBlock->addCrumb('einfochipscoupons4us', array(
							'label'	=> Mage::helper('coupons4u')->__('EinfochipsCoupons4U'), 
							'link'	=> '',
					)
				);
			}
		}
		$headBlock = $this->getLayout()->getBlock('head');
		if ($headBlock) {
			$headBlock->setTitle(Mage::getStoreConfig('coupons4u/einfochipscoupons4u/meta_title'));
			$headBlock->setKeywords(Mage::getStoreConfig('coupons4u/einfochipscoupons4u/meta_keywords'));
			$headBlock->setDescription(Mage::getStoreConfig('coupons4u/einfochipscoupons4u/meta_description'));
		}
		$this->renderLayout();
	}
	/**
 	 * view einfochipscoupons4u action
 	 * @access public
 	 * @return void
 	 * @author e-Infochips
 	 */
	public function viewAction(){
	}
}