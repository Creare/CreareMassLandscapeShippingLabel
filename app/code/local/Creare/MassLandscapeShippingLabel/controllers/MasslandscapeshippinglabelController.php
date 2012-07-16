<?php
require_once("Mage/Adminhtml/controllers/Sales/ShipmentController.php"); 
class Creare_MassLandscapeShippingLabel_MasslandscapeshippinglabelController extends Mage_Adminhtml_Controller_Sales_Shipment
{
	
	private function array_mpop($array, $iterate)
	{
		if(!is_array($array) && is_int($iterate))
			return false;
			
		while(($iterate--)!=false)
			array_pop($array);
		return $array;
	} 
	
	public function singleLandscapeShippingLabelAction()
    {
        $request = $this->getRequest();
		
        $ids = $request->getParam('order_id');
		
		$pdfarray = array();
		
			$order = Mage::getModel('sales/order')->load($ids);
		
			$shipaddr= trim($order->getShippingAddress()->getFormated(true));
			$splitx=explode("\n",$shipaddr);
			$split=explode("<br/>",$shipaddr);			
			
			foreach($split as $sp):
				if(stristr($sp,"<br />")){
					$temp = explode("<br />", $sp);
					foreach($temp as $t){
						$pdfarray[$i]["addr"][] .= $t;
					}
				} else {
					$pdfarray[$i]["addr"][] = $sp;
				}
			endforeach;
		
		$pdf = new Zend_Pdf();
		
		foreach($pdfarray as $pdfarr):	
		
		$temp = $this->array_mpop($pdfarr["addr"], 2);	
		
		$page = $pdf->newPage('255:82:');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 13); 
		
		$i = 70;
		
		foreach($temp as $addy){
			$page->drawText(trim(strtoupper($addy)), 5,$i, 'UTF-8');	
			$i = $i-13;
		}
		
		$pdf->pages[] = $page;
		
		endforeach;
		
		$pdfData = $pdf->render(); 
		
		$this->_prepareDownloadResponse('Order('.$ids.')-ShippingLabel-'.date('d-m-Y-H-i-s').'.pdf', $pdf->render(), 'application/pdf');
		
    }	
	
	public function massLandscapeShippingLabelAction()
    {
        $request = $this->getRequest();
		
        $ids = $request->getParam('order_ids');
		
		if(!$ids){
			$ids = array($request->getParam('order_id'));
		}
		
		$pdfarray = array();
        
		for($i=0;$i<count($ids);$i++):
		
			$order = Mage::getModel('sales/order')->load($ids[$i]);
		
			$shipaddr= trim($order->getShippingAddress()->getFormated(true));
			$splitx=explode("\n",$shipaddr);
			$split=explode("<br/>",$shipaddr);			
			
			foreach($split as $sp):
				if(stristr($sp,"<br />")){
					$temp = explode("<br />", $sp);
					foreach($temp as $t){
						$pdfarray[$i]["addr"][] .= $t;
					}
				} else {
					$pdfarray[$i]["addr"][] = $sp;
				}
			endforeach;
		
		endfor;
		
		$pdf = new Zend_Pdf();
		
		foreach($pdfarray as $pdfarr):	
		
		$temp = $this->array_mpop($pdfarr["addr"], 2);	
		
		$page = $pdf->newPage('255:82:');
		
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 13); 
		
		$i = 70;
		
		foreach($temp as $addy){
			$page->drawText(trim(strtoupper($addy)), 5,$i, 'UTF-8');	
			$i = $i-13;
		}
		
		$pdf->pages[] = $page;
		
		endforeach;
		
		$pdfData = $pdf->render(); 
		
		$this->_prepareDownloadResponse('ShippingLabels-'.date('d-m-Y-H-i-s').'.pdf', $pdf->render(), 'application/pdf');
		
    }	
	
}