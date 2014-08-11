<?php namespace api\Note;

use api\Library\BaseRepositoryDb;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class NoteRepositoryDb extends BaseRepositoryDb {

    use SoftDeletingTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'note';

    protected $fillable = array(
        'user_id',
        'title',
        'description',
    );

    /**
     * Return all user notes.
     * @param $user_id
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getUserNotes($user_id)
    {
        return self::where('user_id', $user_id)->get(array('id', 'title', 'description', 'created_at', 'updated_at'));
    }

    /**
     * Return a specific user note.
     * @param $user_id
     * @param $note_id
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getUserNote($user_id, $note_id)
    {
        return self::where('user_id', $user_id)->findOrFail($note_id, array('id', 'title', 'description', 'created_at', 'updated_at'));
    }
}
