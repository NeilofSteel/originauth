<?php
use OriginAuth\Callback;

class OriginAuth{

    /**
     * @var string
     */
    protected string $client_id;
    /**
     * @var string
     */
    protected string $client_secret;

    /**
     * @var string
     */
    protected string $redirect_uri;

    /**
     * OriginAuth constructor.
     * @param string $client_id
     * @param string $client_secret
     */
    public function __construct(string $client_id, string $client_secret){
        $this->setClientId($client_id);
        $this->setClientSecret($client_secret);
    }

    /**
     * @param $client_id
     * @return $this
     */
    public function setClientId($client_id){
        $this->client_id = $client_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientId(){
        return $this->client_id;
    }

    /**
     * @param $client_secret
     * @return $this
     */
    public function setClientSecret($client_secret){
        $this->client_secret = $client_secret;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientSecret(){
        return $this->client_secret;
    }

    /**
     * @param $redirect_uri
     * @return $this
     */
    public function setRedirectUrl($redirect_uri){
        $this->redirect_uri = $redirect_uri;
        return $this;
    }

    /**
     * @return string
     */
    public function getRedirectUrl(){
        return $this->redirect_uri;
    }

    /**
     * @param string|null $state
     * @return string
     */
    public function createAuthUrl(string $state = null){
        $query = http_build_query(array_merge(
            [ 'client_id' => $this->client_id, 'redirect_uri' => $this->redirect_uri ],
            (!empty($state))? [ 'state' => $state ] : []
        ), '', '&');

        return "https://originauth.com/oauth?$query";
    }

    /**
     * @return Callback
     */
    public function fetchResult(){
        return new Callback($this);
    }

}
