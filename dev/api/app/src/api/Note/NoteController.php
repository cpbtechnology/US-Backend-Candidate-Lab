<?php namespace api\Note;

use api\Library\BaseController;

class NoteController extends BaseController {

    public $repository;

    public function __construct(NoteRepositoryDb $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

	/**
	 * Display a listing of notes.
	 *
	 * @return Response
	 */
	public function index($user_id)
	{
		//
	}

	/**
	 * Display the specified note.
	 *
	 * @param $user_id
     * @param $note_id
	 */
    public function show($user_id, $note_id)
	{
		//

	}

	/**
	 * Store a newly created note.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Update the specified note.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified note.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
