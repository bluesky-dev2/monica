<?php

namespace App\Models\Journal;

use Parsedown;
use App\Helpers\DateHelper;
use App\Traits\Journalable;
use App\Models\Account\Account;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\IsJournalableInterface;

class Entry extends Model implements IsJournalableInterface
{
    use Journalable;

    protected $table = 'entries';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_id',
        'title',
        'post',
    ];

    /**
     * Get the account record associated with the entry.
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the Entry post.
     *
     * @param  string  $value
     * @return string
     */
    public function getPostAttribute($value)
    {
        return (new Parsedown())->text($value);
    }

    /**
     * Get all the information of the Entry for the journal.
     * @return array
     */
    public function getInfoForJournalEntry()
    {
        // Default to created_at, but show journalEntry->date if the entry type is JournalEntry
        $entryDate = $this->journalEntry ? $this->journalEntry->date : $this->created_at;

        return [
            'type' => 'entry',
            'id' => $this->id,
            'title' => $this->title,
            'post' => $this->post,
            'day' => $entryDate->day,
            'day_name' => mb_convert_case(DateHelper::getShortDay($entryDate), MB_CASE_TITLE, 'UTF-8'),
            'month' => $entryDate->month,
            'month_name' => mb_convert_case(DateHelper::getShortMonth($entryDate), MB_CASE_UPPER, 'UTF-8'),
            'year' => $entryDate->year,
        ];
    }
}
