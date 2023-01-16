@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Create a bew Thread') }}</div>

                    <div class="card-body">
                        <form method="POST" action="/threads">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input name="title" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="body">Title</label>
                                <textarea name="body" class="form-control" rows="8"></textarea>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">Publish</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
