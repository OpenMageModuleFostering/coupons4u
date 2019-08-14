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
 * Router
 *
 * @category	Einfochips
 * @package		Einfochips_Coupons4U
 * @author 		e-Infochips
 */
class Einfochips_Coupons4U_Controller_Router extends Mage_Core_Controller_Varien_Router_Abstract{
	/**
	 * init routes
	 * @access public
	 * @param Varien_Event_Observer $observer
	 * @return Einfochips_Coupons4U_Controller_Router
	 * @author e-Infochips
	 */
	public function initControllerRouters($observer){
		$front = $observer->getEvent()->getFront();
		$front->addRouter('coupons4u', $this);
		return $this;
	}
	/**
	 * Validate and match entities and modify request
	 * @access public
	 * @param Zend_Controller_Request_Http $request
	 * @return bool
	 * @author e-Infochips
	 */
	public function match(Zend_Controller_Request_Http $request){
		if (!Mage::isInstalled()) {
			Mage::app()->getFrontController()->getResponse()
				->setRedirect(Mage::getUrl('install'))
				->sendResponse();
			exit;
		}
		$urlKey = trim($request->getPathInfo(), '/');
		$check = array();
		$check['einfochipscoupons4u'] = new Varien_Object(array(
			'model'      =>'coupons4u/einfochipscoupons4u',
			'controller' => 'einfochipscoupons4u',
			'action'     => 'view',
			'param'	=> 'id',
		));
		foreach ($check as $key=>$settings){
			$model = Mage::getModel($settings->getModel());
			$id = $model->checkUrlKey($urlKey, Mage::app()->getStore()->getId());
			if ($id){
				$request->setModuleName('coupons4u')
					->setControllerName($settings->getController())
					->setActionName($settings->getAction())
					->setParam($settings->getParam(), $id);
				$request->setAlias(
					Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS,
					$urlKey
				);
				return true;
			}
		}
		return false;
	}
}