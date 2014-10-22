<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPConnection;

receive();

	function receive(){
		$connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
		$channel = $connection->channel();


		$channel->queue_declare('cola', false, true, false, false);

		echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

		$callback = function($msg) {
		  
		  $msj = $msg->body;

		  $MsgArray = json_decode($msj);
    
		    $id = $MsgArray->id;
		    $name = $MsgArray->name1;
		    $url = $MsgArray->url;
		    $partes = $MsgArray->parts;
		    $partesmin = $MsgArray->timeperchunk;
		    $tipo = $MsgArray->type1;

		    if ($tipo == 1) {
		    	Partir($url, $partes, $name, $id);
		    } else {
		    	PartirMin($url, $partesmin, $name, $id);
		    }
		    

		  sleep(substr_count($msg->body, '.'));
		  $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
		};

		$channel->basic_qos(null, 1, null);
		$channel->basic_consume('cola', '', false, false, false, false, $callback);

		while(count($channel->callbacks)) {
		    $channel->wait();
		}

		$channel->close();
		$connection->close();
	}

	function Partir2($path, $cantidad, $nombre, $id){
		$onlyname = substr($nombre, 0, -4);
		$url_new = '/Download_Files/';

	    exec('ffmpeg -i ' . $path . $onlyname .'.mp3' ' -acodec copy -t 00:30:00 -ss 00:00:00 ' . $url_new . $onlyname . '1.mp3');

	    $fullname = $onlyname . '.mp3';
	    $ = $url_new . $onlyname . '1.mp3';
	    $msg_out = array('id' => $id, 'url' => $url_new, 'name1' => $fullname, 'channel' => $canal);

	    $msg_out=  json_encode($msg_out);

    //response($msg_out, $canal);

     $sql->runSql("UPDATE music
     SET url = '$url_new',     
     status = '1'
     WHERE
     id = $id;");

     $msj = array(
        'url' => 'public/Download_Files/' . $fullname, 
        'Music_id' => $id);

        Part::create($msj);  

	}
	function Partir($path, $cantidad){
	
		$time = exec("ffmpeg -i " . escapeshellarg($path) . " 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//");
		list($hms, $milli) = explode('.', $time);
		list($hours, $minutes, $seconds) = explode(':', $hms);
		$total_seconds = ($hours * 3600) + ($minutes * 60) + $seconds;
		
		echo "\n";
		echo $time."\n";
		echo $hms."\n";
		echo $total_seconds."\n";
		echo ($argv[1])."\n";

		$result_division = ($total_seconds/$argv[1]);
		$file = substr($path, 0, -4);
		$extesion = substr($path, -4, 4); 

		$o=0;
		for ($i=0; $i < $argv[1]; $i++) { 
			
			if ($i==0){
				exec("ffmpeg -t ". $result_division ." -i ".$file.$extesion." ".$file.$i.$extesion);
				exec("ffmpeg -ss ". $result_division ." -i ".$file.$extesion." ".$file."new".$i.$extesion);
			}else{
				exec("ffmpeg -t ". $result_division ." -i ".$file."new".$o.$extesion." ".$file.$i.$extesion);
				exec("ffmpeg -ss ". $result_division ." -i ".$file."new".$o.$extesion." ".$file."new".$i.$extesion);
				unlink($file."new".$o.$extesion);
				$o=$i;	
			}
			
		}
		unlink($file."new".$o.$extesion);
	}

	function PartirMin($path, $duracion){
	
			$time = exec("ffmpeg -i " . escapeshellarg($path) . " 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//");
			list($hms, $milli) = explode('.', $time);
			list($hours, $minutes, $seconds) = explode(':', $hms);
			$total_seconds = ($hours * 3600) + ($minutes * 60) + $seconds;
			
			echo "\n";
			echo $time."\n";
			echo $hms."\n";
			echo $total_seconds."\n";
			echo ($argv[1])."\n";

			$result_division = ($total_seconds/$argv[1]);
			$file = substr($path, 0, -4);
			$extesion = '.mp3'; 

			$o=0;
			for ($i=0; $i < $result_division; $i++) { 
				
				if ($i==0){
					exec("ffmpeg -t ". $argv[1]." -i ".$file.$extesion." ".$file.$i.$extesion);
					exec("ffmpeg -ss ". $argv[1] ." -i ".$file.$extesion." ".$file."new".$i.$extesion);
				}else{
					exec("ffmpeg -t ". $argv[1] ." -i ".$file."new".$o.$extesion." ".$file.$i.$extesion);
					exec("ffmpeg -ss ". $argv[1] ." -i ".$file."new".$o.$extesion." ".$file."new".$i.$extesion);
					unlink($file."new".$o.$extesion);
					$o=$i;	
				}
				
			}
			unlink($file."new".$o.$extesion);
	}