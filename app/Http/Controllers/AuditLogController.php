<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuditLogController extends Controller
{
    /**
     * Display audit logs
     */
    public function index(Request $request): JsonResponse
    {
        $query = AuditLog::with('user')
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan tabel
        if ($request->filled('table')) {
            $query->forTable($request->table);
        }

        // Filter berdasarkan action
        if ($request->filled('action')) {
            $query->forAction($request->action);
        }

        // Filter berdasarkan user
        if ($request->filled('user_id')) {
            $query->byUser($request->user_id);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->inDateRange($request->start_date, $request->end_date);
        }

        // Filter berdasarkan record tertentu
        if ($request->filled('table') && $request->filled('record_id')) {
            $query->forRecord($request->table, $request->record_id);
        }

        $logs = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $logs->items(),
            'pagination' => [
                'current_page' => $logs->currentPage(),
                'last_page' => $logs->lastPage(),
                'per_page' => $logs->perPage(),
                'total' => $logs->total(),
            ],
        ]);
    }

    /**
     * Get audit logs for specific record
     */
    public function getRecordHistory(Request $request, string $table, int $recordId): JsonResponse
    {
        $logs = AuditLog::forRecord($table, $recordId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $logs,
        ]);
    }

    /**
     * Get audit statistics
     */
    public function getStatistics(Request $request): JsonResponse
    {
        $startDate = $request->get('start_date', now()->subDays(30));
        $endDate = $request->get('end_date', now());

        $stats = [
            'total_changes' => AuditLog::inDateRange($startDate, $endDate)->count(),
            'by_action' => AuditLog::inDateRange($startDate, $endDate)
                ->selectRaw('action, COUNT(*) as count')
                ->groupBy('action')
                ->pluck('count', 'action'),
            'by_table' => AuditLog::inDateRange($startDate, $endDate)
                ->selectRaw('table_name, COUNT(*) as count')
                ->groupBy('table_name')
                ->pluck('count', 'table_name'),
            'recent_activities' => AuditLog::with('user')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }
}