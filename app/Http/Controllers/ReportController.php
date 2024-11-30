<?php

namespace App\Http\Controllers;

use App\Models\Call;
use App\Models\Agent;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Call::with(['customer', 'agent']);

        // Filter by agent
        if ($request->filled('agent_id')) {
            $query->where('agent_id', $request->input('agent_id'));
        }

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->input('start_date'),
                $request->input('end_date')
            ]);
        }

        // Pagination
        $calls = $query->paginate(15);
        if ($request->ajax()) {
            // Return JSON response
            return response()->json([
                'status' => 'success',
                'html' => view('reports.calls_ajax', compact('calls'))->render(),
            ]);
        }
        $agents = Agent::all();

        return view('reports.calls', compact('calls', 'agents'));
    }
}
