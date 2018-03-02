<?php

/**
 * <b>Deplyn Class</b><br/>
 * ------------<br/>
 * Contiene algunos métodos de encriptación (whirlpool, md5, sha1). <br/>
 * En esta clase puedes crear todos los métodos de encriptación que creas necesarios.<br/>
 * @version 2.3 - https://deplyn.com/framework/php/2.3
 * @author <b>Starlly Software</b> - https://starlly.com.<br/>
 * @licence GNU - https://deplyn.com/framework/php/licence.txt<br/>
 * @contact developer@starlly.com<br/>
 */
class Hash {

    /**
     *
     * @param string $algorithm The algorithm (md5, sha1, whirlpool, etc)
     * @param string $data The data to encode
     * @param string $salt The salt (This should be the same throughout the system probably)
     * @return string The hashed/salted data
     */
    public static function create($algorithm, $data, $salt) {

        $context = hash_init($algorithm, HASH_HMAC, $salt);
        hash_update($context, $data);

        return hash_final($context);
    }

    public static function whirlpool($data) {
        return Hash::create("whirlpool", $data, true);
    }

    public static function md5($data) {
        return Hash::create("md5", $data, true);
    }

    public static function sha1($data) {
        return Hash::create("sha1", $data, true);
    }

}
