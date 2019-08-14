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
 * EinfochipsCoupons4U admin controller
 *
 * @category	Einfochips
 * @package		Einfochips_Coupons4U
 * @author 		e-Infochips
 */
class Einfochips_Coupons4U_Adminhtml_Coupons4U_Einfochipscoupons4uController extends Einfochips_Coupons4U_Controller_Adminhtml_Coupons4U{
	/**
	 * init the einfochipscoupons4u
	 * @access protected
	 * @return Einfochips_Coupons4U_Model_Einfochipscoupons4u
	 */
	protected $_publicActions = array('view');
	protected function _initEinfochipscoupons4u(){
		$einfochipscoupons4uId  = (int) $this->getRequest()->getParam('id');
		$einfochipscoupons4u	= Mage::getModel('coupons4u/einfochipscoupons4u');
		if ($einfochipscoupons4uId) {
			$einfochipscoupons4u->load($einfochipscoupons4uId);
		}
		Mage::register('current_einfochipscoupons4u', $einfochipscoupons4u);
		return $einfochipscoupons4u;
	}
 	/**
	 * default action
	 * @access public
	 * @return void
	 * @author e-Infochips
	 */
	
	public function viewAction() {
		$this->loadLayout();
		$this->_title(Mage::helper('coupons4u')->__('Coupons4U'))
			 ->_title(Mage::helper('coupons4u')->__('EinfochipsCoupons4U'));
		$this->renderLayout();
	}
	public function indexAction() {
		$this->loadLayout();
		$this->_title(Mage::helper('coupons4u')->__('Coupons4U'))
			 ->_title(Mage::helper('coupons4u')->__('EinfochipsCoupons4U'));
		$this->renderLayout();
	}
	/**
	 * grid action
	 * @access public
	 * @return void
	 * @author e-Infochips
	 */
	public function gridAction() {
		$this->loadLayout()->renderLayout();
	}
	/**
	 * edit einfochipscoupons4u - action
	 * @access public
	 * @return void
	 * @author e-Infochips
	 */
	public function editAction() {
		$einfochipscoupons4uId	= $this->getRequest()->getParam('id');
		$einfochipscoupons4u  	= $this->_initEinfochipscoupons4u();
		if ($einfochipscoupons4uId && !$einfochipscoupons4u->getId()) {
			$this->_getSession()->addError(Mage::helper('coupons4u')->__('This einfochipscoupons4u no longer exists.'));
			$this->_redirect('*/*/');
			return;
		}
		$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
		if (!empty($data)) {
			$einfochipscoupons4u->setData($data);
		}
		Mage::register('einfochipscoupons4u_data', $einfochipscoupons4u);
		$this->loadLayout();
		$this->_title(Mage::helper('coupons4u')->__('Coupons4U'))
			 ->_title(Mage::helper('coupons4u')->__('EinfochipsCoupons4U'));
		if ($einfochipscoupons4u->getId()){
			$this->_title($einfochipscoupons4u->getCouponId());
		}
		else{
			//$this->_title(Mage::helper('coupons4u')->__('Add einfochipscoupons4u'));
		}
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) { 
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true); 
		}
		$this->renderLayout();
	}
	/**
	 * new einfochipscoupons4u action
	 * @access public
	 * @return void
	 * @author e-Infochips
	 */
	public function newAction() {
		$this->_forward('edit');
	}
	
	/**
     * Coupons mass assign action
     */
    public function assignAction()
    {
        
		$this->loadLayout();
		$coupons_array = array();
	
		$codesIds = $this->getRequest()->getParam('ids');
		if (is_array($codesIds)) {

            $couponsCollection = Mage::getResourceModel('salesrule/coupon_collection')
                ->addFieldToFilter('coupon_id', array('in' => $codesIds));
            
			foreach ($couponsCollection as $coupon) {
				$coupons_array[0][$coupon->getId()] = $coupon->getCode(); 
				$coupons_array[1] = $coupon->getRuleId();
				$coupons_array[2] = $coupon->getUsageLimit();
				$coupons_array[3] = $coupon->getUsagePerCustomer();
				$coupons_array[4][$coupon->getId()]	= $coupon->getTimesUsed();
			}
		}
		
		Mage::getModel('core/session')->setData('couponsArray',$coupons_array);
		$this->_addContent($this->getLayout()->createBlock('coupons4u/adminhtml_Einfochipscoupons4u_hello','UserCouponsAssign'));
		$this->renderLayout();
    }
	
	/*
		Assign to selected customre
	*/
	
	public function assignCouponsAction() {
	
		$xcoupon = Mage::getModel('core/session')->getData('couponsArray');
		$customersIds = $this->getRequest()->getParam('customer');
		
		$resource = Mage::getSingleton('core/resource');
		$readConnection = $resource->getConnection('core_read');
		
		$query = 'select customer_id from '.$resource->getTableName('salesrule_customer').' where rule_id = '.$xcoupon[1].'  AND  times_used = '.$xcoupon[3];
		
		$results = $readConnection->fetchCol($query);
		
		if(count($results)!=0) {
			$customersIds = array_diff($customersIds,$results);
		}
		
		$from_email = Mage::getStoreConfig('trans_email/ident_general/email'); //fetch sender email Admin
		$from_name = Mage::getStoreConfig('trans_email/ident_general/name'); //fetch sender name Admin
		
		$no_coupons		= count($xcoupon[0]);
		$no_customer 	= count($customersIds);
		$couponIds 		= array_keys($xcoupon[0]); 
		$couponCodes 	= array_values($xcoupon[0]);
		$usercouponsModel	= Mage::getModel('coupons4u/einfochipscoupons4u');
		
		$custData = array();
		$customreCollection = Mage::getModel('customer/customer')->getCollection()
							->addAttributeToSelect('entity_id')
							->addAttributeToSelect('firstname')
							->addAttributeToSelect('lastname')
							->addAttributeToSelect('email')
							->addFieldToFilter('entity_id',array('IN'=>$customersIds));
							
		foreach($customreCollection as $customer) {
			$custData[$customer->getEntityId()][0] = $customer->getEmail();
			$custData[$customer->getEntityId()][1] = $customer->getFirstname();
		}
		
		if($no_customer==0 || $no_customer=="" ) {
			Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('coupons4u/einfochipscoupons4u')->__('No Customer.')
                );
		}
		else {
			if($no_coupons > $no_customer){
				//loop through customer and assign individual coupon to customer
				
				for($i=0;$i<$no_customer;$i++){
					$usercouponsModel->setRuleId($xcoupon[1]);
					$usercouponsModel->setCustomerId($customersIds[$i]);
					$usercouponsModel->setCouponId($couponIds[$i]);
					$usercouponsModel->setCode($couponCodes[$i]);
					$usercouponsModel->save();
					
					Mage::getModel('coupons4u/email')->sendEmail(
						'coupons4u_email_template',
						array('name' => "$from_name", 'email' =>"$from_email"),
						$custData[$customersIds[$i]][0],
						$custData[$customersIds[$i]][1],
						'UserCoupon Email',
						array('CouponCode' => $couponCodes[$i])
					);
					$usercouponsModel->unsetData();
				}
			}
			else{
				// Coupons are less than number of customers
				if($no_coupons==1){
					// loop through the customer and assign single coupon to all the customer
					$noLoop=0;
					$nsplLoop = 0;
					if($xcoupon[2]==1){
						$noLoop = $xcoupon[2]; 
					}
					if($xcoupon[2] > $no_customer && $xcoupon[2] >1 ) {
						$noLoop = $no_customer;
					}
					if($xcoupon[2] == $no_customer && $xcoupon[2] >1 ) {
						$noLoop = $xcoupon[2];
					}
					if($xcoupon[2] < $no_customer && $xcoupon[2] >1) {
						$noLoop = $xcoupon[2];
					}
					
					if($xcoupon[2]==0){
						$nsplLoop = $no_customer;
					}
					
					for($i=0;$i<$nsplLoop;$i++) {
						$usercouponsModel->setRuleId($xcoupon[1]);
						$usercouponsModel->setCustomerId($customersIds[$i]);
						$usercouponsModel->setCouponId($couponIds[0]);
						$usercouponsModel->setCode($couponCodes[0]);
						
						Mage::getModel('coupons4u/email')->sendEmail(
								'coupons4u_email_template',
								array('name' => "$from_name", 'email' =>"$from_email"),
								$custData[$customersIds[$i]][0],
								$custData[$customersIds[$i]][1],
								'UserCoupon Email',
								array('CouponCode' => $couponCodes[0])
							);
						$usercouponsModel->save();
						$usercouponsModel->unsetData();
					}
					
					$couponusage =0;
					for($j=0;$j<$noLoop;$j++) {
						$usercouponsModel->setRuleId($xcoupon[1]);
						$usercouponsModel->setCustomerId($customersIds[$j]);
						
						if($couponusage<$xcoupon[2]) {
							$usercouponsModel->setCouponId($couponIds[0]);
							$usercouponsModel->setCode($couponCodes[0]);
							$couponusage++;
							Mage::getModel('coupons4u/email')->sendEmail(
								'coupons4u_email_template',
								array('name' => "$from_name", 'email' =>"$from_email"),
								$custData[$customersIds[$j]][0],
								$custData[$customersIds[$j]][1],
								'UserCoupon Email',
								array('CouponCode' => $couponCodes[0])
							);
							
						}
						else {
							$couponusage =0;
						}
						$usercouponsModel->save();
						$usercouponsModel->unsetData();
					}
				}
			
				if($no_coupons>1)
				{
					if($xcoupon[2]==1){
						$noLoop = $xcoupon[2]; 
					}
					if($xcoupon[2] > $no_customer && $xcoupon[2] >1 ) {
						$noLoop = $no_customer;
					}
					if($xcoupon[2] == $no_customer && $xcoupon[2] >1 ) {
						$noLoop = $xcoupon[2];
					}
					if($xcoupon[2] < $no_customer && $xcoupon[2] >1) {
						$noLoop = $xcoupon[2];
					}
					
					if($xcoupon[2]==0){
						$nsplLoop = $no_customer;
					}
					
					for($i=0;$i<$nsplLoop;$i++) {
						$usercouponsModel->setRuleId($xcoupon[1]);
						$usercouponsModel->setCustomerId($customersIds[$i]);
						$usercouponsModel->setCouponId($couponIds[0]);
						$usercouponsModel->setCode($couponCodes[0]);
						
						Mage::getModel('coupons4u/email')->sendEmail(
								'coupons4u_email_template',
								array('name' => "$from_name", 'email' =>"$from_email"),
								$custData[$customersIds[$i]][0],
								$custData[$customersIds[$i]][1],
								'UserCoupon Email',
								array('CouponCode' => $couponCodes[0])
							);
						$usercouponsModel->save();
						$usercouponsModel->unsetData();
					}
					
					
					$k=0;
					for($j=0;$j<$no_customer;$j++)
					{
						$usercouponsModel->setRuleId($xcoupon[1]);
						$usercouponsModel->setCustomerId($customersIds[$j]);
						
						if(count($couponIds)>$k)
						{	
							$usercouponsModel->setCouponId($couponIds[$k]);
							$usercouponsModel->setCode($couponCodes[$k]);
							$k++;
							
							Mage::getModel('coupons4u/email')->sendEmail(
								'coupons4u_email_template',
								array('name' => "$from_name", 'email' =>"$from_email"),
								$custData[$customersIds[$k]][0],
								$custData[$customersIds[$k]][1],
								'UserCoupon Email',
								array('CouponCode' => $couponCodes[$k])
							);
							$usercouponsModel->save();
							$usercouponsModel->unsetData();
						}
						else {
							$k=0;
						}
					}
				}			
			}
		}
		$this->_redirect('*/coupons4u_einfochipscoupons4u/index');
		Mage::getSingleton('adminhtml/session')->addSuccess('Coupons Assigned to Customer.');
	}
	
	
	
	/**
	 * save einfochipscoupons4u - action
	 * @access public
	 * @return void
	 * @author e-Infochips
	 */
	public function saveAction() {
		if ($data = $this->getRequest()->getPost('einfochipscoupons4u')) {
			try {
				$einfochipscoupons4u = $this->_initEinfochipscoupons4u();
				$einfochipscoupons4u->addData($data);
				$einfochipscoupons4u->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('coupons4u')->__('EinfochipsCoupons4U was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $einfochipscoupons4u->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
			} 
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
			catch (Exception $e) {
				Mage::logException($e);
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('coupons4u')->__('There was a problem saving the einfochipscoupons4u.'));
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('coupons4u')->__('Unable to find einfochipscoupons4u to save.'));
		$this->_redirect('*/*/');
	}
	/**
	 * delete einfochipscoupons4u - action
	 * @access public
	 * @return void
	 * @author e-Infochips
	 */
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0) {
			try {
				$einfochipscoupons4u = Mage::getModel('coupons4u/einfochipscoupons4u');
				$einfochipscoupons4u->setId($this->getRequest()->getParam('id'))->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('coupons4u')->__('EinfochipsCoupons4U was successfully deleted.'));
				$this->_redirect('*/*/');
				return; 
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('coupons4u')->__('There was an error deleteing einfochipscoupons4u.'));
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				Mage::logException($e);
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('coupons4u')->__('Could not find einfochipscoupons4u to delete.'));
		$this->_redirect('*/*/');
	}
	/**
	 * mass delete einfochipscoupons4u - action
	 * @access public
	 * @return void
	 * @author e-Infochips
	 */
	public function massDeleteAction() {
		$einfochipscoupons4uIds = $this->getRequest()->getParam('einfochipscoupons4u');
		if(!is_array($einfochipscoupons4uIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('coupons4u')->__('Please select einfochipscoupons4u to delete.'));
		}
		else {
			try {
				foreach ($einfochipscoupons4uIds as $einfochipscoupons4uId) {
					$einfochipscoupons4u = Mage::getModel('coupons4u/einfochipscoupons4u');
					$einfochipscoupons4u->setId($einfochipscoupons4uId)->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('coupons4u')->__('Total of %d einfochipscoupons4u were successfully deleted.', count($einfochipscoupons4uIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('coupons4u')->__('There was an error deleteing einfochipscoupons4u.'));
				Mage::logException($e);
			}
		}
		$this->_redirect('*/*/index');
	}
	/**
	 * mass status change - action
	 * @access public
	 * @return void
	 * @author e-Infochips
	 */
	public function massStatusAction(){
		$einfochipscoupons4uIds = $this->getRequest()->getParam('einfochipscoupons4u');
		if(!is_array($einfochipscoupons4uIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('coupons4u')->__('Please select einfochipscoupons4u.'));
		} 
		else {
			try {
				foreach ($einfochipscoupons4uIds as $einfochipscoupons4uId) {
				$einfochipscoupons4u = Mage::getSingleton('coupons4u/einfochipscoupons4u')->load($einfochipscoupons4uId)
							->setStatus($this->getRequest()->getParam('status'))
							->setIsMassupdate(true)
							->save();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d einfochipscoupons4u were successfully updated.', count($einfochipscoupons4uIds)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('coupons4u')->__('There was an error updating einfochipscoupons4u.'));
				Mage::logException($e);
			}
		}
		$this->_redirect('*/*/index');
	}
	/**
	 * export as csv - action
	 * @access public
	 * @return void
	 * @author e-Infochips
	 */
	public function exportCsvAction(){
		$fileName   = 'einfochipscoupons4u.csv';
		$content	= $this->getLayout()->createBlock('coupons4u/adminhtml_einfochipscoupons4u_grid')->getCsv();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as MsExcel - action
	 * @access public
	 * @return void
	 * @author e-Infochips
	 */
	public function exportExcelAction(){
		$fileName   = 'einfochipscoupons4u.xls';
		$content	= $this->getLayout()->createBlock('coupons4u/adminhtml_einfochipscoupons4u_grid')->getExcelFile();
		$this->_prepareDownloadResponse($fileName, $content);
	}
	/**
	 * export as xml - action
	 * @access public
	 * @return void
	 * @author e-Infochips
	 */
	public function exportXmlAction(){
		$fileName   = 'einfochipscoupons4u.xml';
		$content	= $this->getLayout()->createBlock('coupons4u/adminhtml_einfochipscoupons4u_grid')->getXml();
		$this->_prepareDownloadResponse($fileName, $content);
	}
}