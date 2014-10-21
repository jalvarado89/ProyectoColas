{{ Form::open(array('url' => "")) }}
	<input id="input-20" type="file" name="UploadAudio" accept="audio/mp3">
	<h4>Elija Opcion</h4>
	{{ Form::radio('Partir', 'Partes') }}<br>
	{{ Form::label('Partir', 'Por Cantidad de Partes', array('class' => 'ocultar')) }}
	{{ Form::select('Partir', ['1', '2', '3', '4', '5'], array('class' => 'ocultar')) }}
	<br>
	{{ Form::radio('Partir', 'Minutos') }}<br>
	{{ Form::label('Minutos', 'Por Minutos', array('class' => 'ocultar')) }}
	{{ Form::select('Minutos', ['1 Minuto', '2 Minutos', '3 Minutos', '4 Minutos'], array('class' => 'ocultar')) }}
	<br>
	{{Form::submit('Salvar', array())}}

{{ Form::close() }}
{{HTML::script('js/index.js')}}