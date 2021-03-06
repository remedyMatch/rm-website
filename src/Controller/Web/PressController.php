<?php

declare(strict_types=1);

namespace App\Controller\Web;

use App\Repository\MentionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PressController extends AbstractController
{
    private $mentionRepository;

    public function __construct(MentionRepository $mentionRepository)
    {
        $this->mentionRepository = $mentionRepository;
    }

    /**
     * @Route({
     *     "/press",
     *     "de": "/presse"
     * }, name="press", methods={"GET"})
     */
    public function press(Request $request): Response
    {
        $germanLast = 'de' !== $request->getLocale();
        $mentions = $this->mentionRepository->findAllOrderedWithLimit($germanLast);

        return $this->render('web/press/press.html.twig', ['mentions' => $mentions]);
    }
}
