<?php
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
/**
 * @desc Rabbit MQ:生产者
 * /usr/bin/php public/crontab/sent.php
 */
require __DIR__ . '/../crontab.php';

$queue = 'hello';
$queueContent = $queue . ' World: ' . date('Y-m-d H:i:s');

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare($queue, false, false, false, false);

$msg = new AMQPMessage($queueContent);
$channel->basic_publish($msg, '', $queue);

echo " [x] Sent '{$queueContent}'\n";

$channel->close();
$connection->close();

print_r(array_slice($argv, 1));