<?php
class Bss_Testimonials_Block_Adminhtml_Testimonials_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset("testimonials_form", array("legend"=>Mage::helper("testimonials")->__("Testimonials information")));
			$fieldset->addField("comment", "textarea", array(
				"label" => Mage::helper("testimonials")->__("Coment"),
				"name" => "comment",
				'class'     => 'required-entry',
				'required'  => true,
			));

			$fieldset->addField("customer_email", "text", array(
				"label" => Mage::helper("testimonials")->__("Customer Email"),
				"name" => "customer_email",
				'class'     => 'required-entry validate-email',
				'required'  => true,
			));
		$form->setValues(Mage::registry("testimonials_data")->getData());
		return parent::_prepareForm();
	}
}
