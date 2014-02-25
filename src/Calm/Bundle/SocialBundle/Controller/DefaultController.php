<?php

namespace Calm\Bundle\SocialBundle\Controller;
use Calm\Bundle\SocialBundle\Form\QuestionType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use \Calm\Bundle\EducationalBundle\Entity\FollowDiscipline;
use Calm\Bundle\EducationalBundle\Entity\Question;

class DefaultController extends Controller {

    /**
     *  @Route("/", name="_default")
     *  @Template()
     */
    public function indexAction() {

        return $this->streamAction();
    }

    /**
     * @Route("/stream")
     * @Template()
     */
    public function streamAction() {

        $idUser = $this->getUser()->getId();

        
        $disciplineRepository = $this->getDoctrine()
                ->getRepository('CalmEducationalBundle:Discipline');

        
        
        $disciplineFollowed = $disciplineRepository->getDisciplineFollowed($idUser);        
        $disciplines =  $disciplineRepository->listDisciplines(); 
        
        
        
        $questionRepository = $this->getDoctrine()
                ->getRepository('CalmEducationalBundle:Question');

        $questions = $questionRepository->getQuestionsByDiscipline($disciplineFollowed->getId());

        

        $question = new Question();
        $question->setDiscipline($disciplineFollowed);
        $form = $this->createForm(new QuestionType(), $question);
        
        
        return $this->render(
                        'CalmSocialBundle:Default:index.html.twig', 
                            array(
                                'questions' => $questions,
                                'disciplines' => $disciplines,
                                'followedDiscipline' => $disciplineFollowed,
                                'formQuestion' => $form->createView()
                            )
        );
    }

// 
//
//
//    /**
//     * @Route("/followdiscipline/{disciplineId}", name="_followDiscipline")
//     */
//    public function followDisciplineAction($disciplineId) {
//
//
//        $idUser = $this->getUser()->getId();
//
//        $repository = $this->getDoctrine()
//                ->getRepository('CalmEducationalBundle:FollowDiscipline');
//        $repository->getFollowDisciplines($this->getUser());
//        $qb = $repository->createQueryBuilder('fd');
//        $qb->update('CalmEducationalBundle:FollowDiscipline fd')
//                ->set('fd.active', '?1')
//                ->set('fd.endDate', 'CURRENT_TIMESTAMP()')
//                ->where('fd.user = ?2')
//                ->andWhere('fd.active = ?3')
//                ->setParameter(1, false)
//                ->setParameter(2, $this->getUser())
//                ->setParameter(3, true)
//                
//                ->getQuery()
//                ->execute();
//
//
//        $discipline = $this->getDoctrine()->getRepository('CalmEducationalBundle:Discipline')->find($disciplineId);
//        $user = $this->getDoctrine()->getRepository('CalmUserBundle:User')->find($this->getUser()->getId());
//        $followDiscipline = new FollowDiscipline();
//        $followDiscipline->setDiscipline($discipline);
//        $followDiscipline->setUser($user);
//
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($followDiscipline);
//        $em->flush();
//
//        return $this->streamAction();
//    }
//
//    public function followDiscipline($disciplineId) {
//        $discipline = $this->getDoctrine()->getRepository('CalmEducationalBundle:Discipline')->find($disciplineId);
//        $user = $this->getDoctrine()->getRepository('CalmUserBundle:User')->find($this->getUser()->getId());
//        $followDiscipline = new FollowDiscipline();
//        $followDiscipline->setDiscipline($discipline);
//        $followDiscipline->setUser($user);
//
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($followDiscipline);
//        $em->flush();
//    }

    /**
     * @Route("/disciplines", name="_listDisciplines")
     * @Template()
     */
    public function listDisciplinesAction() {
        $repository = $this->getDoctrine()
                ->getRepository('CalmEducationalBundle:Discipline');

        $disciplines = $repository->listDisciplines();
        return $this->render(
                        'CalmSocialBundle:Default:disciplines.html.twig', array('disciplines' => $disciplines)
        );
    }

    public function unfollowAllDisciplines() {
        //get all actives followed disciplines by user

        $idUser = $this->getUser()->getId();

        $repository = $this->getDoctrine()
                ->getRepository('CalmEducationalBundle:FollowDiscipline');
        $qb = $repository->createQueryBuilder('fd');
        $qb->update('CalmEducationalBundle:FollowDiscipline fd')
                ->set('fd.active', '?3')
                ->set('fd.endDate', 'CURRENT_TIMESTAMP()')
                ->where('fd.user = ?1')
                ->andWhere('fd.active = ?2')
                ->setParameter(1, $this->getUser())
                ->setParameter(2, true)
                ->setParameter(3, false)
//                ->setParameter(4, 'CURRENT_TIMESTAMP()')
                ->getQuery()
                ->execute();



//            $em = $this->getDoctrine()->getManager();
//            $query = $em->createQuery("
//            UPDATE CalmEducationalBundle:FollowDiscipline fd
//            SET fd.active = false
//            WHERE fd.user = :user
//            ");
//            
//                $query->setParameter('user', $this->getUser() );
//                $query->execute();
//                
    }

}