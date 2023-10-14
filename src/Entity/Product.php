<?php 
declare(strict_types=1);

namespace App\Entity;

use App\Enum\ProductTypeEnum;
use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')] 
    #[ORM\Column(type: 'uuid', unique: true)] 
    #[ORM\CustomIdGenerator(UuidGenerator::class)] 
    private Uuid $id;

    private DateTimeImmutable $createdAt;
   
    #[ORM\Column(type: 'string', length: 255, enumType: ProductTypeEnum::class)]
    private ProductTypeEnum $productType;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): null|Uuid
    {
        return $this->id;
    }

    public function getProductType(): ?ProductTypeEnum
    {
        return $this->productType;
    }

    public function setProductType(ProductTypeEnum $productType): static
    {
        $this->productType = $productType;
        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    // Now when we access the $productType in a twig template like so 
    // {{ product.productType }}
    // it’ll return an object of ProductTypeEnum type. 
    // you can access the name or value 
    // like so respectively. {{ product.productType.name }} 
    // and ‘{{ product.productType.value }}.

}