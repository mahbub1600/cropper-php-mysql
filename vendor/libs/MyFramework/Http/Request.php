<?php
namespace MyFramework\Http;

class Request {
    private $request;
    private $requestType;

    const REQUEST_GET = 'GET';
    const REQUEST_POST = 'POST';

    public function __construct($request) {
        $this->request = $request;
        $this->setRequestType();
        return;
    }

    public function getPost(){
        return $this->request;
    }
    private function setRequestType(){
        $this->requestType = $_SERVER['REQUEST_METHOD'];
        return;
    }
    public function getRequestType(){
        return $this->requestType;
    }
}