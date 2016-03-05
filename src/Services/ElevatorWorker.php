<?php
namespace Elevator\Services;

use Elevator\Psr\Log\LoggerInterface;
use Elevator\Entity\Elevator;

class ElevatorWorker extends MessageQueueEndpoint
{
    private $elevator = null;

    public function __construct(array $config, LoggerInterface $logger)
    {
        parent::__construct($config, $logger);
        $this->elevator = new Elevator($this->logger);
    }

    public function consumeDestinations()
    {
        $this->channel->queue_declare(parent::MESSAGE_QUEUE_NAME, false, false, false, false);

        $this->logger->info("[*] Waiting for destinations. To exit press CTRL+C \n");

        $this->channel->basic_qos(null, 1, null);
        $this->channel->basic_consume(parent::MESSAGE_QUEUE_NAME, '', false, false, false, false, array($this, 'moveElevator'));

        while(count($this->channel->callbacks)) {
            $this->channel->wait();
        }

        $this->channel->close();
        parent::closeConnection();
    }

    public function moveElevator($msg)
    {
        $this->elevator->move($msg->body);
        $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
    }
}