# elevator
Tiny implementation of elevator calls scenario. Any number of callers and elevators allowed.

#Install:

  php composer.phar install

#Usage:

  Launch a worker for an elevator:

    php elevator-worker.php

  This command can be used multiple times. Every launch means a separate elevator functioning and receiving the calls.

  Launch the calls-producers, specifying the destination floor:

    php elevator-call.php 5
    php elevator-call.php 12
    php elevator-call.php 3

  Also can be called multiple times meaning that there is a queue of calls for available and running elevators. The destinations will be reached one after another for each particular queue of each elevator.


  *Requires rabbitMQ server to be running, please check the connection settings in:

     app/config/elevator-config.json