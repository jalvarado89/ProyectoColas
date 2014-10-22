<?php
require_once __DIR__ . '/RabbitMQ/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Send {

	public static function EnviarCola($msj){

		$connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
		$channel = $connection->channel();

		$channel->queue_declare('cola', false, true, false, false);

		if(empty($data)) $data = $msj;

		$msg = new AMQPMessage($data, array('delivery_mode' => 2));
		$channel->basic_publish($msg, '', 'cola');		

		$channel->close();
		$connection->close();
	}

}