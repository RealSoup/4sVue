<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use App\Models\Board;

class BoardView {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request;
    public $board;
    public function __construct(Request $request, Board $board) {
        $this->request = $request;
        $this->board = $board;
    }

    public function broadcastOn() {
        return new PrivateChannel('channel-name');
    }
}
