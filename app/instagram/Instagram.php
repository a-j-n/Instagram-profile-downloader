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
abstract class Instagram
{

    public $endPoint = 'https://api.instagram.com/v1/';
    public $subUrl;
    public $header;
    public $body;
    public $requestMethod;

    function __construct(array $jsonBody, $appendToSubUrl = null)
    {
        $this->header = ['headers' => $this->handelHeader()];
        $this->body = ['json' => $jsonBody];

        if ($appendToSubUrl) {
            $this->subUrl .= $appendToSubUrl;
        }
    }

    private function handelHeader()
    {
        $headers = array_add($this->header, 'accept', 'application/json');
        $headers = array_add($headers, 'token', env('DATA_ACCESS_LAYER_TOKEN'));

        return $headers;
    }

    public function request()
    {
        try {
            $client = new Client();
            $request = $client->request($this->requestMethod, $this->endPoint . $this->subUrl, $this->options());
            if ($request->getStatusCode() >= 200 && $request->getStatusCode() < 300) {
                $data = json_decode($request->getBody()->getContents());
                $data = json_decode(json_encode($data), True);
                return ['data' => $data, 'code' => $request->getStatusCode()];
            }
            return ['data' => ['error', $request->getBody()->getContents()], 'code' => $request->getStatusCode()];
        } catch (ClientException $exception) {

            return [
                'data' => ["error" => $exception->getResponse()],
                'code' => $exception->getCode()
            ];
        }

    }

    private function options()
    {

        return array_merge(
            $this->header,
            $this->body,
            ['http_errors' => false]
        );
    }

}