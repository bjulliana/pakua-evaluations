{!! Form::open(array('route' => 'route.name', 'method' => 'POST')) !!}
	<ul>
		<li>
			{!! Form::label('evaluation_id', 'Evaluation_id:') !!}
			{!! Form::text('evaluation_id') !!}
		</li>
		<li>
			{!! Form::label('name', 'Name:') !!}
			{!! Form::text('name') !!}
		</li>
		<li>
			{!! Form::label('receipt_number', 'Receipt_number:') !!}
			{!! Form::text('receipt_number') !!}
		</li>
		<li>
			{!! Form::label('activity_1', 'Activity_1:') !!}
			{!! Form::text('activity_1') !!}
		</li>
		<li>
			{!! Form::label('activity_2', 'Activity_2:') !!}
			{!! Form::text('activity_2') !!}
		</li>
		<li>
			{!! Form::label('activity_3', 'Activity_3:') !!}
			{!! Form::text('activity_3') !!}
		</li>
		<li>
			{!! Form::label('activity_4', 'Activity_4:') !!}
			{!! Form::text('activity_4') !!}
		</li>
		<li>
			{!! Form::label('activity_5', 'Activity_5:') !!}
			{!! Form::text('activity_5') !!}
		</li>
		<li>
			{!! Form::label('activity_6', 'Activity_6:') !!}
			{!! Form::text('activity_6') !!}
		</li>
		<li>
			{!! Form::label('result', 'Result:') !!}
			{!! Form::text('result') !!}
		</li>
		<li>
			{!! Form::label('graduation', 'Graduation:') !!}
			{!! Form::text('graduation') !!}
		</li>
		<li>
			{!! Form::label('stripes', 'Stripes:') !!}
			{!! Form::text('stripes') !!}
		</li>
		<li>
			{!! Form::label('notes', 'Notes:') !!}
			{!! Form::textarea('notes') !!}
		</li>
		<li>
			{!! Form::submit() !!}
		</li>
	</ul>
{!! Form::close() !!}