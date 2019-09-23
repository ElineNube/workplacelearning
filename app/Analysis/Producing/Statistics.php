<?php

namespace App\Analysis\Producing;

/**
 * Class Statistics provides easy access to statistics of user's activities.
 */
class Statistics
{
    private $analysisData;

    public function __construct(array $analysisData)
    {
        $this->analysisData = $analysisData;
    }

    /**
     * @return float perceived difficulty of user's tasks
     */
    public function averageDifficulty()
    {
        return round($this->analysisData['avg_difficulty'], 1);
    }

    /**
     * @return float percentage of tasks that the user found difficult
     */
    public function percentageDifficultTasks()
    {
        if ($this->analysisData['num_lap'] === 0) {
            return 0;
        }

        return round(($this->analysisData['num_difficult_lap'] / $this->analysisData['num_lap']) * 100, 1);
    }

    /**
     * @return float percentage of hours the user found easy
     */
    public function percentageEasyHours()
    {
        if ($this->analysisData['num_hours'] === 0) {
            return 0;
        }

        return round(($this->analysisData['hours_difficult_lap'] / $this->analysisData['num_hours']) * 100, 1);
    }

    /**
     * @return float percentage of hours the user found difficult
     */
    public function percentageDifficultHours()
    {
        if ($this->analysisData['num_hours'] === 0) {
            return 0;
        }

        return round((($this->analysisData['hours_difficult_lap'] / $this->analysisData['num_hours']) * 100), 1);
    }

    /**
     * @return float percentage of hours the user spent working alone
     */
    public function percentageAloneHours()
    {
        if ($this->analysisData['num_hours'] === 0) {
            return 0;
        }

        return round(($this->analysisData['num_hours_alone'] / $this->analysisData['num_hours']) * 100, 1);
    }

    /**
     * @return float persentage of average person difficulty
     */
    public function persentageAveragePersonDifficulty()
    {
        if ($this->analysisData['person_difficulty'] === null) {
            return 0;
        }

        return round(($this->analysisData['person_difficulty']->difficult_activities / $this->analysisData['num_total_lap']) * 100,
            1);
    }

    /**
     * @return string name of person where the activities are the easiest
     */
    public function averagePersonDifficultyName()
    {
        if ($this->analysisData['person_difficulty'] === null) {
            return false;
        }

        return $this->analysisData['person_difficulty']->name;
    }

    /**
     * @return string name of the most difficult category
     */
    public function mostDifficultCategoryName()
    {
        return $this->analysisData['category_difficulty'][0]->name;
    }

    /**
     * @return float persentage of most difficult category
     */
    public function persentageMostDifficultCategory()
    {
        return round($this->analysisData['category_difficulty'][0]->difficulty * 10, 1);
    }
}
