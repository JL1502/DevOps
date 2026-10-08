<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Authorization is enforced in the controller via Gate::authorize,
        // so this stays true; validation here only governs input shape.
        return true;
    }

    /**
     * Allowlist of fields a student is permitted to submit.
     * user_id, status, is_admin, and role are intentionally absent —
     * if a client sends them, they are simply never read or stored.
     */
    public function rules(): array
    {
        return [
            'item_name' => ['required', 'string', 'max:150'],
            'quantity'  => ['required', 'integer', 'min:1'],
            'purpose'   => ['required', 'string', 'max:2000'],

            // Trusted fields: if a client sends any of these, validation fails
            // instead of silently ignoring them (T07).
            'user_id'   => ['prohibited'],
            'status'    => ['prohibited'],
            'is_admin'  => ['prohibited'],
            'role'      => ['prohibited'],
        ];
    }
}