<?php
namespace Elevator\Services;

use InvalidArgumentException;
use PhpAmqpLib\Message\AMQPMessage;
use Elevator\Psr\Log\LoggerInterface;

class DestinationProducer extends MessageQueueEndpoint
{
    public function __construct($config, LoggerInterface $logger)
    {
        parent::__construct($config['MQConnection'], $logger);
    }

    public function pushDestination($floor)
    {
        $this->channel->queue_declare(parent::MESSAGE_QUEUE_NAME, false, false, false, false);

        // TODO: validate the floor
        $msg = new AMQPMessage($floor,
            array('delivery_mode' => 2) # make message persistent
        );

        $this->channel->basic_publish($msg, '', parent::MESSAGE_QUEUE_NAME);

        $this->logger->info(" [x] Sent destination floor: " . $floor . "\n");

        $this->channel->close();
        parent::closeConnection();
    }
}