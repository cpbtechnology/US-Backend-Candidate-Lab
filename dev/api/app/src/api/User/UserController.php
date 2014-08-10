<?php namespace api\User;

use api\Library\BaseController;

class UserController extends BaseController {

    public $repository;

    public function __construct(UserRepositoryDb $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

	/**
	 * Store a newly created user.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Update the specified user.
	 *
	 * @param  int  $user_id
	 * @return Response
	 */
	public function update($user_id)
	{
		//
	}

	/**
	 * Remove the specified user.
	 *
	 * @param  int  $user_id
	 * @return Response
	 */
	public function destroy($user_id)
	{
		//
	}

}
