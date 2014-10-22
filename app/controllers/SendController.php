<?php

require_once __DIR__ . '/RabbitMQ/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class SendController extends BaseController {

	public function EnviarCola(){

		$connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
		$channel = $connection->channel();

		$channel->queue_declare('hello', false, false, false, false);

		$msg = new AMQPMessage('Hello World!');
		$channel->basic_publish($msg, '', 'hello');

		echo " [x] Sent 'Hello World!'\n";

		$channel->close();
		$connection->close();
	}

}


