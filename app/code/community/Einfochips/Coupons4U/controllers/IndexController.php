<?php

class Einfochips_Coupons4U_IndexController extends Mage_Core_Controller_Front_Action {
    public function indexAction()
    {
        //var_dump(__METHOD__);
		$this->loadLayout();
		$this->renderLayout();
    }
	public function preDispatch()
    {
        parent::preDispatch();
        $action = $this->getRequest()->getActionName();
        $loginUrl = Mage::helper('customer')->getLoginUrl();
 
        if (!Mage::getSingleton('customer/session')->authenticate($this, $loginUrl)) {
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
        }
    }  
}    