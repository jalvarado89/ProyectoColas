<?php

include_once('./Connections/AbstractSql.php');
include_once('./Connections/PostgreSql.php');

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPConnection;

receive();

	function receive(){
		$connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
		$channel = $connection->channel();


		$channel->queue_declare('colas', false, true, false, false);

		echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

		$callback = function($msg) {

		  echo " [x] Received ", $msg->body, "\n";

		  $msj = $msg->body;

		  $MsgArray = json_decode($msj);
    	    		
		    $id = $MsgArray->id;
		    $name = $MsgArray->name1;
		    $url = $MsgArray->url;
		    $partes = $MsgArray->parts;
		    $partesmin = $MsgArray->timeperchunk;
		    $tipo = $MsgArray->type1;
		    $status = $MsgArray->status;


		    if ($status == 0) {
		    	if ($tipo == 1) {
		    	Partir($url, $partes, $name, $id);
		    	} else {
		    	PartirMin($url, $partesmin, $name, $id);
		    	}
		    }
		    
		    $sql->runSql("UPDATE music
	     		SET	status = '1'
	     		WHERE id = $id;");
		    		    		  
		};

		$channel->basic_consume('colas', '', false, false, false, false, $callback);

		while(count($channel->callbacks)) {
		    $channel->wait();
		}

		$channel->close();
		$connection->close();
	}




	function Partir($path, $cantidad, $nombre, $id){

		$server       = 'localhost';
		$database     = 'MusicBox';
		$user         = 'postgres';
		$password     = '12345';
		$driver_class = '\Connections\PostgreSql';


		$sql = new $driver_class($server, $database, $user, $password);
		$sql->connect();
		
		$time = exec("ffmpeg -i " . escapeshellarg('../'.$path . $nombre) . " 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//");

		list($hms, $milli) = explode('.', $time);
		list($hours, $minutes, $seconds) = explode(':', $hms);
		$total_seconds = ($hours * 3600) + ($minutes * 60) + $seconds;
		
		$result_division = ($total_seconds/$cantidad);		
		$file = substr($nombre, 0, -4);		
		$extesion = ".mp3"; 

		$o=0;
		for ($i=0; $i < $cantidad; $i++) { 
			
			if ($i==0){
				exec("ffmpeg -t ". $result_division ." -i ". '../'.$path . $nombre." "."audio".$i.$extesion);
				rename ("audio".$i.$extesion,'../public/Download_Files/'.$file.$i.$extesion);
				
				$destino = '../public/Download_Files/'.$file.$i.$extesion;
	     		$sql->runSql("INSERT INTO 
	     			Part (url, Music_id) 
	     			VALUES('$destino', $id)");

				exec("ffmpeg -ss ". $result_division ." -i " . '../'.$path . $nombre." "."audio"."new".$i.$extesion);
			}else{

				exec("ffmpeg -t ". $result_division ." -i "."audio"."new".$o.$extesion." "."audio".$i.$extesion);
				rename ("audio".$i.$extesion,'../public/Download_Files/'.$file.$i.$extesion);
				
				$destino = '../public/Download_Files/'.$file.$i.$extesion;
	     		$sql->runSql("INSERT INTO 
	     			Part (url, Music_id) 
	     			VALUES('$destino', $id)");

				exec("ffmpeg -ss ". $result_division ." -i "."audio"."new".$o.$extesion." "."audio"."new".$i.$extesion);
				unlink("audio"."new".$o.$extesion);
				$o=$i;	
			}
			
		}
		unlink("audio"."new".$o.$extesion);	

		$sql->disconnect();
	}
                




	function PartirMin($path, $cantidad, $nombre, $id){
	
		$server       = 'localhost';
		$database     = 'MusicBox';
		$user         = 'postgres';
		$password     = '12345';
		$driver_class = '\Connections\PostgreSql';

		$sql = new $driver_class($server, $database, $user, $password);
		$sql->connect();

			$time = exec("ffmpeg -i " . escapeshellarg('../'.$path . $nombre) . " 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//");
			list($hms, $milli) = explode('.', $time);
			list($hours, $minutes, $seconds) = explode(':', $hms);
			$total_seconds = ($hours * 3600) + ($minutes * 60) + $seconds;

			$cantidad = $cantidad * 60;
			$result_division = ($total_seconds/$cantidad);
			$file = substr($nombre, 0, -4);
			$extesion = '.mp3'; 

			$o=0;
			for ($i=0; $i < $result_division; $i++) { 
				
				if ($i==0){
					exec("ffmpeg -t ". $cantidad." -i ".'../'.$path . $nombre." "."audio".$i.$extesion);
					rename ("audio".$i.$extesion,'../public/Download_Files/' .$file.$i.$extesion);

					$destino = '../public/Download_Files/'.$file.$i.$extesion;
	     				$sql->runSql("INSERT INTO 
	     				Part (url, Music_id) 
	     				VALUES('$destino', $id)");

					exec("ffmpeg -ss ". $cantidad ." -i ". '../'.$path . $nombre." "."audio"."new".$i.$extesion);
				}else{
					exec("ffmpeg -t ". $cantidad ." -i "."audio"."new".$o.$extesion." "."audio".$i.$extesion);
					rename ("audio".$i.$extesion,'../public/Download_Files/'.$file.$i.$extesion);

					$destino = '../public/Download_Files/'.$file.$i.$extesion;
		     			$sql->runSql("INSERT INTO 
		     			Part (url, Music_id) 
		     			VALUES('$destino', $id)");

					exec("ffmpeg -ss ". $cantidad ." -i "."audio"."new".$o.$extesion." "."audio"."new".$i.$extesion);
					unlink("audio"."new".$o.$extesion);
					$o=$i;
				}
				
			}
			unlink("audio"."new".$o.$extesion);

			$sql->disconnect();
	}                                             