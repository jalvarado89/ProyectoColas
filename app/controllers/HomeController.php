<?php

class HomeController extends BaseController {

	public function index()
	{
		$this->layout->titulo = 'Home';
        $this->layout->nest(
            'content',
            'vistas.index',
			array()
        );
	}

	public function create()
	{
		$tipo = Input::get('Partes');		
		$partes = Input::get('Partir');		
		$minutos = Input::get('PartesMinutos');			

		if(Input::hasFile('UploadAudio')) 
		{
			$file = Input::file('UploadAudio');
			$extension = $file->getClientOriginalExtension();
			$name = substr($file->getClientOriginalName(), 0, 6);
			$name = $name . '.' . $extension;   		                                 
                
            $file->move( 'public/Upload_Files/', $name);

	    }else{
	    	$this->layout->titulo = 'Home';
			return $this->layout->nest(
            'content',
            'vistas.index',
			array()
        	);
	    }

	    $msj = array(
        'url' =>'public/Upload_Files/'.$name,     
        'parts' => $partes,
        'timeperchunk' => $minutos,
        'type1' => $tipo,
        'status' => '0'
        );

         $id = Music::create($msj)->id;           
         $objmusic = Music::findOrFail($id);    		
    	 $json_objmusic =  json_encode($objmusic);


          //ponemos en cola  $json_music
		  ModelCola::cola($json_music);
		return Response::Json($ruta);
		
		//return Redirect::to('Home');
	}

}
