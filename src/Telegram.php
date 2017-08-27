<?php

namespace NotificationChannelsPlus\Telegrambot;

use NotificationChannelsPlus\Telegrambot\Exceptions\CouldNotSendNotification;

class Telegram
{
    /** @var null|string Telegram Bot API Token. */
    protected $token = null;

    /**
     * @param null            $token
     * @param HttpClient|null $httpClient
     */
    public function __construct($token = null)
    {
        $this->token = $token;
    }

    /**
     * Send text message.
     *
     * <code>
     * $params = [
     *   'chat_id'                  => '',
     *   'text'                     => '',
     *   'parse_mode'               => '',
     *   'disable_web_page_preview' => '',
     *   'disable_notification'     => '',
     *   'reply_to_message_id'      => '',
     *   'reply_markup'             => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendmessage
     *
     * @param array $params
     *
     * @var int|string $params ['chat_id']
     * @var string     $params ['text']
     * @var string     $params ['parse_mode']
     * @var bool       $params ['disable_web_page_preview']
     * @var bool       $params ['disable_notification']
     * @var int        $params ['reply_to_message_id']
     * @var string     $params ['reply_markup']
     *
     * @return mixed
     */
    public function sendMessage($methodSend, $params)
    {
        return $this->sendRequest($methodSend, $params);
    }

    /**
     * Send an API request and return response.
     *
     * @param $endpoint
     * @param $params
     *
     * @throws CouldNotSendNotification
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function sendRequest($endpoint, $params)
    {
        if (empty($this->token)) {
            throw CouldNotSendNotification::telegramBotTokenNotProvided('You must provide your telegram bot token to make any API requests.');
        }

        $endPointUrl = 'https://api.telegram.org/bot'.$this->token.'/'.$endpoint;

        try {

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER  => 1,
                CURLOPT_URL             => $endPointUrl,
                CURLOPT_POST            => 1,
                CURLOPT_POSTFIELDS      => $params
            ));
            $resp = curl_exec($curl);
            curl_close($curl);

            return $resp;

        } catch (\Exception $exception) {
            throw CouldNotSendNotification::couldNotCommunicateWithTelegram();
        }
    }

}
