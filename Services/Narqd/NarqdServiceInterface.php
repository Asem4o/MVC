<?php

namespace Services\Narqd;

interface NarqdServiceInterface
{

    public function create(int $id ,string $narqd ,string $date);
    public function showNarqd(int $id): ?array;

    public function deleteNarqdById(int $noteId, int $userId);
    public function editNarqdById(int $userId ,int $id,string $text);

}