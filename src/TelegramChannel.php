<?php

namespace NotificationChannelsPlus\Telegrambot;

use Illuminate\Notifications\Notification;
use NotificationChannelsPlus\Telegrambot\Exceptions\CouldNotSendNotification;

class TelegramChannel
{
    /**
     * @var Telegram
     */
    protected $telegram;

    /**
     * Channel constructor.
     *
     * @param Telegram $telegram
     */
    public function __construct(Telegram $telegram)
    {
        $this->telegram = $telegram;
    }

    /**
     * Send the given notification.
     *
     * @param mixed        $notifiable
     * @param Notification $notification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toTelegram($notifiable);

        if (is_string($message))
            $message = TelegramMessage::create($message);

        if ($message->toNotGiven())
        {
            if (!$to = $notifiable->routeNotificationFor('telegram'))
                throw CouldNotSendNotification::chatIdNotProvided();

            $message->to($to);
        }

        $params = $message->toArray();

        $methodSend = 'sendMessage';
        if(isset($params['photo']) AND !empty($params['photo']))
            $methodSend = 'sendPhoto';

        $result = $this->telegram->sendMessage($methodSend, $params);
        $message->setResult($result);
        return $result;

    }
}
