<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequestRequest;
use App\Http\Requests\UpdateServiceRequestStatusRequest;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ServiceRequestController extends Controller
{
    /**
     * GET /requests
     * Students see only their own records; administrators see all.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', ServiceRequest::class);

        $query = ServiceRequest::query();

        // 1. Ownership scope FIRST. Students are limited to their own user_id
        //    (never requester_name or requester_email); admins see everything.
        if (! $request->user()->is_admin) {
            $query->where('user_id', $request->user()->id);
        }

        // 2. Optional filter: status must be one of the allowed values.
        if (in_array($request->query('status'), ['pending', 'approved', 'rejected'], true)) {
            $query->where('status', $request->query('status'));
        }

        // 3. Optional search. The OR conditions are grouped in a closure so they
        //    cannot escape the user_id scope above.
        if ($search = trim((string) $request->query('search'))) {
            $query->where(function ($q) use ($search) {
                $q->where('item_name', 'like', '%' . $search . '%')
                  ->orWhere('purpose', 'like', '%' . $search . '%');
            });
        }

        // 4. Pagination runs on the already-scoped query; withQueryString()
        //    keeps the filter/search on every page link.
        $requests = $query->latest()->paginate(10)->withQueryString();

        return view('requests.index', compact('requests'));
    }

    /**
     * GET /requests/{serviceRequest}
     * Owner or administrator only.
     */
    public function show(Request $request, ServiceRequest $serviceRequest)
    {
        Gate::authorize('view', $serviceRequest);

        return view('requests.show', compact('serviceRequest'));
    }

    /**
     * GET /requests/create
     */
    public function create()
    {
        Gate::authorize('create', ServiceRequest::class);

        return view('requests.create');
    }

    /**
     * POST /requests
     * Trusted fields (user_id, requester_name, requester_email, status)
     * are assigned server-side — never taken from client input.
     */
    public function store(StoreServiceRequestRequest $request)
    {
        Gate::authorize('create', ServiceRequest::class);

        $validated = $request->validated(); // item_name, quantity, purpose only

        $serviceRequest = ServiceRequest::create([
            'user_id'         => $request->user()->id,
            'requester_name'  => $request->user()->name,
            'requester_email' => $request->user()->email,
            'item_name'       => $validated['item_name'],
            'quantity'        => $validated['quantity'],
            'purpose'         => $validated['purpose'],
            'status'          => 'pending',
        ]);

        return redirect()
            ->route('requests.show', $serviceRequest)
            ->with('status', 'Request submitted.');
    }

    /**
     * PATCH /requests/{serviceRequest}/status
     * Administrator only. Updates the status column exclusively.
     */
    public function updateStatus(UpdateServiceRequestStatusRequest $request, ServiceRequest $serviceRequest)
    {
        Gate::authorize('updateStatus', $serviceRequest);

        $validated = $request->validated(); // status only, checked against allowlist

        $serviceRequest->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('requests.show', $serviceRequest)
            ->with('status', 'Request status updated.');
    }
}