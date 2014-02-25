<?php

namespace Calm\Bundle\EducationalBundle\Entity\Repository;
use Doctrine\ORM\EntityRepository;
class DisciplineRepository  extends EntityRepository{
    
    public function getDisciplineFollowed($idUser){
         $qb = $this
                ->createQueryBuilder('d')
                 ->select('d')
                 ->leftJoin('d.followDisciplines', 'fd')
                 ->leftJoin('fd.user', 'ufd')
                 ->where('ufd.id = :idUser')
                 ->andWhere('fd.active = :statusFollowDiscipline')
                 ->setParameter('idUser',$idUser )
                 ->setParameter('statusFollowDiscipline',true );
         return $qb->getQuery()->getSingleResult();
    }
    
    public function getQuestionsByDisciplineFollowed($idUser){
        
        $qb = $this
                ->createQueryBuilder('d')
                ->select('d, q, u, uq, fd, ufd')
                ->leftJoin('d.questions', 'q')
                ->leftJoin('d.createdUser', 'u')
                ->leftJoin('q.user', 'uq')
                ->leftJoin('d.followDisciplines', 'fd')
                ->leftJoin('fd.user', 'ufd')
                ->where('ufd.id = :idUser')
                ->andWhere('fd.active = :status')
                ->setParameter('idUser', $idUser)
                ->setParameter('status', true)
                ->orderBy('q.timestamp', 'DESC');

        return $qb->getQuery()->getResult();
    }
    
    
     public function getQuestionsByDiscipline($idDiscipline){
        
        $qb = $this
                ->createQueryBuilder('q')
                ->select('q, uq')
                ->leftJoin('q.user', 'uq')
                ->setParameter('q.idDiscipline', $idDiscipline)
                ->setParameter('q.status', true)
                ->orderBy('q.timestamp', 'DESC');

        return $qb->getQuery()->getResult();
    }
    
    public function listDisciplines(){

        $qb = $this
                ->createQueryBuilder('d')
                ->select('d')
                ->Where('d.active = :status')
                ->setParameter('status', true);

        return $qb->getQuery()->getResult();
    }
    
    public function unfollowAllDiscipline(){
                $qb = $this->createQueryBuilder('fd');
                $qb->update('CalmEducationalBundle:FollowDiscipline fd')
                ->set('fd.active', '?1')
                ->set('fd.endDate', 'CURRENT_TIMESTAMP()')
                ->where('fd.user = ?2')
                ->andWhere('fd.active = ?3')
                ->setParameter(1, false)
                ->setParameter(2, $this->getUser())
                ->setParameter(3, true)
                
                ->getQuery()
                ->execute();
    }
}
