<?php

/**
 * php AES加解密类
 * 如果要与java共用，则密钥长度应该为16位长度
 * 因为java只支持128位加密，所以php也用128位加密，可以与java互转。
 * 同时AES的标准也是128位。只是RIJNDAEL算法可以支持128，192和256位加密。
 * java 要使用AES/CBC/NoPadding标准来加解密
 * 
 * @author Terry
 *
 */
class AESMcrypt {

    //128定义16位的key
    const AESKEY = 'pufesriuhbytfkvy';
    const IV = "555690f4cdd8b962";

    //密钥

    /**
     * 加密方法
     * @param string $str
     * @return string
     */
    public static function encrypt($str) {
        $encrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, self::AESKEY, $str, MCRYPT_MODE_CBC, self::IV);
        return base64_encode($encrypted);
    }

    /**
     * 解密方法
     * @param string $str
     * @return string
     */
    public static function decrypt($str) {
        $encryptedData = base64_decode($str);
        $decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, self::AESKEY, $encryptedData, MCRYPT_MODE_CBC, self::IV);
        return $decrypted;
    }

}
