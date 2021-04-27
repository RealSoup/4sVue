<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Point {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $type;
    public $up_dn;
    public function __construct($type, $up_dn) {
        $this->type = $type;
        $this->up_dn = $up_dn;
    }

    public function broadcastOn() {
        return new PrivateChannel('channel-name');
    }
}
