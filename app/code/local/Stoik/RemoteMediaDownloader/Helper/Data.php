<?php
/**
 * @category   Stoik
 * @package    Stoik_Remotemediadownloader
 * @author     jstoikidis@gmail.com
 * @website    http://www.creode.co.uk
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Stoik_Remotemediadownloader_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getConfig($field, $default = null){
        $value = Mage::getStoreConfig('remotemediadownloader/option/'.$field);
        if(!isset($value) or trim($value) == ''){
            return $default;
        }else{
            return $value;
        }
	}

    public function log($data){
        if(is_array($data) || is_object($data)){
            $data = print_r($data, true);
        }
        Mage::log($data, null, 'remotemediadownloader.log');
	}

	public function isActive(){
		return $this->getConfig('active');
	}

    /**
     * Checks if a file exists in the local system
     * and generates the folder if it is needed
     * @return boolean
     */
    public function validateFileFolder($localFile, $localFolder){
        return !file_exists($localFile) && $this->generateLocalFolder($localFolder);
    }

    /**
     * Creates local folder
     * that the remote image is going to be downloaded
     * @return [type] [description]
     */
    public function generateLocalFolder($localFolder){
        if(!file_exists($localFolder)){
            if(mkdir($localFolder, 0777, true)){
                return true;
            }
        }
        return false;
    }

    /**
     * Downloads remote image
     * @param  [type] $type      [description]
     * @param  [type] $imagePath [description]
     * @return [type]            [description]
     */
    public function remoteImageDownload($type, $imagePath, $localFolder){
        
        $localFolder = $localFolder . "/";
        $imageUrl = $this->getConfig('origin') . $imagePath;
        
        if (!filter_var($imageUrl, FILTER_VALIDATE_URL) === false) {

            $filename = basename($imageUrl);
            $ch = curl_init($imageUrl);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
            $rawdata=curl_exec ($ch);
            curl_close ($ch);
            $fp = fopen($localFolder . $filename,'w');
            $fwriteStatus = fwrite($fp, $rawdata); 
            fclose($fp);  
            if(!$fwriteStatus){
                // echo something
                
            }
        } 
        // Mage log, url is not validated
        return true;
    }
    

}