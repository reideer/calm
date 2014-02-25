<?php

namespace Calm\Bundle\EducationalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use \Calm\Bundle\EducationalBundle\Entity\FollowDiscipline;
use \Calm\Bundle\EducationalBundle\Entity\Question;
use Calm\Bundle\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Calm\Bundle\SocialBundle\Form\QuestionType;
use Symfony\Component\HttpFoundation\JsonResponse;


class QuestionController extends Controller
{

    /**
     * @Route("/askaquestions/{discipline_id}", name="_askQuestion")
     */
    public function askAQuestion($discipline_id)
    {

        $question = new Question();

        $form = $this->createForm(new QuestionType(), $question);

        if ($this->getRequest()->isMethod('POST')) {

            $form->bind($this->getRequest());

            if ($form->isValid()) {

                $question = $form->getData();
                $question->setDiscipline($this->getDiscipline($discipline_id));
                $question->setUser($this->getUser());


                $question->setDescription(strip_tags($question->getDescription()));
                $question->setDescription(nl2br($question->getDescription()));


                $em = $this->getDoctrine()->getEntityManager();

                $em->persist($question);
                $em->flush();

                return $this->redirect($this->generateUrl('_default'));
            }
        }
        throw $this->createNotFoundException('Unable to persist a Question.');
    }


    /**
     * Return a Questions json encoded filtered by the discipline ID
     * @Route("/api/discipline/questions/{disciplineId}", name="_apiQuestiondByDiscipline")
     */
    public function apiGetQuestionsByDiscipline($disciplineId)
    {
        $questionRepository = $this->getDoctrine()->getRepository('CalmEducationalBundle:Question');
        $questions = $questionRepository->getQuestionsByDiscipline($disciplineId);


        if (!$questions && !is_array($questions)) {
            throw $this->createNotFoundException('Unable to find a Question.');
        }

        $dataResponse = array();
        foreach ($questions as $question) {
            $dataAnswer['id'] = $question->getId();
            $dataAnswer['question'] = $question->getDescription();

            $dataAnswer['published'] = $question->getTimestamp()->format(\DateTime::ISO8601);
            $dataAnswer['user']['id'] = $question->getUser()->getId();
            $dataAnswer['user']['firstname'] = $question->getUser()->getFirstName();
            $dataAnswer['user']['lastname'] = $question->getUser()->getLastName();
            $dataResponse[] = $dataAnswer;
        }

        $response = new JsonResponse();
        $response->setData(array(
            'id' => $disciplineId,
            'data' => $dataResponse,

        ));
        return $response;


    }

    protected function getDiscipline($disciplineId)
    {
        $discipline = $this->getDoctrine()->getRepository('CalmEducationalBundle:Discipline')->find($disciplineId);

        if (!$discipline) {
            throw $this->createNotFoundException('Unable to find a Discipline.');
        }

        return $discipline;
    }


}