<?php namespace api\Note;

use App;
use Auth;
use Response;
use Input;
use api\Library\BaseController;

class NoteController extends BaseController {

    public $repository;
    public $validator;

    public function __construct(NoteRepositoryDb $repository, NoteValidator $validator)
    {
        parent::__construct();

        $this->beforeFilter('auth.basic');

        $this->repository = $repository;
        $this->validator = $validator;
    }

	/**
	 * Display a listing of notes.
	 *
	 * @return Response
	 */
	public function index($user_id)
	{
        if (Auth::user()->id != $user_id) {
            App::abort(401);
        }

        $notes = $this->repository->getUserNotes($user_id);
        return Response::json($notes);
	}

    /**
     * Display the specified note.
     *
     * @param $user_id
     * @param $note_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($user_id, $note_id)
	{
        if (Auth::user()->id != $user_id) {
            App::abort(401);
        }

        $note = $this->repository->getUserNote($user_id, $note_id);
        return Response::json($note);
	}

    /**
     * Store a newly created note.
     * @param $user_id
     * @return Response
     */
    public function store($user_id)
	{
        if (Auth::user()->id != $user_id) {
            App::abort(401);
        }

        $requestData = Input::all();

        $validator = $this->validator->validate($requestData);

        if($validator->passes()) {
            $requestData['user_id'] = Auth::user()->id;
            $this->repository->create($requestData);

            return Response::make('ok', 200);

        } else {
            return Response::make($validator->messages(), 400);
        }
	}

    /**
     * Update the specified note.
     * @param $user_id
     * @param $note_id
     * @return Response
     */
    public function update($user_id, $note_id)
	{
        // get the note
        $note = $this->repository->findOrFail($note_id);

        // does user own the note?
        if ($note->user_id != $user_id) {
            App::abort(401);
        }

        $requestData = Input::all();

        $validator = $this->validator->validate($requestData);

        if($validator->passes()) {
            $note->title = $requestData['title'];
            $note->description = $requestData['description'];
            $note->save();

            return Response::make('ok', 200);

        } else {
            return Response::make($validator->messages(), 400);
        }
	}

    /**
     * Remove the specified note.
     * @param $user_id
     * @param $note_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id, $note_id)
	{
        // get the note
        $note = $this->repository->findOrFail($note_id);

        // does user own the note?
        if ($note->user_id != $user_id) {
            App::abort(401);
        }

        $note->delete();

        return Response::make('ok', 200);
	}

}
