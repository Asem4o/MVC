<?php

namespace Repositories\Otpuska;

interface OtpuskaRepositoryInterface
{
    public function create(int $id , string $hours ,string $date);

    public function getAllOtpuska(int $id): ?array;
    public function deleteOtpuska(int $id);
    public function editOtpuska (int $id,string $text);


}