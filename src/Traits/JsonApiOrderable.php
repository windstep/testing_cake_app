<?php

namespace App\Traits;

trait JsonApiOrderable
{
    protected function getOrderFromRequest()
    {
        $sortFields = explode(',', $this->request->getQuery('sort') ?? '');
        $direction = explode(',', $this->request->getQuery('direction') ?? '');
        $order = [];
        foreach ($sortFields as $i => $sortField) {
            if (empty($sortField)) {
                return;
            }

            $order[$sortField] = $direction[$i] ?? 'asc';
        }

        return $order;
    }
}
