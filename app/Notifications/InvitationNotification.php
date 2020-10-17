<?php

namespace App\Notifications;

use App\User;
use App\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\Team\Entities\Team;

class InvitationNotification extends Notification
{
    use Queueable;

    protected $team;
    protected $user;
    protected $student;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Team $team, User $user,Student $student )
    {
        $this->team = $team;
        $this->user = $user;
        $this->student = $student;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url(route('teams.show',[$this->team]));
        $message = sprintf(
            '%s has invited to team "%s"',
            $this->user->first_name,
            $this->team->name
        );
        return (new MailMessage)
            ->subject('Robotics')
            ->line('Hello '. $notifiable->first_name)
            ->line($message)
            ->action('Show Invite', $url);
    }

    public function toDatabase($notifiable){
        $url = url(route('teams.show',[$this->team]));
        $message = sprintf(
            '%s has invited to team "%s"',
            $this->user->first_name,
            $this->team->name
        );
        return [
            'message' => $message,
            'url' => $url,
        ];
    }

    public function toBroadcast($notifiable){
        $url = url(route('teams.show',[$this->team]));
        $message = sprintf(
            '%s has invited to team "%s"',
            $this->user->first_name,
            $this->team->name
        );
        return [
            'message' => $message,
            'url' => $url,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
