<?php

namespace App\Listeners;

use App\Events\BoardView;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Cookie;

class BoardSubscriber {
    public function subscribe($events) {
        $events->listen(
            \App\Events\BoardView::Class,
            [BoardSubscriber::class, 'BoardView']
        );
    }

    public function BoardView($event) {
        $c_nm = $event->board->getTable().'_'.$event->board->bo_id;
        $cookie = $event->request->cookie($c_nm);
        if(!$cookie) {
            if($event->board->increment('bo_click'))
        	   Cookie::queue($c_nm, true);
           // Cookie::queue($c_nm, true, 60*24);  // 만료시간 분단위
        }
    }
}
