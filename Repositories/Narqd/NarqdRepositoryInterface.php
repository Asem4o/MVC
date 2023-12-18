<?php

namespace Repositories\Narqd;

interface NarqdRepositoryInterface
{
    public function create(int $id , string $hours ,string $date);

    public function getAllNarqds (int $id): ?array;
    public function deleteNarqd (int $id);
    public function editNarqd (int $id,string $text);
    public function getByNarqdGuid(string $userId);



}