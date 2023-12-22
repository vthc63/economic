<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyUserRegister extends Notification
{
    use Queueable;

    protected $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via()
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verifyUrl = env('APP_URL')
            . '/account/verify/'
            . $notifiable->getKey()
            . '?token=' . $this->token;
        return (new MailMessage)
                    ->subject('[MINTSHOP] XÁC NHẬN TÀI KHOẢN')
                    ->line('--------------------------------')
                    ->line('Xin chào ' . $notifiable->name . ', chào mừng bạn đã đến với MINTSHOP')
                    ->line('--------------------------------')
                    ->line('Để xác nhận tài khoản vui lòng bấm vào nút xác nhận dưới đây')
                    ->action('Xác Nhận', $verifyUrl);
    }
}
