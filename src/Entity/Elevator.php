<?php
namespace Elevator\Entity;

use Elevator\Psr\Log\LoggerInterface;

class Elevator
{
    const NEUTRAL_STATE = 'Stop';
    const GOINGUP_STATE = 'GoingUp';
    const GOINGDOWN_STATE = 'GoingDown';
    const ONE_FLOOR_PASS_TIME = 3; // seconds to pass one floor
    const ELEVATOR_STOP_TIME = 5; // seconds before taking new task

    private $currentState;
    private $currentFloor;
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->setCurrentState(self::NEUTRAL_STATE);
        $this->setCurrentFloor(1);
    }

    /**
     * @return string
     */
    public function getCurrentState()
    {
        return $this->currentState;
    }

    /**
     * @param string $currentState
     */
    public function setCurrentState($currentState)
    {
        $this->logger->info("Elevator state changes: " . $this->currentState . ' -> ' . $currentState . "\n");
        $this->currentState = $currentState;
    }

    /**
     * @return integer
     */
    public function getCurrentFloor()
    {
        return $this->currentFloor;
    }

    /**
     * @param integer $currentFloor
     */
    public function setCurrentFloor($currentFloor)
    {
        $this->logger->info("Current Floor changes: " . $this->currentFloor . ' -> ' . $currentFloor . "\n");
        $this->currentFloor = $currentFloor;
    }

    /**
     * @param integer $destinationFloor
     */
    public function move($destinationFloor)
    {
        $difference = $destinationFloor - $this->currentFloor;
        if ($difference > 0) {
            $this->setCurrentState(self::GOINGUP_STATE);
        } elseif ($difference < 0) {
            $this->setCurrentState(self::GOINGDOWN_STATE);
        } else {
            $this->logger->info("Welcome on board! Elevator is here!\n");
            return;
        }

        $this->simulateMovement(abs($difference));

    }

    /**
     * @param integer $floorsNumber
     */
    private function simulateMovement($floorsNumber)
    {
        for($i = 1; $i <= $floorsNumber; $i++) {
            sleep(self::ONE_FLOOR_PASS_TIME);
            $nextFloor = (self::GOINGUP_STATE == $this->currentState) ? $this->currentFloor + 1 : $this->currentFloor - 1;
            $this->setCurrentFloor($nextFloor);
        }

        $this->setCurrentState(self::NEUTRAL_STATE);
        sleep(self::ELEVATOR_STOP_TIME);
    }
}