<?php


class Bss_Testimonials_Block_Adminhtml_Testimonials extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{
		
		$this->_controller = "adminhtml_testimonials";
		$this->_blockGroup = "testimonials";
		$this->_headerText = Mage::helper("testimonials")->__("Manager Testimonials");
		$this->_addButtonLabel = Mage::helper("testimonials")->__("Add New Testimonials");
		parent::__construct();
		if(!Mage::getSingleton('admin/session')->isAllowed('testimonials/testimonials/actions/create')){
					$this->_removeButton('add');
		}
		
	
	}

}