<h1>Edit user {{$user->name}} </h1>

{!! Form::model($user, ['method'=>'PATCH', 'action' => ['UsersController@update', $user->id]]) !!}
	{!! Form::label('name', 'Name: ') !!}
	{!! Form::text('name') !!}
	<br>
	{!! Form::label('type', 'Type: ') !!}
	{!! Form::text('type') !!}
	<br>
	{!! Form::label('email', 'Email: ') !!}
	{!! Form::text('email') !!}
	<br>
	{!! Form::label('password', 'password: ') !!}
	{!! Form::password('password') !!}
	<br>
	<br>
	{!! Form::submit('Create User') !!}
{!! Form::close() !!}

@if($errors->any())
	<p>Please check that all the fields have been set correctly!</p>
@endif
