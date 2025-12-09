<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateRequestInputs
{
    /**
     * Allowed sort columns for different contexts
     */
    protected $allowedSortColumns = [
        'default' => ['id', 'title', 'created_at', 'updated_at', 'publish_date', 'date'],
        'publications' => ['id', 'title', 'publish_date', 'publication', 'publication_ar'],
        'podcasts' => ['id', 'title', 'date', 'series', 'series_ar'],
        'materials' => ['id', 'title', 'created_at'],
        'posts' => ['id', 'title', 'created_at', 'slug'],
    ];

    /**
     * Allowed order directions
     */
    protected $allowedOrderDirections = ['asc', 'desc', 'ASC', 'DESC'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Validate and sanitize sort parameter
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            $allowedColumns = $this->getAllowedColumns($request);
            
            if (!in_array($sort, $allowedColumns)) {
                // Default to 'id' if invalid
                $request->merge(['sort' => 'id']);
            }
        }

        // Validate and sanitize order parameter
        if ($request->has('order')) {
            $order = strtolower($request->input('order'));
            
            if (!in_array($order, ['asc', 'desc'])) {
                // Default to 'desc' if invalid
                $request->merge(['order' => 'desc']);
            }
        }

        // Sanitize other string inputs to prevent XSS
        foreach ($request->all() as $key => $value) {
            if (is_string($value) && !in_array($key, ['sort', 'order', '_token'])) {
                // Basic XSS protection
                $request->merge([
                    $key => strip_tags($value)
                ]);
            }
        }

        return $next($request);
    }

    /**
     * Get allowed columns based on request context
     *
     * @param  Request  $request
     * @return array
     */
    protected function getAllowedColumns(Request $request)
    {
        $path = $request->path();

        if (strpos($path, 'publication') !== false) {
            return $this->allowedSortColumns['publications'];
        } elseif (strpos($path, 'podcast') !== false) {
            return $this->allowedSortColumns['podcasts'];
        } elseif (strpos($path, 'material') !== false) {
            return $this->allowedSortColumns['materials'];
        } elseif (strpos($path, 'post') !== false || strpos($path, 'opportunities') !== false) {
            return $this->allowedSortColumns['posts'];
        }

        return $this->allowedSortColumns['default'];
    }
}