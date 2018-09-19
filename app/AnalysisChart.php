<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property Analysis           $analysis
 * @property ChartType          $type
 * @property Collection|Label[] $labels
 */
class AnalysisChart extends Model
{
    protected $table = 'chart';
    public $timestamps = false;
    protected $fillable = array('label');

    public function analysis(): BelongsTo
    {
        return $this->belongsTo(Analysis::class, 'analysis_id');
    }

    public function type(): HasOne
    {
        return $this->hasOne(ChartType::class, 'id', 'type_id');
    }

    public function labels(): HasMany
    {
        return $this->hasMany(Label::class, 'chart_id');
    }

    /**
     * $this->x_label.
     */
    public function getXLabelAttribute(): Label
    {
        return $this->labels->where('type', 'x')->first();
    }

    /**
     * $this->y_label.
     */
    public function getYLabelAttribute(): Label
    {
        return $this->labels->where('type', 'y')->first();
    }
}
