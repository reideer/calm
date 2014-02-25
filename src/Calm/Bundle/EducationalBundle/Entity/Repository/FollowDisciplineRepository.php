<?php

namespace Calm\Bundle\EducationalBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class FollowDisciplineRepository extends EntityRepository {

    public function getFollowDisciplines($user) {
        $qb = $this->createQueryBuilder('fd');
        $qb->update('CalmEducationalBundle:FollowDiscipline fd')
                ->set('fd.active', '?1')
                ->set('fd.endDate', 'CURRENT_TIMESTAMP()')
                ->where('fd.user = ?2')
                ->andWhere('fd.active = ?3')
                ->setParameter(1, false)
                ->setParameter(2, $user)
                ->setParameter(3, true)
                ->getQuery()
                ->execute();
    }

}
