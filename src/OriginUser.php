<?php
namespace OriginAuth;

class OriginUser{

    /**
     * @var string
     */
    protected string $origin_id;
    /**
     * @var string
     */
    protected string $origin_name;

    /**
     * OriginUser constructor.
     * @param string $origin_id
     * @param string $origin_name
     */
    public function __construct(string $origin_id, string $origin_name){
        $this->origin_id = $origin_id;
        $this->origin_name = $origin_name;
    }

    /**
     * @return string
     */
    public function getId(){
        return $this->origin_id;
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->origin_name;
    }

    /**
     * @return array
     */
    public function getData(){
        return [ 'origin_id' => $this->getId(), 'origin_name' => $this->getName() ];
    }

}