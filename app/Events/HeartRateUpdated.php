<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class HeartRateUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

    public $value;

    public function __construct($value)
    {
        //
        $this->value = $value;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel
    {
        return new Channel('patient-monitor');
    }

    public function broadcastWith(): array
    {
        return [
            'spo2'       => $this->value['SPO2_VALUE'] ?? null,
            'heart_rate' => $this->value['HEART_RATE'] ?? null,
            'resp_rate'  => $this->value['RESP_RATE'] ?? null,
            'ppg_pi'     => $this->value['PPG_PI'] ?? null,
            'body_temp'  => $this->value['BODY_TEMP'] ?? null,
            'waveform'   => $this->value['POINTS_ARRAY'] ?? [],
            'time' => $this->value['TIME'] ?? [],
            'dev_addr' => $this->value['dev_macaddr'] ?? null
        ];
    }

        public function broadcastAs()
    {
        return 'HeartRateUpdated';
    }

}
