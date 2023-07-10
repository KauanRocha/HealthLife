<?php

namespace App\Service;

use App\Entity\Recurring;

class RecurringService
{
    public function newRecurring($data, $recurringRepository): ?Recurring
    {
        $recurring = new recurring();

        $recurring->setTitle($data['title']);

        $recurringRepository->save($recurring, true);

        return $recurring;
    }
}