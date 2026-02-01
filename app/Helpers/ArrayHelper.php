<?php

if (!function_exists('paginateArray')) {
    /**
     * Paginate an array of items
     *
     * @param array $items
     * @param int $perPage
     * @param int|null $page
     * @return array
     */
    function paginateArray(array $items, int $perPage = 20, int $page = null)
    {
        $page = $page ?: (request('page') ?: 1);
        $page = max(1, $page); // Ensure page is at least 1
        
        $total = count($items);
        $lastPage = max(1, ceil($total / $perPage));
        $page = min($page, $lastPage); // Ensure page doesn't exceed last page
        
        $offset = ($page - 1) * $perPage;
        $slicedItems = array_slice($items, $offset, $perPage);
        
        return [
            'data' => $slicedItems,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'last_page' => $lastPage,
                'from' => $offset + 1,
                'to' => min($offset + $perPage, $total),
            ]
        ];
    }
}