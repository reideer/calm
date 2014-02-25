<?php

namespace Calm\Bundle\EducationalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use \Calm\Bundle\EducationalBundle\Entity\Answer;
use Calm\Bundle\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Calm\Bundle\SocialBundle\Form\AnswerType;
use Symfony\Component\HttpFoundation\JsonResponse;

class AnswerController extends Controller
{

    /**
     * @Route("/api/answer/{questionId}", name="_api_newAnswerQuestion", defaults={"_format"="json"})
     */
    public function apiNewAction($questionId)
    {
        $answer = new Answer();

        $form = $this->createForm(new AnswerType(), $answer);

        return $this->render('CalmEducationalBundle:Default:formAnswer.json.twig',
            array('formAnswer' => $form->createView(),
                'questionId' => $questionId)
        );
    }

    /**
     * @Route("/answer/{questionId}", name="_newAnswerQuestion")
     */
    public function newAction($questionId)
    {
        $answer = new Answer();

        $form = $this->createForm(new AnswerType(), $answer);


        return $this->render(
            'CalmEducationalBundle:Default:formAnswer.html.twig', array(
                'question' => $this->getQuestion($questionId),
                'formAnswer' => $form->createView()
            )
        );
    }

    /**
     * @Route("/create_answer/{questionId}", name="_answerQuestion")
     */
    public function createAction($questionId)
    {
        try {
            $answer = new Answer();
            $form = $this->createForm(new AnswerType(), $answer);

            if (!$this->getRequest()->isMethod('POST'))
                throw $this->createNotFoundException('Erro ao enviar dados ao servidor.');


            if (!$form->bind($this->getRequest())->isValid())
                throw new \Exception('Dados inválidos');

            $answer->setQuestion($this->getQuestion($questionId));
            $answer->setUser($this->getUser());

            $answer->setDescription(strip_tags($answer->getDescription()));
            $answer->setDescription(nl2br($answer->getDescription()));


            try {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($answer);
                $em->flush();

                return $this->apiGetInsertAnswer($answer->getId());
            } catch (Exception $e) {
                throw new \Exception('Erro ao salvar os dados');
            }


        } catch (\Exception $e) {
            return $this->apiError($e->getMessage());
        }
    }

    private function apiError($error)
    {
        $response = new JsonResponse();
        $questionResponse['status'] = 'fail';
        $questionResponse['error']['message'] = $error;
        $response->setData($questionResponse);
        return $response;
    }

    private function apiGetInsertAnswer($id)
    {

        $repository = $this->getDoctrine()->getRepository('CalmEducationalBundle:Answer');
        $repository->clear();
        $answer = $repository->find($id);

        $dataAnswer[0]['id'] = $answer->getId();
        $dataAnswer[0]['answer'] = $answer->getDescription();
        $dataAnswer[0]['published'] = $answer->getTimestamp()->format(\DateTime::ISO8601);
        $dataAnswer[0]['user']['id'] = $answer->getUser()->getId();
        $dataAnswer[0]['user']['firstname'] = $answer->getUser()->getFirstName();
        $dataAnswer[0]['user']['lastname'] = $answer->getUser()->getLastName();


        $questionResponse['status'] = 'ok';
        $questionResponse['question']['id'] = $answer->getQuestion()->getId();
        $questionResponse['question']['answers'] = $dataAnswer;

        $response = new JsonResponse();
        $response->setData($questionResponse);
        return $response;
    }


    /**
     *
     * @Route("/api/answers/{questionId}", name="_api_list_answer")
     */
    public function apiListAction($questionId)
    {
        $repository = $this->getDoctrine()->getRepository('CalmEducationalBundle:Answer');
        $answers = $repository->getAnswersByQuestion($questionId);

        if (!$answers && !is_array($answers)) {
            throw $this->createNotFoundException('Unable to find a Answers.');
        }

        $dataResponse = array();
        foreach ($answers as $answer) {
            $dataAnswer['id'] = $answer->getId();
            $dataAnswer['answer'] = $answer->getDescription();

            $dataAnswer['published'] = $answer->getTimestamp()->format(\DateTime::ISO8601);
            $dataAnswer['user']['id'] = $answer->getUser()->getId();
            $dataAnswer['user']['firstname'] = $answer->getUser()->getFirstName();
            $dataAnswer['user']['lastname'] = $answer->getUser()->getLastName();
            $dataResponse[] = $dataAnswer;
        }

        $response = new JsonResponse();
        $response->setData(array(
            'id' => $questionId,
            'data' => $dataResponse,

        ));
        return $response;
    }


    protected function getQuestion($questionId)
    {
        $question = $this->getDoctrine()->getRepository('CalmEducationalBundle:Question')->find($questionId);

        if (!$question) {
            throw $this->createNotFoundException('Unable to find a Question.');
        }

        return $question;
    }

}