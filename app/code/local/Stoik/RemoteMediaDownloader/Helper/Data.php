<?php
/**
 * @category   Stoik
 * @package    Stoik_Remotemediadownloader
 * @author     jstoikidis@gmail.com
 */
class Stoik_Remotemediadownloader_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getConfig($field, $default = null){
        $value = Mage::getStoreConfig('Remotemediadownloader/option/'.$field);
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
        Mage::log($data, null, 'Remotemediadownloader.log');
	}

	public function isActive(){
		return $this->getConfig('active');
	}

    /**
     * [validateFileFolder description]
     * @return [type] [description]
     */
    public function validateFileFolder($localFile, $localFolder){
        return !file_exists($localFile) && $this->generateLocalFolder($localFolder);
    }

    /**
     * [generateLocalFolder description]
     * @return [type] [description]
     */
    public function generateLocalFolder($localFolder){
       Mage::log($localFolder);
        if(!file_exists($localFolder)){
            if(mkdir($localFolder, 0777, true)){
                return true;
            }
        }
        return true;
    }

    /**
     * [remoteImageDownload description]
     * @param  [type] $type      [description]
     * @param  [type] $imagePath [description]
     * @return [type]            [description]
     */
    public function remoteImageDownload($type, $imagePath, $localFolder){
    
        $localFolder = $localFolder . "/";
        $imageUrl = $this->getConfig('origin') . $imagePath;
        Mage::log($localFolder);
        Mage::log($imageUrl);
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