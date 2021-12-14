<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

class SimplePaginator
{
    public function paginate(array $data, int $limit, int $page): array
    {
        $totalCount = \count($data);

        if ($limit > 0 && $limit <= $totalCount) {
            $totalPages = $totalCount / $limit;
            if ($totalPages >= $page) {
                $chunks = array_chunk($data, $limit);
                $returnData['data'] = $chunks[$page];
            }
        } else {
            $returnData['data'] = $data;
        }

        $returnData['metadata'] = [
            'page' => $page,
            'perPage' => $limit,
            'totalCount' => $totalCount,
        ];

        return $returnData;
    }
}
