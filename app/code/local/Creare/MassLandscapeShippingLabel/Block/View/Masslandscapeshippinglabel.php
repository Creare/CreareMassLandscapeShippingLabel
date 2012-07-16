<?php

class Creare_MassLandscapeShippingLabel_Block_View_Masslandscapeshippinglabel extends Mage_Adminhtml_Block_Sales_Order_View
{
	
	public function __construct()
	{		
		parent::__construct();
		$this->_addButton('landscape_shipping', array(
			'label'     => Mage::helper('sales')->__('Print Landscape Shipping Label'),
			'onclick'   => 'setLocation(\'' . $this->getLandscapeShippingLabelUrl() . '\')',
		));
	}
	
	public function getLandscapeShippingLabelUrl()
	{
		return $this->getUrl('creareadmin/masslandscapeshippinglabel/singleLandscapeShippingLabel');
	}
	
}