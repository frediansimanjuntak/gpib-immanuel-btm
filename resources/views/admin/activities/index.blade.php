@extends('layouts.admin')
@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Dashboard</h2>
    
        <div class="right-wrapper pull-right mr-md">
            <ol class="breadcrumbs mr-xl">
                <li>
                    <a href="{{route('admin.home')}}">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Activities</span></li>
            </ol>
        </div>
    </header>
    <div class="row">
        <div class="col-md-6">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <a class="btn btn-success pull-right" href="{{ route('admin.activities.create') }}"> Tambah Activity</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                        <a href="#" class="fa fa-times"></a>
                    </div>
    
                    <h2 class="panel-title">Activity</h2>
                </header>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table mb-none">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Activity</th>
                                    <th>Confirmed</th>
                                    <th width="280px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($activities as $activity)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $activity->name }}</td>
                                        <td>{{ $activity->confirmed }}</td>
                                        <td>
                                            <form action="{{ route('admin.activities.destroy',$activity->id) }}" method="POST">

                                                <a class="btn btn-primary" href="{{ route('admin.activities.edit',$activity->id) }}">Detail</a>

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
    {{-- pagination --}}
    {!! $activities->links() !!}
</section>
@endsection