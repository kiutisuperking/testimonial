<?php

class Bss_Testimonials_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
       $helper = Mage::helper('testimonials');
	    if($helper->isActive()){
	      $this->loadLayout(array('default'));
	      $this->renderLayout();  
	    }else{
	      $this->getResponse()->setHeader('HTTP/1.1','404 Not Found');
	      $this->getResponse()->setHeader('Status','404 File not found');
	      $this->_forward('defaultNoRoute');
	    }
    }

    public function commentAction(){
    	$post = Mage::app()->getRequest()->getPost();

        if (!$this->_validateFormKey()) {
          $this->_redirect('*/*');
          return;
        }

    	if(!Mage::getSingleton('customer/session')->isLoggedIn()){
    		$this->_redirect(Mage::getBaseUrl());
    	}
        if($post){
            $email = Mage::getSingleton('customer/session')->getCustomer()->getEmail();
            $comment = htmlentities($post['comment']);
            $nowDate = Mage::getModel('core/date')->date('Y-m-d H:i:s');
            try {
                if($comment != ""){
                    $model = Mage::getModel("testimonials/testimonials")
                    ->setComment($comment)
                    ->setCreateAt($nowDate)
                    ->setCustomerEmail($email)
                    ->save();
                    Mage::getSingleton("core/session")->addSuccess(Mage::helper("testimonials")->__("Comment successfully!"));
                }else{
                    Mage::getSingleton("core/session")->addError(Mage::helper("testimonials")->__("Comment error,please check again!"));    
                }
            } catch (Exception $e) {
                Mage::getSingleton("core/session")->addError(Mage::helper("testimonials")->__("Comment error,please check again!"));
            }
        }
        $this->_redirect("*/*/");
    }
}