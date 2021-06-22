<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 18.12.2019
 * Time: 12:53
 */
namespace cabinet\classes\response;

class PaymeResponse
{

    public $id;

    public function success($data)
    {
        return [
            'result' => $data,
            'id' => $this->id,
        ];
    }

    public function error($code,$message,$data = null)
    {

        if(is_array($message)){
            $str = '';
            foreach ($message as $item)
                $str .= "\n".implode("\n",$item);
            $message = $str;
        }


        return [
            'error' => [
                "code" => $code,
                "message" => [
                    "ru" => $message,
                    "uz" => $message,
                    "en" => $message,
                ],
                "data" => $data,
            ],
            'id' => $this->id,
        ];
    }

}