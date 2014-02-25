<?php

namespace Calm\Bundle\EducationalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use \Calm\Bundle\EducationalBundle\Entity\FollowDiscipline;
use Calm\Bundle\UserBundle\Entity\User;

class DisciplineController extends Controller {

    
    /**
     * @Route("/followdiscipline/{disciplineId}", name="_followDiscipline")
     */
    public function followDisciplineAction($disciplineId) {

        $this->unfollowAllDisciplinesFromUser($this->getUser());
        $this->followDiscipline($this->getUser(), $disciplineId);
         return $this->redirect($this->generateUrl('_default'));

/**        $response = $this->forward('CalmSocialBundle:Default:index', array(
                ));

        // ... further modify the response or return it directly

        return $response;**/
    }

    private function unfollowAllDisciplinesFromUser(User $user) {
        $repository = $this->getDoctrine()
                ->getRepository('CalmEducationalBundle:FollowDiscipline');

        $qb = $repository->createQueryBuilder('fd');
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
    
    private function followDiscipline(User $user, $disciplineId) {

        $discipline = $this->getDoctrine()->getRepository('CalmEducationalBundle:Discipline')->find($disciplineId);

        $user = $this->getDoctrine()->getRepository('CalmUserBundle:User')->find($this->getUser()->getId());


        $followDiscipline = new FollowDiscipline();
        $followDiscipline->setDiscipline($discipline);
        $followDiscipline->setUser($user);


        $em = $this->getDoctrine()->getManager();
        $em->persist($followDiscipline);
        return $em->flush();
    }
}
