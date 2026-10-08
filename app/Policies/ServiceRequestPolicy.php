<?php

namespace App\Policies;

use App\Models\ServiceRequest;
use App\Models\User;

class ServiceRequestPolicy
{
    /**
     * Any signed-in user may view the list (the controller scopes
     * which rows they actually see — this just gates the page itself).
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Only the owner or an administrator may view a single record.
     */
    public function view(User $user, ServiceRequest $serviceRequest): bool
    {
        return $user->is_admin || $user->id === $serviceRequest->user_id;
    }

    /**
     * Only students (non-administrators) may create a request.
     */
    public function create(User $user): bool
    {
        return ! $user->is_admin;
    }

    /**
     * Only an administrator may update the status field.
     */
    public function updateStatus(User $user, ServiceRequest $serviceRequest): bool
    {
        return $user->is_admin;
    }
}