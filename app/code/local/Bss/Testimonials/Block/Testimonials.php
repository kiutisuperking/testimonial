<?php 
class Bss_Testimonials_Block_Testimonials extends Mage_Core_Block_Template
{
	public function helper(){
        return Mage::helper("testimonials");
    }

    public function linkActionForm(){
    	return $this->helper()->getCommentAction();
    }

    public function __construct()
    {
        parent::__construct();
        $collection = Mage::getModel('testimonials/testimonials')->getCollection();
        $collection->setOrder('id', 'DESC');
        $this->setCollection($collection);
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
 
        $pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
        $pager->setAvailableLimit(array(5=>5,10=>10,20=>20,'all'=>'all'));
        $pager->setCollection($this->getCollection());
        $this->setChild('pager', $pager);
        $this->getCollection()->load();
        return $this;
    }
 
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
}