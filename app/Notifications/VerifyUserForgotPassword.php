<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyUserForgotPassword extends Notification
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
            . '/account/change-new-password/'
            . '?token=' . $this->token;
        return (new MailMessage)
                    ->subject('[MINTSHOP] QUÊN MẬT KHẨU')
                    ->line('--------------------------------')
                    ->line('Để xác nhận bạn đang quên mật khẩu vui lòng bấm liên kết bên dưới chúng tôi sẽ giúp bạn hỗ trợ đổi lại mật khẩu mới')
                    ->action('Xác Nhận', $verifyUrl);
    }
}
