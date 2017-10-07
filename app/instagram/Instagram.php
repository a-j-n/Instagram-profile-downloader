<?php
/**
 * @author Ahmed Jamal
 */

/**
 * Created by PhpStorm.
 * User: Ahmed
 * Date: 8/3/17
 * Time: 7:10 PM
 */

namespace App\instagram;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;

abstract class Instagram
{

    public $endPoint = 'https://instagram.com/';
    public $subUrl;
    public $header;
    public $body = [];
    public $requestMethod;
    public $cookie ;

    function __construct($username, $max_id = null)
    {
        $this->header = ['headers' => $this->handelHeader()];
        $this->endPoint .= $username . "/media";
        if ($max_id) {
            $this->endPoint .= "/?max_id=" . $max_id;
        }
    }

    private function handelHeader()
    {
        $cookie =  file_get_contents(base_path('cookie'));
        if($cookie){
           $headers = array_add($this->header,'Cookie',$cookie);
           $headers = array_add($headers,'dnt',1);
           $headers = array_add($headers ,'pragma','no-cache');
        }


        return $headers;
    }

    public function request()
    {
        try {
            $client = new Client();
            $request = $client->request($this->requestMethod, $this->endPoint . $this->subUrl, $this->options());
            //dd($this->options());
            if ($request->getStatusCode() >= 200 && $request->getStatusCode() < 300) {
                $data = json_decode($request->getBody()->getContents());
                $data = json_decode(json_encode($data), True);
                return ['data' => $data, 'code' => $request->getStatusCode()];
            }
            return ['data' => ['error', $request->getBody()->getContents()], 'code' => $request->getStatusCode()];
        } catch (\Exception $exception) {
            if($exception instanceof ConnectException){
                return [
                    'data'=>['items'=>[],'more_available'=>true],
                    'code'=>401
                ];
            }else{
                return [
                    'data' => ["error" => $exception->getResponse()],
                    'code' => $exception->getCode()
                ];
            }

        }

    }

    private function options()
    {

        return array_merge(
            $this->header,
            $this->body
            //['http_errors' => false]
        );
    }

}