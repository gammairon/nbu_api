<?php

namespace NBU_API;


/**
* Офіційний курс гривні щодо іноземних валют та банківських металів
*
*
*/

class NBU_API_Exchange extends NBU_API
{

    protected $date = null;
    protected $valcode = null;

    protected $rates = [];

    protected function setRequestEnpoint(){
        $this->requestUrl .= $this->baseUrl.'exchange?';
    }

    protected function setRequestExtraParams(){

        if(!is_null($this->date))
            $this->requestUrl .= '&date='.$this->date;

        if(!is_null($this->valcode))
            $this->requestUrl .= '&valcode='.strtoupper($this->valcode);
    }

    /**
     *
     * @var string $date Курс на дату (задається у форматі YYYYMMDD): '20180124'
     */
    public function setDate($date){
        $this->date = $date;
    }

    /**
     *
     * @var string $valcode Курс на дату по валюті (код валюти літерний, регістр значення не має): 'USD'
     * avalible valcode see https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json
     */
    public function setValcode($valcode){
        $this->valcode = $valcode;
    }


    /**
     *
     * @var array $valcodes ['USD','EUR', ...]
     * @return (array objects)/object
     */
    public function getRates($valcodes = []){
        $rates = json_decode($this->request());
        $this->rates = $this->indexBy($rates, 'cc');

        if(is_array($valcodes) && count($valcodes)){
            return $this->getSelectedRates($valcodes);
        }
        elseif(is_scalar($valcodes)){
            return $this->rates[$valcodes];
        }
        else
            return $this->rates;

    }

    /**
     *
     * @var string $valcode 'USD','EUR', ...
     * @return object
     */
    public function getRate($valcode){
        if($this->rates && isset($this->rates[$valcode]))
            return $this->rates[$valcode];

        return $this->getRates($valcode);

    }

    private function getSelectedRates($valcodes){
        $selectedRates = [];
        foreach ($this->rates as $valcode => $rate) {
            if(in_array($valcode, $valcodes))
                $selectedRates[$valcode] = $rate;
        }

        return $selectedRates;
    }




}