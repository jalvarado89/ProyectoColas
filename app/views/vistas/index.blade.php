{{ Form::open(array('url' => "Home", 'enctype' => 'multipart/form-data')) }}
	<input id="input-20" type="file" name="UploadAudio" accept="audio/mp3">
	<h4>Elija Opcion</h4>
	{{ Form::radio('Partir', 1, true ,array('class' => 'action')) }}<br>
	{{ Form::label('PartirPartes', 'Por Cantidad de Partes') }}
	{{ Form::select('Partes', array('0' => '', '1' => '1', '2' => '2', '3' => '3', '4' => '4'), 0 , array('class' => 'ocultar1')) }}
	<br>
	{{ Form::radio('Partir', 2, false ,array('class' => 'inaction')) }}<br>
	{{ Form::label('PartirMinutos', 'Por Minutos') }}
	{{ Form::select('PartesMinutos', ['', '1 Minuto', '2 Minutos', '3 Minutos', '4 Minutos'], 0 ,array('class' => 'ocultar2')) }}
	<br>
	{{ Form::submit('Salvar', array('onClick' => 'validar()')) }}

{{ Form::close() }}