<?php
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
/**
 * @desc Rabbit MQ:生产者
 * /usr/bin/php public/crontab/workQueuesTask.php
 */
require __DIR__ . '/../crontab.php';

$queueName = 'task_queue';
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare($queueName, false, true, false, false);

$data = implode(' ', array_slice($argv, 1));
if(empty($data)) $data = "Hello World!";
$msg = new AMQPMessage($data,
    array('delivery_mode' => 2) # make message persistent
);

$channel->basic_publish($msg, '', $queueName);

echo " [x] Sent ", $data, "\n";

$channel->close();
$connection->close();

print_r(array_slice($argv, 1));