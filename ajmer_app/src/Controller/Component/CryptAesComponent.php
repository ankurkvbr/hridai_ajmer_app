<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;

/**
 * Mobile Aes encryption decryption Component
 *
 * @author        Rajvi Modi
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
class CryptAesComponent extends Component {

    protected $cipher     = MCRYPT_RIJNDAEL_128;
    protected $mode       = MCRYPT_MODE_CBC;
    protected $pad_method = NULL;
    public function set_cipher($cipher)
    {
        $this->cipher = $cipher;
    }

    public function set_mode($mode)
    {
        $this->mode = $mode;
    }

    public function set_iv($iv)
    {
        $this->iv = $iv;
    }

    public function set_key($secret_key)
    {	
		$len = strlen($secret_key);
		if($len < 24 && $len != 16){
			$secret_key = str_pad($secret_key, 24, "\0", STR_PAD_RIGHT); 
		} elseif ($len > 24 && $len < 32) {
			$secret_key = str_pad($secret_key, 32, "\0", STR_PAD_RIGHT);       
		}elseif ($len > 32){
			$secret_key = substr($secret_key, 0, 32);
		}
        $this->secret_key = $secret_key;
    }

    public function require_pkcs5()
    {
        $this->pad_method = 'pkcs5';
    }

    protected function pad_or_unpad($str, $ext)
    {
        if (is_null($this->pad_method))
        {
            return $str;
        }
        else
        {
            $func_name = __CLASS__ . '::' . $this->pad_method . '_' . $ext . 'pad';
            if (is_callable($func_name))
            {
                $size = mcrypt_get_block_size($this->cipher, $this->mode);
                return call_user_func($func_name, $str, $size);
            }
        }

        return $str;
    }

    protected function pad($str)
    {
        return $this->pad_or_unpad($str, '');
    }

    protected function unpad($str)
    {
        return $this->pad_or_unpad($str, 'un');
    }


    public function encrypt($str)
    {
        $str = $this->pkcs5_pad($str);
        $td = mcrypt_module_open($this->cipher, '', $this->mode, '');

        if (empty($this->iv))
        {
            $iv = @mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        }
        else
        {
            $iv = $this->iv;
        }
        mcrypt_generic_init($td, $this->secret_key, $iv);
        $cyper_text = mcrypt_generic($td, $str);
        $rt = base64_encode($cyper_text);
        // $rt = bin2hex($cyper_text);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);

        return $rt;
    }

    public function decrypt($str){
		
		$str = str_replace(' ', '+', $str);
		$td = mcrypt_module_open($this->cipher, '', $this->mode, '');

        if (empty($this->iv))
        {
            $iv = @mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        }
        else
        {
			$iv = $this->iv;
        }

        mcrypt_generic_init($td, $this->secret_key, $iv);
        $decrypted_text = mdecrypt_generic($td, base64_decode($str));
        // $decrypted_text = mdecrypt_generic($td, self::hex2bin($str));
        $rt = $decrypted_text;
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);

        return $this->pkcs5_unpad($rt);
    }

    public static function hex2bin($hexdata) {
        $bindata = '';
        $length = strlen($hexdata);
        for ($i=0; $i < $length; $i += 2)
        {
            $bindata .= chr(hexdec(substr($hexdata, $i, 2)));
        }
        return $bindata;
    }

    public static function pkcs5_pad($text)
    {
		$blocksize = 16;
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    public static function pkcs5_unpad($text)
    {
        $pad = ord($text{strlen($text) - 1});
        if ($pad > strlen($text)) return false;
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return false;
        return substr($text, 0, -1 * $pad);
    }
	
	public function encryption($id, $deviceId, $randString){
		
		$payload = $id.':'.$deviceId.':'.$randString;
		
		$secret_key = "ajmerapp";
		$hashSecretKey = hash('sha256', $secret_key);
		
		$iv_set = "BJJR26RIAI18INIS81JAMH62LIAN21BH68bjjr";
		$hashIvKey = '433ab7c581a24297';
		
		$this->set_iv ($hashIvKey);
		$this->set_key($hashSecretKey);
		$encRandomToken = $this->encrypt($payload);
		return $encRandomToken;
	}
	
	public function decryption($encryptionKey){
		
		$secret_key = "ajmerapp";
		$hashSecretKey = hash('sha256', $secret_key);
		
		$iv_set = "BJJR26RIAI18INIS81JAMH62LIAN21BH68bjjr";
		$hashIvKey = '433ab7c581a24297';
		
		$this->set_iv ($hashIvKey);
		$this->set_key($hashSecretKey);
		if($encryptionKey != ''){
			$decRandomToken = $this->decrypt($encryptionKey);
			$decRandomToken = explode(':',$decRandomToken);
			if(!empty($decRandomToken)){
				$usrarr['uid'] = isset($decRandomToken[0])?$decRandomToken[0]:NULL;
				$usrarr['device_id'] = isset($decRandomToken[1])?$decRandomToken[1]:NULL;
				$usrarr['token'] = isset($decRandomToken[2])?$decRandomToken[2]:NULL;
				return $usrarr;
			}
		}
		return false;
	}
	
	public function passDecrypt($encryptionKey, $device_id){
		
		$secret_key = ":AANJDMREORID2672";
		$appendKey = $device_id.$secret_key;
		$hashSecretKey = hash('sha256', $appendKey);
		//$hashSecretKey = "f8992ae354ca0ca58862c336ae2692590da9fb848c44174771c9e";

		$iv_set = "BJJR26RIAI18INIS81JAMH62LIAN21BH68bjjr";
		$hashIvKey = '433ab7c581a24297';
		
		$this->set_iv ($hashIvKey);
		$this->set_key($hashSecretKey);
		if($encryptionKey != ''){
			$decRandomToken = $this->decrypt($encryptionKey);
			return $decRandomToken;
		}
		return false;
	}

}