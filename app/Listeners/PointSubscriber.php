<?php
namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use DB;

class PointSubscriber {
    public function subscribe($events) {
        $events->listen( \App\Events\Point::Class, [PointSubscriber::class, 'Point'] );
    }

    public function Point($event) {
        $point = config('point.'.$event->type.".point");
        $content = config('point.'.$event->type.".content");

        DB::table('point')->insert( [
            'po_content' => $content.(($event->up_dn == 'dn')?' 취소':''),
            'po_point' => $point*(($event->up_dn == 'dn')?(-1):1),
            'created_id' => auth()->guard('api')->user()->id
        ] );
    }

}
