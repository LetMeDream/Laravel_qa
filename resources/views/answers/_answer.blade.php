<answer :answer="{{ $answer }}" inline-template>

        <div class="media post mt-2">
                <!-- Vote controls -->


                    {{-- @include('shared._vote', [
                        'model' => $answer
                    ]) --}}

                    <vote name='answer' :model='{{$answer}}' ></vote>


                <!-- Vote controls -->
                <div class="media-body">
                    <form v-if='editing' @submit.prevent = " update " >

                        <div class="form-group">
                            <textarea required rows="4" v-model='body' class='form-control'></textarea>
                        </div>
                        <button type='submit' :disabled='isInvalid'  class='btn btn-outline-primary'>Update</button>
                        <button v-on:click.prevent=' cancel '    class='btn btn-outline-secondary'>Cancel</button>

                    </form>

                    <div v-else>
                        {{-- {!! $answer->body_html !!} --}}
                        <div v-html='body_html'></div>

                        <div class="row">
                            <div class="col-4">
                                <!-- Delete and updte stuff -->
                                <div class='float-left'>
                                        @if (Gate::allows('update', $answer))
                                            <a v-on:click.prevent='edit' {{-- href='{{ route("questions.answers.edit", [$question->id ,$answer->id]) }}' --}} class='btn btn-sm btn-outline-info'>Edit</a>
                                        @endif
                                        @if (Gate::allows('delete', $answer))
                                        <!-- Ajaxifying delete functionality -->
                                            <button v-on:click.prevent=" destroy " class='btn btn-outline-danger btn-sm' >Delete</button>
                                        {{-- <form action='{{ route("questions.answers.destroy", [$question->id, $answer->id]) }}' method='post' class='d-inline'>
                                            @method('delete')
                                            @csrf
                                        </form> --}}
                                        @endif
                                </div>
                                <!-- Delete and updte stuff -->
                            </div>
                            <div class="col-5"></div>
                            <div class="col-3">

                                {{-- @include('shared._author', [
                                    'model' => $answer,
                                    'label' => 'Answered'
                                ]) --}}

                                <user-info :model='{{ $answer }}' label='Answered'></user-info>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

</answer>