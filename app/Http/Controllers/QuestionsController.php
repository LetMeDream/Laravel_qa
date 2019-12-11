<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use App\Http\Requests\AskQuestionRequest;

class QuestionsController extends Controller
{
    /** We can also set the Auth middleware from here */
    public function __construct(){

        $this->middleware('auth', ['except' => ['index', 'show']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* \DB::enableQueryLog(); */

        $questions = Question::with('user')->orderBy('votes_count', 'DESC')->paginate(5);

        //dd($questions);

        return view('questions.index', compact('questions'));

        /* dd(\DB::getQueryLog()); */



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $question = new Question;

        return view('questions.create', compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request)
    {
        /** Now the request validating is handled in App\Http\Requests\AskQuestionsRequest */

        /** We just store the question, related to the user, by calling their relation previosly defined. */
        $request->user()->questions()->create($request->all());

        return redirect()->route('questions.index')->with('success', 'Your question has been submitted');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        /* dd($question->body); */
        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
        $this->authorize('update', $question);
        return view('questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(AskQuestionRequest $request, Question $question)
    {
        $question->update($request->only('title', 'body'));

        if(request()->expectsJson()){

            return response()->json([
                    'message' => 'Questions successfully updated'
            ]);

        }

        return redirect()->route('questions.index')->with('success', 'Your question was successfully edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $this->authorize('delete', $question);

        $question->destroy($question->id);

        if(request()->expectsJson()){

            return response()->json([
                    'message' => 'Questions successfully deleted'
            ]);

        }

        return redirect('/questions')->with('success', 'Question succesfully deleted');
    }
}
