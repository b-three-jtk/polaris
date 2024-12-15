<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminAccountDetail extends Notification implements ShouldQueue
{
    use Queueable;

    protected $name;
    protected $password;
    protected $role;

    /**
     * Create a new notification instance.
     *
     * @param string $name
     * @param string $password
     * @param string $role
     */
    public function __construct($name, $password, $role)
    {
        $this->name = $name;
        $this->password = $password;
        $this->role = $role;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
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
        return (new MailMessage)
                    ->subject('Informasi Akun Baru Anda')
                    ->greeting('Halo, ' . $this->name . '!')
                    ->line('Akun baru Anda telah dibuat. Berikut adalah detail akun Anda:')
                    ->line('Nama: ' . $this->name)
                    ->line('Password: ' . $this->password)
                    ->line('Peran: ' . $this->role)  // Menambahkan role
                    ->line('Silakan masuk dan ubah password Anda segera untuk keamanan akun Anda.')
                    ->action('Masuk Sekarang', 'http://127.0.0.1:8000/login')
                    ->line('Terima kasih telah menggunakan aplikasi kami!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            // You can add any additional data here if needed
        ];
    }
}