<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCrated extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
protected $order;

    /**
     * OrderCrated constructor.
     * @param $name
     * @param $order
     */
    public function __construct($name, Order $order)
    {
        $this->name = $name;
        $this->order = $order;
    }


    public function build()
    {
        return $this->view('mail.order_created',['name'=>$this->name,'order'=>$this->order]);
    }
}
