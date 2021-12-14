<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\ProductImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductImage[]    findAll()
 * @method ProductImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductImageRepository extends ServiceEntityRepository
{
    private ManagerRegistry $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
        parent::__construct($registry, ProductImage::class);
    }

    public function getImagesWithProductPaginated()
    {
        return $this->registry->getManager()
            ->createQueryBuilder()
            ->select('
                pi.id imageIdentifier,
                pi.title imageTitle,
                p.id productIdentifier,
                p.title productTitle
            ')
            ->from(ProductImage::class, 'pi')
            ->join(Product::class, 'p')
            ->getQuery()
            ->getResult();
    }
}
