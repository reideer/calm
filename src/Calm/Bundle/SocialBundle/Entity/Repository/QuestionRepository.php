<?php

namespace Calm\Bundle\SocialBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class QuestionRepository extends EntityRepository {

    public function getQuestionsByDiscipline($idDiscipline) {

        $qb = $this
                ->createQueryBuilder('q')
                ->select('q, uq')
                ->innerJoin('q.user', 'uq')
                ->where('q.discipline = :idDiscipline')
                ->andWhere('q.active = :status')
                ->setParameter('idDiscipline', $idDiscipline)
                ->setParameter('status', true)
                ->orderBy('q.timestamp', 'DESC');

        return $qb->getQuery()->getResult();
    }
   

}
