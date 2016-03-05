<?php
namespace Elevator\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use Elevator\Psr\Log\LoggerInterface;

abstract class MessageQueueEndpoint
{
    const MESSAGE_QUEUE_NAME = 'elevator_destinations_queue';

    protected $channel = null;
    protected $logger = null;

    private $connection = null;

    public function __construct(array $MQconfig, LoggerInterface $logger)
    {
        $this->connection = new AMQPStreamConnection(
            $MQconfig['host'],
            $MQconfig['port'],
            $MQconfig['user'],
            $MQconfig['password']
        );
        $this->channel = $this->connection->channel();
        $this->logger = $logger;
    }

    public function closeConnection()
    {
        $this->connection->close();
    }
}