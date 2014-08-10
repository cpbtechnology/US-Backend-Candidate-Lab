<?php namespace api\User;

use api\Library\BaseRepositoryDb;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class UserRepositoryDb extends BaseRepositoryDb {

    use SoftDeletingTrait;

}
