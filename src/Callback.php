<?php
namespace OriginAuth;

use OriginAuth;

class Callback{

    /**
     * @var OriginAuth
     */
    protected OriginAuth $originAuth;

    /**
     * @var OriginUser|null
     */
    protected ?OriginUser $origin = null;

    /**
     * @var bool
     */
    protected bool $error = false;
    /**
     * @var string|null
     */
    protected ?string $errorMessage = null;

    /**
     * Callback constructor.
     * @param OriginAuth $originAuth
     */
    public function __construct(
        OriginAuth $originAuth
    ){
        $this->originAuth = $originAuth;

        $this->fetch();
    }

    /**
     * @param string $errorMessage
     * @return Callback
     */
    protected function error(string $errorMessage){
        $this->error = true;
        $this->errorMessage = $errorMessage;
        return $this;
    }

    /**
     * @return $this
     */
    protected function fetch(){

        if(!empty($_GET['code'])){
            $code = $_GET['code'];

            $params = [
                'client_id' => $this->originAuth->getClientId(),
                'client_secret' => $this->originAuth->getClientSecret(),
                'redirect_uri' => $this->originAuth->getRedirectUrl(),
                'code' => $code
            ];

            $ch = curl_init('https://originauth.com/auth/token');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [ 'Content-Type: application/json' ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));

            $result = json_decode(curl_exec($ch), true);
            curl_close($ch);

            if(!empty($result) && !empty($result['origin'])){

                $this->origin = new OriginUser($result['origin']['id'], $result['origin']['name']);
                return $this;

            } else if(!empty($result['error_message'])){
                return $this->error($result['error_message']);
            }

        } else if(!empty($_GET['error_message'])){
            return $this->error($_GET['error_message']);
        }

        return $this->error('Unknown error');
    }

    /**
     * @return bool
     */
    public function isError(){
        return $this->error;
    }

    /**
     * @return string|null
     */
    public function getErrorMessage(){
        return $this->errorMessage;
    }

    /**
     * @return OriginUser|null
     */
    public function getOriginUser(){
        return $this->origin;
    }

    /**
     * @return string|null
     */
    public function getState(){
        return (!empty($_GET['state']))? $_GET['state'] : null;
    }

}