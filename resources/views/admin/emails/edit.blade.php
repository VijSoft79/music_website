@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Email</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Email</h3>
                    </div>

                    <form method="post" action="{{ route('admin.email.update', $emailMessage) }}">
                        @csrf

                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Title</label>
                                <input name="title" value="{{ $emailMessage->title }}" type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Email Type</label>
                                <select class="form-control" name="email_type" disabled>
                                    <option value="registration notif">Admin registration notification</option>
                                    <option value="registration notif to curator">Email to curator when they register</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Email to</label>
                                <select class="form-control" name="email_to">
                                    <option value="">select</option>
                                    <option value="curator" {{ old('email_to', $emailMessage->email_to) == 'curator' ? 'selected' : '' }}>curator</option>
                                    <option value="musician" {{ old('email_to', $emailMessage->email_to) == 'musician' ? 'selected' : '' }}>musician</option>
                                    <option value="admin" {{ old('email_to', $emailMessage->email_to) == 'admin' ? 'selected' : '' }}>admin</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Content</label>
                                <textarea name="content" class="form-control" rows="3" placeholder="Enter email content...">{{ $emailMessage->content }}</textarea>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@stop
