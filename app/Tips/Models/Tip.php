<?php

namespace App\Tips\Models;

use App\Cohort;
use App\Interfaces\HasLabelProperty;
use App\Student;
use App\Traits\TranslatableEntity;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Tips\Models\Tip.
 *
 * @property string                 $name              Name of the tip
 * @property bool                   $showInAnalysis    Whether or not the tip should be displayed in analyses
 * @property int                    $id                ID of the tip
 * @property Statistic[]|Collection $coupledStatistics of the tip
 * @property string                 $tipText           The text including placeholders used for displaying the tip
 * @property Cohort[]|Collection    $enabledCohorts
 * @property Like[]|Collection      $likes
 * @property string                 $trigger
 * @property int                    $rangeStart
 * @property int                    $rangeEnd
 * @property Moment[]|Collection    $moments
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tips\Models\Tip whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tips\Models\Tip whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tips\Models\Tip whereRangeEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tips\Models\Tip whereRangeStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tips\Models\Tip whereShowInAnalysis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tips\Models\Tip whereTipText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tips\Models\Tip whereTrigger($value)
 * @mixin \Eloquent
 *
 * @property \Illuminate\Database\Eloquent\Collection|\App\Tips\Models\StudentTipView[] $studentTipViews
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tips\Models\Tip newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tips\Models\Tip newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tips\Models\Tip query()
 */
class Tip extends Model implements HasLabelProperty
{
    use TranslatableEntity;

    public $timestamps = false;

    /**
     * The likes this Tip has given by Students.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function likesByStudent(Student $student)
    {
        return $this->hasMany(Like::class)->where('student_id', '=', $student->student_id);
    }

    /**
     * The cohorts this Tip is enabled for.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function enabledCohorts()
    {
        return $this->belongsToMany(Cohort::class);
    }

    /**
     * The coupled statistics used for this tip.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function coupledStatistics()
    {
        return $this->hasMany(TipCoupledStatistic::class);
    }

    public function dislikedByStudent(Student $student): bool
    {
        return $this->likes()->where('student_id', '=', $student->student_id)
            ->where('type', '=', -1)
            ->count() > 0;
    }

    public function likedByStudent(Student $student): bool
    {
        return $this->likes()->where('student_id', '=', $student->student_id)
                ->where('type', '=', 1)
                ->count() > 0;
    }

    public function studentTipViews(): HasMany
    {
        return $this->hasMany(StudentTipView::class);
    }

    public function moments(): HasMany
    {
        return $this->hasMany(Moment::class);
    }

    public function getLabel(): string
    {
        return $this->tipText;
    }
}
