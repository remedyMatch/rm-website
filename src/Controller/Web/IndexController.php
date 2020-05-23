<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Repository\FaqSectionRepository;
use App\Repository\MentionRepository;
use App\Repository\PartnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class IndexController extends AbstractController
{
    private $partnerRepository;
    private $mentionRepository;
    private $faqSectionRepository;

    public function __construct(
        PartnerRepository $partnerRepository,
        MentionRepository $mentionRepository,
        FaqSectionRepository $faqSectionRepository
    ) {
        $this->partnerRepository = $partnerRepository;
        $this->mentionRepository = $mentionRepository;
        $this->faqSectionRepository = $faqSectionRepository;
    }

    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $isGerman = 'de' === $request->getLocale();

        return $this->render('web/index/index.html.twig', [
            'preregister' => $request->get('registered'),
            'partners' => $this->partnerRepository->findAllOrdered(),
            'mentions' => $this->mentionRepository->findAllOrderedWithLimit(!$isGerman, 8),
            'emailSent' => $request->get('mailSent'),
        ]);
    }

    /**
     * @Route("/faq", name="faq", methods={"GET"})
     */
    public function faq(Request $request): Response
    {
        return $this->render('web/faq/faq.html.twig', [
            'faqSections' => $this->faqSectionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/team", name="faq", methods={"GET"})
     */
    public function team(Request $request): Response
    {
        $team=[
            [
                'firstname' =>'Lukas',
                'lastname' =>'Walkenbach',
                'info' => "Hallo Welt dies ist ein toller test",
                'image' => "1.JPG",
                'linkedin' => 'www.google.de',
                'coreteam' => true,
            ],
            [
                'firstname' =>'Lukas',
                'lastname' =>'Walkenbach',
                'info' => "Hallo Welt dies ist ein toller test",
                'image' => "3.JPG",
                'linkedin' => 'www.google.de',
                'coreteam' => true,
            ],
            [
                'firstname' =>'Lukas',
                'lastname' =>'Walkenbach',
                'info' => "Hallo Welt dies ist ein toller test",
                'image' => "1.JPG",
                'linkedin' => 'www.google.de',
                'coreteam' => false,
            ],
            [
                'firstname' =>'Lukas',
                'lastname' =>'Walkenbach',
                'info' => "Hallo Welt dies ist ein toller test",
                'image' => "2.JPG",
                'linkedin' => 'www.google.de',
                'coreteam' => true,
            ],
            [
                'firstname' =>'Lukas',
                'lastname' =>'Walkenbach',
                'info' => "Hallo Welt dies ist ein toller test",
                'image' => "1.JPG",
                'linkedin' => '',
                'coreteam' => false,
            ],[
                'firstname' =>'Lukas',
                'lastname' =>'Walkenbach',
                'info' => "Hallo Welt dies ist ein toller test",
                'image' => "1.JPG",
                'linkedin' => '',
                'coreteam' => false,
            ],[
                'firstname' =>'Lukas',
                'lastname' =>'Walkenbach',
                'info' => "Hallo Welt dies ist ein toller test",
                'image' => "1.JPG",
                'linkedin' => '',
                'coreteam' => false,
            ],[
                'firstname' =>'Lukas',
                'lastname' =>'Walkenbach',
                'info' => "Hallo Welt dies ist ein toller test",
                'image' => "1.JPG",
                'linkedin' => '',
                'coreteam' => false,
            ],[
                'firstname' =>'Lukas',
                'lastname' =>'Walkenbach',
                'info' => "Hallo Welt dies ist ein toller test",
                'image' => "1.JPG",
                'linkedin' => 'www.google.de',
                'coreteam' => false,
            ],[
                'firstname' =>'Lukas',
                'lastname' =>'Walkenbach',
                'info' => "Hallo Welt dies ist ein toller test",
                'image' => "1.JPG",
                'linkedin' => 'www.google.de',
                'coreteam' => false,

            ],
        ];

        return $this->render('web/team/team.html.twig', [
            'members' => $team,
        ]);
    }
}
