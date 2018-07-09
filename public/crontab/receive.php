<?php
use PhpAmqpLib\Connection\AMQPStreamConnection;
/**
 * /usr/bin/php public/crontab/receive.php
 */
require __DIR__ . '/../crontab.php';

$queue = 'hello';
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare($queue, false, false, false, false);

echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

$callback = function($msg) {
    echo " [x] Received ", $msg->body, "\n";
};

$channel->basic_consume($queue, '', false, true, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();