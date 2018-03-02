<?php

/**
 * <b>Deplyn class</b><br/>
 * ------------<br/>
 * Clase genérica de la cual extienden todos los modelos para implementar el crud.<br/>
 * @version 2.3 - https://deplyn.com/framework/php/2.3
 * @author <b>Starlly Software</b> - https://starlly.com.<br/>
 * @licence GNU - https://deplyn.com/framework/php/licence.txt<br/>
 * @contact developer@starlly.com<br/>
 */
class Crud {

    protected $class;
    protected $__data;
    private $db;

    public function select(...$params) {
        $this->init();
        $this->db->select($params);
        return $this;
    }

    public function join($tablereference, $field, $condition, $field2) {
        $this->init();
        $this->db->join($tablereference, $field, $condition, $field2);
        return $this;
    }

    public function where($key, $condition, $value) {
        $this->init();
        $this->db->where($key, $condition, $value);
        return $this;
    }

    public function orWhere($key, $condition, $value) {
        $this->init();
        $this->db->orWhere($key, $condition, $value);
        return $this;
    }

    public function limit($limit = 0, $limit2 = 0) {
        $this->init();
        $this->db->limit($limit, $limit2);
        return $this;
    }

    public function orderBy($key, $order) {
        $this->init();
        $this->db->orderBy($key, $order);
        return $this;
    }

    public function first() {
        $this->init();
        return $this->db->first();
    }

    public function exist() {
        $this->init();
        if ($this->db->first()) {
            return true;
        } else {
            return false;
        }
    }

    public function count() {
        $this->init();
        return $this->db->count();
    }

    public function get() {
        $this->init();
        return $this->db->get();
    }

    public function listAll() {
        return $this->get();
    }

    private function getObj() {
        try {
            $model = $this->getAttributes();
            $obj = [];
            foreach ($model as $key => $value) {
                $obj[$value] = $this->{$value};
            }
            return $obj;
        } catch (Exception $exc) {
            return null;
        }
    }

    public function save() {
        return $this->insert();
    }

    public function insert($obj = null) {
        if (empty($obj)) {
            $obj = $this->getObj();
        } else {
            $obj = $this->parse($obj);
        }
        $this->init();
        try {
            $id = $this->db->insert($obj);
            $response = new Response(EMessages::INSERT);
            if ($id == 0) {
                $response = new Response(EMessages::ERROR_INSERT);
            }
            $response->setData($id);
            return $response;
        } catch (DeplynException $exc) {
            throw (new DeplynException(EMessages::ERROR_UPDATE))
                    ->setOriginalMessage($exc->getOriginal_message());
        }
    }

    /**
     * 
     * @param type $obj  
     * @return boolean ? $update
     * @throws type DeplynException
     */
    public function update($obj) {
        if (empty($obj)) {
            $obj = $this->getObj();
        } else {
            $obj = $this->parse($obj);
        }
        $this->init();
        try {
            $rowsAffected = $this->db->update($obj);
            $response = new Response(EMessages::UPDATE);
            if ($rowsAffected == 0) {
                $response = new Response(EMessages::ERROR_UPDATE);
            }
            return $response;
        } catch (DeplynException $exc) {
            throw (new DeplynException(EMessages::ERROR_UPDATE))
                    ->setOriginalMessage($exc->getOriginal_message());
        }
    }

    /**
     * 
     * @param array $wheres
     * @return boolean ? $delete
     * @throws DeplynException
     */
    public function delete() {
        $this->init();
        try {
            $this->db->delete();
            $response = new Response(EMessages::DELETE);
            return $response;
        } catch (DeplynException $exc) {
            throw (new DeplynException(EMessages::ERROR_UPDATE))
                    ->setOriginalMessage($exc->getOriginal_message());
        }
    }

    public function init() {
        if (empty($this->db)) {
            $this->db = new DB($this->table);
        }
    }

}
