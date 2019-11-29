@extends('layouts.app')

@section('content')

    <div class="container">
            <div class="row mt-4">

                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                                <div class="card-title">
                                    <h1>Editing answer for Question: <strong>{{ $question->title }}</strong></h1>
                                </div>

                            </div>

                            <div class="card-body">

                                <form action='{{ route("questions.answers.update", [$question->id, $answer->id]) }}' method='post'>
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-group">

                                    <textarea name='body' rows='7' class='form-control {{ $errors->has('body') ? 'is-invalid' : '' }}'>{{ old('body',$answer->body) }}</textarea>
                                        @if ($errors->has('body'))
                                            <div class="invalid-feedback">

                                                <strong>{{ $errors->first('body') }}</strong>

                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">

                                        <button class='btn btn-lg btn-outline-secondary'>Update</button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

            </div>
    </div>

@endsection