<?php namespace api\User;

use App;
use Auth;
use Input;
use Response;
use Hash;
use api\Library\BaseController;

class UserController extends BaseController {

    public $repository;
    public $validator;

    public function __construct(UserRepositoryDb $repository, UserValidator $validator)
    {
        parent::__construct();

        $this->beforeFilter('auth.basic', array('except' => 'store'));

        $this->repository = $repository;
        $this->validator = $validator;
    }

	/**
	 * Store a newly created user.
	 *
	 * @return Response
	 */
	public function store()
	{
        $requestData = Input::all();

        $validator = $this->validator->validate($requestData);

        if($validator->passes()) {
            $requestData['password'] = Hash::make($requestData['password']);

            $this->repository->create($requestData);

            return Response::make('ok', 200);

        } else {
            App::abort(400, $validator->messages());
        }
	}

	/**
	 * Update the specified user.
	 *
	 * @param  int  $user_id
	 * @return Response
	 */
	public function update($user_id)
	{
        if (Auth::user()->id != $user_id) {
            App::abort(401);
        }

        $requestData = Input::all();

        $validator = $this->validator->validate($requestData);

        if($validator->passes()) {
            $user = $this->repository->findOrFail($user_id);
            $user->save($requestData);

            return Response::make('ok', 200);

        } else {
            return Response::make($validator->messages(), 400);
        }
	}

}
