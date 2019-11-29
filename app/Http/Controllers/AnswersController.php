<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;
use App\Question;

class AnswersController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question ,Request $request)
    {
        // dd($question);

        $data = $request->validate([
            'body' => 'required'
        ]);

        /* dd(\Auth::id()); */

        $question->answers()->create([ 'body' => $request->body, 'user_id' => \Auth::id() ]);

        return back()->with('success', 'Your answer was successfully created');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question ,Answer $answer)
    {
        // Remember to authorize in the backend, as well, using our custom Policies.
        $this->authorize('update', $answer);

        return view('answers.edit', compact('question', 'answer'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question , Answer $answer)
    {
        // Remember to authorize in the backend, as well, using our custom Policies.
        $this->authorize('update', $answer);

        $data = $request->validate([
            'body' => 'required'
        ]);

        /* dd($data); */
        $answer->update($data);

        return redirect()->route('questions.show', $question->slug)->with('success', 'Your answer was updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        //
    }
}
