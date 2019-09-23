<?php

namespace App\Repository\Eloquent;

use App\Evidence;
use App\LearningActivityActing;
use App\Student;

class LearningActivityActingRepository
{
    /**
     * @var EvidenceRepository
     */
    private $evidenceRepository;

    public function __construct(EvidenceRepository $evidenceRepository)
    {
        $this->evidenceRepository = $evidenceRepository;
    }

    public function get(int $id): LearningActivityActing
    {
        return LearningActivityActing::findOrFail($id);
    }

    /**
     * @param int[] $ids
     *
     * @return LearningActivityActing[]
     */
    public function getMultiple(array $ids): array
    {
        return LearningActivityActing::findMany($ids)->all();
    }

    /**
     * @param int[] $ids
     *
     * @return LearningActivityActing[]
     */
    public function getMultipleForUser(Student $student, array $ids): array
    {
        return $student->getCurrentWorkplaceLearningPeriod()->learningActivityActing()->whereIn('laa_id', $ids)->get()->all();
    }

    public function save(LearningActivityActing $learningActivityActing): bool
    {
        return $learningActivityActing->save();
    }

    /**
     * @return LearningActivityActing[]
     */
    public function getActivitiesForStudent(Student $student): array
    {
        return $student->getCurrentWorkplaceLearningPeriod()->learningActivityActing()
            ->with('timeslot', 'resourcePerson', 'resourceMaterial', 'learningGoal', 'competence')
            ->orderBy('date', 'DESC')
            ->get()->all();
    }

    public function delete(LearningActivityActing $learningActivityActing): bool
    {
        try {
            $learningActivityActing->competence()->detach();

            $learningActivityActing->evidence->each(function (Evidence $evidence) {
                $this->evidenceRepository->delete($evidence);
            });

            return $learningActivityActing->delete();
        } catch (\Exception $e) {
            return false;
        }
    }
}
