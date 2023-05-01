{!! Form::open(array('route' => 'route.name', 'method' => 'POST')) !!}
	<ul>
		<li>
			{!! Form::label('itinerancy_id', 'Itinerancy_id:') !!}
			{!! Form::text('itinerancy_id') !!}
		</li>
		<li>
			{!! Form::label('discipline', 'Discipline:') !!}
			{!! Form::text('discipline') !!}
		</li>
		<li>
			{!! Form::label('date', 'Date:') !!}
			{!! Form::text('date') !!}
		</li>
		<li>
			{!! Form::submit() !!}
		</li>
	</ul>
{!! Form::close() !!}