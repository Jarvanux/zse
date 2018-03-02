<?php


/**
 * <b>Deplyn Class</b><br/>
 * ------------<br/>
 * @version 2.3 - https://deplyn.com/framework/php/2.3
 * @author <b>Starlly Software</b> - https://starlly.com.<br/>
 * @licence GNU - https://deplyn.com/framework/php/licence.txt<br/>
 * @contact developer@starlly.com<br/>
 */
class ObjUtil {

    protected $data;

    public function __construct($values = null) {
        $this->data = array();
        if (isset($values)) {
            foreach ($values as $key => $value) {
                if (is_array($value)) {
                    $this->data[$key] = new Request($value);
                } else {
                    $this->data[$key] = $value;
                }
            }
        }
    }

    public function __get($key) {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    public function __set($key, $value) {
        $this->data[$key] = $value;
    }

    public function all() {
        return $this->data;
    }

}
