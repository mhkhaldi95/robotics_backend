<?php

namespace Modules\Store\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Store\Entities\Purchase;
use Modules\Store\Entities\TicketItem;

class TicketApprovedEvent
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Purchase $purchase)
    {
        
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
