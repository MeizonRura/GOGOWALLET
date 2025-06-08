<?php

namespace App\GraphQL\Queries;

class VAInfoQuery
{
    public function __invoke($_, array $args)
    {
        // Contoh data statis, ganti dengan logic sesuai kebutuhan
        return [
            'nomor_va' => $args['nomor_va'],
            'nama'     => 'Contoh Nama',
            'status'   => 'active',
            'nominal'  => 100000,
        ];
    }
}