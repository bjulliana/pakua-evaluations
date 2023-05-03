@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Users Management</h2>
            </div>
            <div class="pull-right mb-4">
                <a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p class="mb-0">{{ $message }}</p>
        </div>
    @endif

    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Username</th>
                <th>Roles</th>
                <th>Action</th>
            </tr>
        </thead>
        @foreach ($data as $key => $user)
            <tr class="align-middle">
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->username }}</td>
                <td>
                    @if(!empty($user->getRoleNames()))
                        @foreach($user->getRoleNames() as $v)
                            <span class="badge bg-primary">{{ $v }}</span>
                        @endforeach
                    @endif
                </td>
                <td>
                    <a class="btn btn-info btn-sm" href="{{ route('users.show',$user->id) }}">View</a>
                    <a class="btn btn-primary btn-sm" href="{{ route('users.edit',$user->id) }}">Edit</a>
                    {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    </table>

{{--    <div class="table-responsive">--}}
{{--        <table class="table table-hover table-nowrap">--}}
{{--            <thead class="table-light">--}}
{{--                <tr>--}}
{{--                    <th scope="col">ID</th>--}}
{{--                    <th scope="col">Name</th>--}}
{{--                    <th scope="col">Job Title</th>--}}
{{--                    <th scope="col">Email</th>--}}
{{--                    <th scope="col">Phone</th>--}}
{{--                    <th scope="col">Lead Score</th>--}}
{{--                    <th scope="col">Company</th>--}}
{{--                    <th></th>--}}
{{--                </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--                <tr>--}}
{{--                    <td data-label="Job Title">--}}
{{--                        <a class="text-heading font-semibold" href="#">--}}
{{--                            Robert Fox--}}
{{--                        </a>--}}
{{--                    </td>--}}
{{--                    <td data-label="Job Title">--}}
{{--                        <a class="text-heading font-semibold" href="#">--}}
{{--                            Robert Fox--}}
{{--                        </a>--}}
{{--                    </td>--}}
{{--                    <td data-label="Email">--}}
{{--                        <span>Web Designer</span>--}}
{{--                    </td>--}}
{{--                    <td data-label="Phone">--}}
{{--                        <a class="text-current" href="mailto:robert.fox@example.com">robert.fox@example.com</a>--}}
{{--                    </td>--}}
{{--                    <td data-label="Lead Score">--}}
{{--                        <a class="text-current" href="tel:202-555-0152">202-555-0152</a>--}}
{{--                    </td>--}}
{{--                    <td data-label="Company">--}}
{{--                        <span class="badge bg-opacity-30 bg-success text-success">7/10</span>--}}
{{--                    </td>--}}
{{--                    <td data-label="">--}}
{{--                        <a class="text-current" href="#">Dribbble</a>--}}
{{--                    </td>--}}
{{--                    <td data-label="" class="text-end">--}}
{{--                        <div class="dropdown">--}}
{{--                            <a class="text-muted" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                <i class="bi bi-three-dots-vertical"></i>--}}
{{--                            </a>--}}
{{--                            <div class="dropdown-menu dropdown-menu-end">--}}
{{--                                <a href="#!" class="dropdown-item">--}}
{{--                                    Action--}}
{{--                                </a>--}}
{{--                                <a href="#!" class="dropdown-item">--}}
{{--                                    Another action--}}
{{--                                </a>--}}
{{--                                <a href="#!" class="dropdown-item">--}}
{{--                                    Something else here--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--                <tr>--}}
{{--                    <td data-label="Job Title">--}}
{{--                        <a class="text-heading font-semibold" href="#">--}}
{{--                            Darlene Robertson--}}
{{--                        </a>--}}
{{--                    </td>--}}
{{--                    <td data-label="Email">--}}
{{--                        <span>Developer</span>--}}
{{--                    </td>--}}
{{--                    <td data-label="Phone">--}}
{{--                        <a class="text-current" href="mailto:darlene@example.com">darlene@example.com</a>--}}
{{--                    </td>--}}
{{--                    <td data-label="Lead Score">--}}
{{--                        <a class="text-current" href="tel:224-567-2662">224-567-2662</a>--}}
{{--                    </td>--}}
{{--                    <td data-label="Company">--}}
{{--                        <span class="badge bg-opacity-30 bg-warning text-warning">5/10</span>--}}
{{--                    </td>--}}
{{--                    <td data-label="">--}}
{{--                        <a class="text-current" href="#">Netguru</a>--}}
{{--                    </td>--}}
{{--                    <td data-label="" class="text-end">--}}
{{--                        <div class="dropdown">--}}
{{--                            <a class="text-muted" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                <i class="bi bi-three-dots-vertical"></i>--}}
{{--                            </a>--}}
{{--                            <div class="dropdown-menu dropdown-menu-end">--}}
{{--                                <a href="#!" class="dropdown-item">--}}
{{--                                    Action--}}
{{--                                </a>--}}
{{--                                <a href="#!" class="dropdown-item">--}}
{{--                                    Another action--}}
{{--                                </a>--}}
{{--                                <a href="#!" class="dropdown-item">--}}
{{--                                    Something else here--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--            </tbody>--}}
{{--        </table>--}}
{{--    </div>--}}






    {!! $data->render() !!}
@endsection
