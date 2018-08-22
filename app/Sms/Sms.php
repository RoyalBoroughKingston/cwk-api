<?php

namespace App\Sms;

use App\Contracts\SmsSender;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class Sms implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @var string
     */
    public $to;

    /**
     * @var array
     */
    public $values;

    /**
     * @var string
     */
    public $templateId;

    /**
     * @var string|null
     */
    public $reference;

    /**
     * @var string|null
     */
    public $senderId;

    /**
     * @var \App\Models\Notification|null
     */
    public $notification;

    /**
     * Sms constructor.
     *
     * @param string $to
     * @param array $values
     */
    public function __construct(string $to, array $values = [])
    {
        $this->queue = 'notifications';

        $this->to = $to;
        $this->values = $values;
        $this->templateId = $this->getTemplateId();
        $this->reference = $this->getReference();
        $this->senderId = $this->getSenderId();
    }

    /**
     * @return string
     */
    abstract protected function getTemplateId(): string;

    /**
     * @return string|null
     */
    abstract protected function getReference(): ?string;

    /**
     * @return string|null
     */
    abstract protected function getSenderId(): ?string;

    /**
     * @return string
     */
    abstract public function getContent(): string;

    /**
     * @return void
     */
    public function send()
    {
        $this->handle(resolve(SmsSender::class));
    }

    /**
     * Execute the job.
     *
     * @param \App\Contracts\SmsSender $smsSender
     * @return void
     */
    public function handle(SmsSender $smsSender)
    {
        // Send the SMS.
        $smsSender->send($this);

        // Update the notification.
        if ($this->notification) {
            $this->notification->update(['sent_at' => now()]);
        }
    }
}
