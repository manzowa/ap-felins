<?php 

namespace App\Dto;

use App\Entity\Cat;

class CatOutput
{
    public ?int $id = null;
    public ?string $name = null;
    public ?string $birthDate = null;
    public ?string $breed = null;
    public ?string $owner = null;

    public static function fromEntity(Cat $cat): self
    {
        $dto = new self();

        $dto->id = $cat->getId(); // safe après flush
        $dto->name = $cat->getName();
        $dto->birthDate = $cat->getBirthDate()?->format('Y-m-d');
        $dto->breed = $cat->getBreed() ? $cat->getBreed()->getName() : null ;
        $dto->owner = $cat->getOwner()? $cat->getOwner()->getName() : null;

        return $dto;
    }
}