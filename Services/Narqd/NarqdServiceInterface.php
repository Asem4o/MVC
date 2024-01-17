<?php

namespace Services\Narqd;

interface NarqdServiceInterface
{

    public function create(string $id ,string $narqd ,string $date);
    public function showNarqd(int $id): ?array;

    public function deleteNarqdById(string $noteId, string $userId);
    public function editNarqdById(string $userId ,string $id,string $text);

}