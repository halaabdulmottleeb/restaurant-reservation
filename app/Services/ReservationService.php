<?php

namespace App\Services;

use App\Repositories\ReservationRepository;
use App\Repositories\TableRepository;

class ReservationService
{
    public function __construct(
        protected ReservationRepository $reservationRepository,
        protected TableRepository $tableRepository,

    ) {
    }

    public function reserve($data, $customer)
    {
        $isAvailable = $this->checkTableIsAvaialble($data);

        if (!$isAvailable) {
            return false; 
        }

        $data['customer_id'] = $customer->id;
        $reservation = $this->reservationRepository->create($data);
    
        return $reservation;
    }

    public function checkAvailability($data)
    {
        $date = $data['date'];
        $fromTime = $data['from_time'];
        $toTime = $data['to_time'];
        $capacity = $data['capacity'];

        return $this->tableRepository->getAvaialbleTable($capacity, $date, $fromTime, $toTime) ;
    }

    public function checkTableIsAvaialble($data) 
    {
        $date = $data['date'];
        $tableId = $data['table_id'];
        $fromTime = $data['from_time'];
        $toTime = $data['to_time'];
        $capacity = $data['capacity'];

        return $this->tableRepository->checkIsTableAvailable($tableId, $capacity, $date, $fromTime, $toTime) ;
    }
}