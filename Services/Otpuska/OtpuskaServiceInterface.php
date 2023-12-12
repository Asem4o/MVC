<?php
namespace Services\Otpuska;
interface OtpuskaServiceInterface
{
    public function create(int $id ,string $otpuska ,string $date);
    public function showOtpuska(int $id): ?array;

    public function deleteOtpuska(int $noteId, int $userId);
    public function editOtpuskaById(int $userId ,int $id,string $text);


}