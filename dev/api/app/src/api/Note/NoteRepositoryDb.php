<?php namespace api\Note;

use api\Library\BaseRepositoryDb;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class NoteRepositoryDb extends BaseRepositoryDb {

    use SoftDeletingTrait;
}
