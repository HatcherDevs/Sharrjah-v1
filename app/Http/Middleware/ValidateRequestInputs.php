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
     * Fields that should allow HTML content (WYSIWYG editors)
     */
    protected $htmlAllowedFields = [
        'content',
        'content_ar',
        'additional_content_top',
        'additional_content_bottom',
        'description',
        'description_ar',
        'body',
        'body_ar',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Validate and sanitize sort parameter
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            $allowedColumns = $this->getAllowedColumns($request);

            if (! in_array($sort, $allowedColumns)) {
                // Default to 'id' if invalid
                $request->merge(['sort' => 'id']);
            }
        }

        // Validate and sanitize order parameter
        if ($request->has('order')) {
            $order = $request->input('order');

            if (is_string($order)) {
                $order = trim($order);

                // Empty order field is valid for nullable numeric form inputs.
                if ($order === '') {
                    $request->request->remove('order');
                } elseif ($request->has('sort')) {
                    // Treat order as sort direction only when sort context exists.
                    $direction = strtolower($order);
                    if (! in_array($direction, ['asc', 'desc'])) {
                        $request->merge(['order' => 'desc']);
                    } else {
                        $request->merge(['order' => $direction]);
                    }
                } elseif (is_numeric($order)) {
                    // Keep numeric order values for form submissions (e.g. menu order).
                    $request->merge(['order' => (int) $order]);
                }
            } elseif (is_array($order)) {
                // Keep array payloads (e.g. drag-drop ordering) and normalize to integer values.
                $request->merge([
                    'order' => array_values(array_map('intval', $order)),
                ]);
            }
        }

        // Validate and normalize lang parameter
        if ($request->has('lang') && is_string($request->input('lang'))) {
            $lang = strtolower($request->input('lang'));

            // Normalize Arabic language variants (arArabic, ar-SA, arabic, etc.) to 'ar'
            if (strpos($lang, 'ar') === 0 || $lang === 'arabic') {
                $request->merge(['lang' => 'ar']);
                $_GET['lang'] = 'ar'; // Also update $_GET for backward compatibility
            } elseif (! in_array($lang, ['ar', 'en'])) {
                // Remove invalid lang parameter
                $request->request->remove('lang');
                unset($_GET['lang']);
            }
        }

        // Sanitize other string inputs to prevent XSS
        foreach ($request->all() as $key => $value) {
            if (is_string($value) && ! in_array($key, ['sort', 'order', '_token', 'id', 'publish_date', 'created_at', 'external'])) {
                // Skip HTML-allowed fields (WYSIWYG editors)
                if (in_array($key, $this->htmlAllowedFields)) {
                    continue;
                }
                // Basic XSS protection for non-HTML fields
                $request->merge([
                    $key => strip_tags($value),
                ]);
            }
        }

        return $next($request);
    }

    /**
     * Get allowed columns based on request context
     *
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
