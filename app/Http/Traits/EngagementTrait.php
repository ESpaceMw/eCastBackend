<?php

/**
 * Engagement trait
 */

use App\Models\Engagements;

trait EngagementTrait
{
    protected function create($userId){

        $engagement = new Engagements();

        $engagement->user_id = $userId;

        $engagement->save();
    }
}
