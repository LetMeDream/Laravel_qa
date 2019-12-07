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

        /** Now, when integrating with VueJS and Axios, we won't needt to redirect to this route;
         * Instead, we will need to return a JSON response.
         */
        if($request->expectsJson()){

            return response()->json([
                'message' => 'Answer updated correctly',
                'body_html' => $answer->body
            ]);

        }


        return redirect()->route('questions.show', $question->slug)->with('success', 'Your answer was updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question , Answer $answer)
    {
        // Remember to authorize in the backend, as well, using our custom Policies.
        $this->authorize('delete', $answer);
        $answer->destroy($answer->id);

        /** Now, when integrating with VueJS and Axios, we won't needt to redirect to this route;
         * Instead, we will need to return a JSON response.
         */
        if(request()->expectsJson()){

            return response()->json([
                'message2' => 'Answer deleted correctly',
            ]);

        }


        return back()->with('success', 'Your answer was successfully deleted');

        /** NOTE:
         *  Remember there will be aditional logic in this part of the Answers CRUD.
         *  This aditional logic will cover the case when an Answer already selected as Best_answer is deleted.
         *
         *  For this particular case we have 2 options:
         *  1) The best answer could be prevented to be removed. Which can be done on our 'delete' policy.
         *  2) The best answer can be removed, but we will need to update column 'best_answer_id' in the Questions table whenever we do it.
         *
         *  In this app we will use the second approach.
         */

    }
}
