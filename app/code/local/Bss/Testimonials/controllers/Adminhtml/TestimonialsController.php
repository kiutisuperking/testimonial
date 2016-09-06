<?php
class Bss_Testimonials_Adminhtml_TestimonialsController extends Mage_Adminhtml_Controller_Action
{

	protected function _initAction()
	{
		$this->loadLayout()->_setActiveMenu("testimonials/testimonials")->_addBreadcrumb(Mage::helper("adminhtml")->__("Manager Comment"),Mage::helper("adminhtml")->__("Manager Comment"));
		return $this;
	}

	public function indexAction() 
	{
	    $this->_title($this->__("Comment"));
	    $this->_title($this->__("Manager Comment"));
	    
		$this->_initAction();
		$this->renderLayout();
	}

	public function newAction()
	{
		$this->_title($this->__("New Comment"));

	    $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("testimonials/testimonials")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}
		Mage::register("testimonials_data", $model);
		$this->loadLayout();
		$this->_setActiveMenu("testimonials/testimonials");
		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Manager Comment"), Mage::helper("adminhtml")->__("Manager Comment"));
		$this->_addContent($this->getLayout()->createBlock("testimonials/adminhtml_testimonials_edit"))->_addLeft($this->getLayout()->createBlock("testimonials/adminhtml_testimonials_edit_tabs"));

		$this->renderLayout();

	}

	public function editAction()
	{			    
	    $this->_title($this->__("Edit Comment"));
		
		$id = $this->getRequest()->getParam("id");
		$model = Mage::getModel("testimonials/testimonials")->load($id);
		if ($model->getId()) {
			Mage::register("testimonials_data", $model);
			$this->loadLayout();
			$this->_setActiveMenu("testimonials/testimonials");
			$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Manager Comment"), Mage::helper("adminhtml")->__("Manager Comment"));
			$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
			$this->_addContent($this->getLayout()->createBlock("testimonials/adminhtml_testimonials_edit"))->_addLeft($this->getLayout()->createBlock("testimonials/adminhtml_testimonials_edit_tabs"));
			$this->renderLayout();
		} 
		else {
			Mage::getSingleton("adminhtml/session")->addError(Mage::helper("testimonials")->__("Comment does not exist."));
			$this->_redirect("*/*/");
		}
	}


	public function saveAction()
	{
		$postData = $this->getRequest()->getPost();
		if ($postData) {
			try {
				$email = trim($postData['customer_email']);
				echo Mage::app()->getWebsite()->getId();
				$customer = Mage::getModel("customer/customer")->getCollection();
			    $customer->addAttributeToFilter('email',array('eq' => $email));
			    $nowDate = Mage::getModel('core/date')->date('Y-m-d H:i:s');
				if($customer->getData()){
					$model = Mage::getModel("testimonials/testimonials")
					->addData($postData)
					->setCreateAt($nowDate)
					->setId($this->getRequest()->getParam("id"))
					->save();
					Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Comment was successfully saved"));
					if ($this->getRequest()->getParam("back")) {
						$this->_redirect("*/*/edit", array("id" => $model->getId()));
						return;
					}
					$this->_redirect("*/*/");
					return;
				}else{
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("adminhtml")->__("Customer email not exit!"));
				}
			}catch (Exception $e) {
				Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
				$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
				return;
			}

		}
		$this->_redirect("*/*/");
	}


	public function deleteAction()
	{
		if( $this->getRequest()->getParam("id") > 0 ) {
			try {
				$model = Mage::getModel("testimonials/testimonials");
				$model->setId($this->getRequest()->getParam("id"))->delete();
				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Comment was successfully deleted"));
				$this->_redirect("*/*/");
			}catch (Exception $e) {
				Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
				$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
			}
		}
		$this->_redirect("*/*/");
	}


	public function massRemoveAction()
	{
		try {
			$ids = $this->getRequest()->getPost('ids', array());
			foreach ($ids as $id) {
                  $model = Mage::getModel("testimonials/testimonials");
				  $model->setId($id)->delete();
			}
			Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Comment(s) was successfully removed"));
		}catch (Exception $e) {
			Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
		}
		$this->_redirect('*/*/');
	}
			
	/**
	 * Export order grid to CSV format
	 */
	public function exportCsvAction()
	{
		$fileName   = 'testimonials.csv';
		$grid       = $this->getLayout()->createBlock('testimonials/adminhtml_testimonials_grid');
		$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
	} 
	/**
	 *  Export order grid to Excel XML format
	 */
	public function exportExcelAction()
	{
		$fileName   = 'testimonials.xml';
		$grid       = $this->getLayout()->createBlock('testimonials/adminhtml_testimonials_grid');
		$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
	}

	protected function _isAllowed()
	{
	    return Mage::getSingleton('admin/session')->isAllowed('testimonials/testimonials');
	}
}