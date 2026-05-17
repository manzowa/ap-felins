<?php 

namespace App\Service;

use App\Entity\Cat;
use App\Entity\Breed;
use App\Entity\Owner;
use App\Dto\CatInput;
use App\Repository\BreedRepository;
use App\Repository\OwnerRepository;
use Doctrine\ORM\EntityManagerInterface;

class CatService
{
    public function __construct(
        private BreedRepository $breedRepository,
        private OwnerRepository $ownerRepository,
        private EntityManagerInterface $entityManager
    ) {}

    public function hydrate(Cat $cat, array $data): Cat
    {
        if (isset($data['name'])) {
            $cat->setName($data['name']);
        }

        if (isset($data['birthDate'])) {
            try {
                $cat->setBirthDate(\DateTimeImmutable::createFromMutable(new \DateTime($data['birthDate'])));
            } catch (\Exception $e) {
                throw new \InvalidArgumentException('Invalid date');
            }
        }

        if (!empty($data['breed'])) {
            $breed = $this->breedRepository->find($data['breed']);
            if (!$breed) {
                throw new \InvalidArgumentException('Breed not found');
            }
            $cat->setBreed($breed);
        }

        if (!empty($data['owner'])) {
            $owner = $this->ownerRepository->find($data['owner']);
            if (!$owner) {
                throw new \InvalidArgumentException('Owner not found');
            }
            $cat->setOwner($owner);
        }

        return $cat;
    }

    public function hydrateFromInput(Cat $cat, CatInput $input): Cat
    {
        if ($input->name !== null) {
            $cat->setName($input->name);
        }

        if ($input->birthDate !== null) {
             try {
                $cat->setBirthDate(new \DateTimeImmutable($input->birthDate));
            } catch (\Exception $e) {
                throw new \InvalidArgumentException('Invalid birthDate format');
            }
        }

        // ✅ Use find() to validate existence
        if ($input->breed !== null) {
            $breed = $this->breedRepository->find($input->breed);
            if (!$breed) {
                throw new \DomainException('Breed not found');
            }
            $cat->setBreed($breed);
        }

        if ($input->owner !== null) {
            $owner = $this->ownerRepository->find($input->owner);
            if (!$owner) {
                throw new \DomainException('Owner not found');
            }
            $cat->setOwner($owner);
        }

        $this->entityManager->flush();

        return $cat;
    }

    public function createFromInput(CatInput $catInput): Cat
    {
        
        $cat = new Cat();
        $cat = $this->hydrateFromInput($cat, $catInput);
        $this->entityManager->persist($cat);
        $this->entityManager->flush();
        
        return $cat;
    }

    public function updateFromInput(Cat $cat, CatInput $catInput): Cat
    {
        $cat = $this->hydrateFromInput($cat, $catInput);
        $this->entityManager->flush();
        return $cat;
    }

    public function delete(Cat $cat): void
    {
        // Logique de suppression (ex: vérification de contraintes, etc.)
        // Note: la suppression réelle est gérée par le contrôleur via EntityManager
        $this->entityManager->remove($cat);
        $this->entityManager->flush();
    }

    public function patchFromInput(Cat $cat, CatInput $catInput): Cat
    {
        if ($catInput->name !== null) {
            $cat->setName($catInput->name);
        }
        if ($catInput->birthDate !== null) {
            $cat->setBirthDate(new \DateTimeImmutable($catInput->birthDate));
        }
        if ($catInput->breed !== null) {
            $breed = $this->breedRepository->find($catInput->breed);
            if (!$breed) {
                throw new \DomainException('Breed not found');
            }
            $cat->setBreed($breed);
        }
        if ($catInput->owner !== null) {
            $owner = $this->ownerRepository->find($catInput->owner);
            if (!$owner) {
                throw new \DomainException('Owner not found');
            }
            $cat->setOwner($owner);
        }

        $this->entityManager->flush();

        return $cat;
    }

    public function findBreedById(int $id): ?Breed
    {
        return $this->breedRepository->find($id);
    }  

    public function findOwnerById(int $id): ?Owner
    {
        return $this->ownerRepository->find($id);
    }
}