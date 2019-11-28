<div class="row mt-4">

        <div class="col-md-12">

            <div class="card">

                <div class="card-header">

                    <div class="card-title">
                        <h3>Your answer</h3>
                    </div>

                </div>

                <div class="card-body">

                    <form action='{{ route("questions.answers.store", $question->id) }}' method='post'>
                        @csrf
                        <div class="form-group">

                            <textarea name='body' rows='7' class='form-control {{ $errors->has('body') ? 'is-invalid' : '' }}'></textarea>
                            @if ($errors->has('body'))
                                <div class="invalid-feedback">

                                    <strong>{{ $errors->first('body') }}</strong>

                                </div>
                            @endif
                        </div>
                        <div class="form-group">

                            <button class='btn btn-lg btn-outline-secondary'>Submit</button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

</div>