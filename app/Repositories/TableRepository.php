<?php

namespace App\Repositories;

use App\Models\Table;

class TableRepository extends BaseRepository
{
    public function __construct(Table $model)
    {
        parent::__construct($model);
    }

    public function getAvaialbleTable($capacity, $date, $fromTime, $toTime) 
    {
        return $this->model::whereDoesntHave('reservations', function ($query) use ($capacity, $date, $fromTime, $toTime) {
            $query->whereDate('date', $date)
                ->where('capacity', '>=', $capacity)
                ->where(function ($query) use ($fromTime, $toTime) {
                    $query->where(function ($query) use ($fromTime, $toTime) {
                        $query->where('from_time', '<', $toTime)
                            ->where('to_time', '>', $fromTime);
                    });
                });
        })->get();
    }

    public function checkIsTableAvailable($tableId, $capacity, $date, $fromTime, $toTime) 
    {
        $table = $this->find($tableId);

        if ($table->capacity < $capacity) {
            return false;
        }

        return $table->reservations()
            ->whereDate('date', $date)
            ->where(function($query) use ($fromTime, $toTime) {
                $query->whereRaw("('$fromTime' < to_time AND '$toTime' > from_time)");
            })
            ->get()->isEmpty();
    }
}