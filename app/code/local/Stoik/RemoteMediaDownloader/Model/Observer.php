<?php
/**
 * @category   Stoik
 * @package    Stoik_Remotemediadownloader
 * @author     jstoikidis@gmail.com
 * @website    http://www.creode.co.uk
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Stoik_Remotemediadownloader_Model_Observer {

	private $helper = NULL;
	/**
	 * [stage description]
	 * @param Varien_Event_Observer $observer [description]
	 */
	public function Remotemediadownloader(Varien_Event_Observer $observer) {
		$transport			= $observer->getTransport();
		$this->helper		= Mage::helper('Remotemediadownloader');
		$remoteOrigin 	    = $this->helper->getConfig('origin');
		$type               = $this->helper->getConfig('type');
		$type  = "php_curl";
		//$type = 'asd';		
		$html = $transport->getHtml();
		// Check if module is active
		if($this->helper->isActive()){
			// create a new DOMDocument object
			$DOM = new DOMDocument;
			@$DOM->loadHTML($html);
			// find all images tags
			// http://stackoverflow.com/questions/6090667/php-domdocument-errors-warnings-on-html5-tags
			$imageTags = $DOM->getElementsByTagName('img');
			if($imageTags){
				$this->parseImages($imageTags);
				$transport->setHtml($html);		
			}
			
		}
		
	}

	/**
	 * [parseImages description]
	 * @param  [type] $imageTags [description]
	 * @return [type]            [description]
	 */
	private function parseImages($imageTags){
		$type  = "php_curl";
		foreach($imageTags as $tag) {
			// get the path from the image src
			$PHP_URL_PATH = parse_url($tag->getAttribute('src'), PHP_URL_PATH);
			$localFile = Mage::getBaseDir() . $PHP_URL_PATH;
			$localFolder = dirname($localFile);
			
			if($this->helper->validateFileFolder($localFile, $localFolder)){
				// Download remote file
				$removeImageDownloaded = $this->helper->remoteImageDownload($type, $PHP_URL_PATH, $localFolder);	
			}
		}
	}

}