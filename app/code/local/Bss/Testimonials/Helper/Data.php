<?php
class Bss_Testimonials_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function isActive(){
        $storeview = Mage::app()->getStore()->getStoreId();
        return Mage::getStoreConfig('testimonials/testimonials_settings/testimonials_active',$storeview);
    }

    public function getCommentAction()
    {
        return $this->_getUrl('testimonials/index/comment');
    }
}
	 