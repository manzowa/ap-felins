<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;


class CatInput
{
    #[Assert\NotBlank(groups: ['create'])]
    #[Assert\Length(max: 255)]
    public ?string $name = null;

    #[Assert\NotBlank(groups: ['create'])]
    #[Assert\Date]
    public ?string $birthDate = null;

    #[Assert\NotNull(groups: ['create'])]
    #[Assert\Positive]
    public ?int $breed = null;
    
    #[Assert\NotNull(groups: ['create'])]
    #[Assert\Positive]
    public ?int $owner = null;
}