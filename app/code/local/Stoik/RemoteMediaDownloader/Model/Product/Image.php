<?php
/**
 * @category Utilities
 * @package Stoik_Remotemediadownloader
 * @author jstoikidis@gmail.com
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Intercepts product image access and downloads original image just-in-time.
 * 
 * Method is slow but only needs to be done once.
 * Requires `allow_url_fopen` permission.
 * 
 * @see http://php.net/manual/en/filesystem.configuration.php#ini.allow-url-fopen
 */
class Stoik_Remotemediadownloader_Model_Product_Image extends Mage_Catalog_Model_Product_Image
{


   /**
    * [_fileExists description]
    * @param  [type] $filename [description]
    * @return [type]           [description]
    */
    protected function _fileExists($filename)
    {
    	$helper				= Mage::helper('remotemediadownloader');
    	$remoteOrigin 	    = $helper->getConfig('origin');
    	$type               = $helper->getConfig('type');
    	$localFile = $filename;
    	$localFolder = dirname($localFile);
        if (!parent::_fileExists($filename)) {
        	if($helper->validateFileFolder($localFile,$localFolder)){
        		
        		$helper->remoteImageDownload($type, str_replace(Mage::getBaseDir(), "", $filename), $localFolder);
        		return true;
        	}
        }

        return true;
    }
}