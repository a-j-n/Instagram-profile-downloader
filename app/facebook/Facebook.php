<?php
/**
 * @author Ahmed Jamal
 */

/**
 * Created by PhpStorm.
 * User: Ahmed
 * Date: 10/7/17
 * Time: 6:13 PM
 */

namespace App\facebook;


class Facebook
{
    public $endPoint = 'https://graph.facebook.com/v2.10/';
    public $subUrl;
    public $header;
    public $body = [];
    public $requestMethod;
    public $cookie ;

    function __construct()
    {
        $this->header = ['headers' => $this->handelHeader()];

    }

    private function handelHeader()
    {

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