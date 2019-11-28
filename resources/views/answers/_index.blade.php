<div class="row mt-4">

        <div class="col-md-12">

            <div class="card">

                <div class="card-header">

                    <div class="card-title">
                        <h2>{{ $answersCount . ' ' . str::plural('Answer', $answersCount) }}</h2>
                    </div>

                </div>

                <div class="card-body">

                    @foreach ($answers as $answer)

                        <div class="media mt-2">
                            <!-- Vote controls -->
                            <div class="d-flex flex-column  media-left vote-controls">
                                <a title='This question is useful' class='vote-up'>
                                    <i class='fas fa-caret-up fa-2x'></i>
                                </a>
                                <span class='votes-count'>123</span>
                                <a title='This question is not useful' class='vote-down off'>
                                    <i class='fas fa-caret-down fa-2x'></i>
                                </a>
                                <a title='Mark this as best answer' class='mt-2 vote-accept'>
                                    <i class='fas fa-check fa-2x'></i>
                                </a>
                                {{-- <span class='favorites-count'>13</span> --}}
                            </div>
                            <!-- Vote controls -->
                            <div class="media-body">
                                    {!! $answer->body_html !!}
                                <div class="float-right">
                                    <span class='text-muted'>{{$answer->created_date}}</span>
                                    <div class="media mt-1">
                                        <a href='{{ $answer->user->url }}' class='pr-2' >
                                            <img src=' {{ $answer->user->avatar }} '>
                                        </a>
                                        <div class="media-body mt-1">
                                            <a href='{{ $answer->user->url }}' class='pr-2' >
                                                 {{ $answer->user->name }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach

                </div>

            </div>

        </div>

</div>