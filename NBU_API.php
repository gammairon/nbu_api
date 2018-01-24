<?php

namespace NBU_API;


use NBU_API\exception\TypeException;

/**
* Колекция классов для работы с АПИ Национального Банка Украины
*/
abstract class NBU_API
{
    const RESPONSE_TYPE_JSON = 'json';
    const RESPONSE_TYPE_XML = 'xml';

    protected $baseUrl = 'https://bank.gov.ua/NBUStatService/v1/statdirectory/';

    protected $responseType = self::RESPONSE_TYPE_JSON;

    protected $requestUrl = '';

    function __construct(){

    }



    abstract protected function setRequestEnpoint();

    abstract protected function setRequestExtraParams();


    /**
     * @var string $responseType avalible 'json' or 'xml'
     */
    public function setResponseType($responseType){
        if($responseType != self::RESPONSE_TYPE_JSON && $responseType != self::RESPONSE_TYPE_XML)
            throw new TypeException("Error: response type most be ".self::RESPONSE_TYPE_JSON." or ".self::RESPONSE_TYPE_XML, 1);

        $this->responseType = $responseType;
    }

    /**
     * @var string $requestUrl
     */
    protected function setRequestType(){
        $this->requestUrl .=  $this->responseType == self::RESPONSE_TYPE_JSON ? '&'.self::RESPONSE_TYPE_JSON : '';
    }

    /**
     * @var array $items
     * @var string $index
     */
    protected function indexBy($items, $index){
        $indexArray = [];
        foreach ($items as $item) {
            $indexArray[$item->{$index}] = $item;
        }

        return $indexArray;
    }

    protected function request(){
        $this->setRequestEnpoint();
        $this->setRequestExtraParams();
        $this->setRequestType();

        return $response = file_get_contents($this->requestUrl);

    }





}