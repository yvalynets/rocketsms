<?php

namespace Zmitroc\Rocketsms;

use Exception;
use Zmitroc\Rocketsms\Responses\AddSenderResponse;
use Zmitroc\Rocketsms\Responses\BalanceResponse;
use Zmitroc\Rocketsms\Responses\StatusResponse;
use Zmitroc\Rocketsms\Structures\Sender;
use Zmitroc\Rocketsms\Structures\Template;

class ApiClient
{
    private string $apiUrl = 'https://api.rocketsms.by/simple';

    private string $username;

    private string $password;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = md5($password);
    }

    /**
     * @param  string  $path
     * @param  array  $data
     * @param  string  $method
     * @return array
     * @throws Exception
     */
    private function sendRequest(string $path, array $data, string $method = 'GET'): array
    {
        $data = array_merge(
            [
                'username' => $this->username,
                'password' => $this->password,
            ],
            $data
        );

        $url = $this->apiUrl.'/'.$path.'?'.http_build_query($data);

        $curl = curl_init();

        if ($method === 'POST') {
            curl_setopt($curl, CURLOPT_POST, true);
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);

        curl_close($curl);

        if ($httpCode === 200) {
            $result = json_decode($response, true);

            if (isset($result)) {
                if (empty($result['error'])) {
                    return $result;
                } else {
                    throw new Exception('Error occurred: '.$result['error']);
                }
            } else {
                throw new Exception('Unable to read the response: '.$response);
            }
        } else {
            throw new Exception('Wrong HTTP code: '.$httpCode);
        }
    }

    /**
     * @param  string  $path
     * @param  array  $data
     * @return array
     * @throws Exception
     */
    private function get(string $path, array $data = []): array
    {
        return $this->sendRequest($path, $data);
    }

    /**
     * @param  string  $path
     * @param  array  $data
     * @return array
     * @throws Exception
     */
    private function post(string $path, array $data = []): array
    {
        return $this->sendRequest($path, $data, 'POST');
    }

    /**
     * Проверка статуса сообщения
     * @param  int  $id  ID сообщения
     * @return StatusResponse
     * @throws Exception
     */
    public function getStatus(int $id): StatusResponse
    {
        return new StatusResponse($this->get('status', ['id' => $id]));
    }

    /**
     * Проверка баланса аккаунта
     * @return BalanceResponse
     * @throws Exception
     */
    public function getBalance(): BalanceResponse
    {
        return new BalanceResponse($this->get('balance'));
    }

    /**
     * Список доступных альфа-номеров
     * @return Sender[]
     * @throws Exception
     */
    public function getSenders(): array
    {
        return array_map(fn (array $senderData) => new Sender($senderData), $this->get('senders'));
    }

    /**
     * Добавление альфа-номера
     * @param  string  $name  Альфа-номер для согласования.
     * До 11 символов включительно, разрешены латинские буквы, цифры, точка и дефис
     * @return AddSenderResponse
     * @throws Exception
     */
    public function addSender(string $name): AddSenderResponse
    {
        return new AddSenderResponse($this->post('senders/add', ['sender' => $name]));
    }

    /**
     * Список доступных шаблонов
     * @return Template[]
     * @throws Exception
     */
    public function getTemplates(): array
    {
        return array_map(fn (array $templateData) => new Template($templateData), $this->get('templates'));
    }
}
