<?php
declare(strict_types=1);

namespace MeetupOrganizing\Controller;

use MeetupOrganizing\Entity\ListMeetupsRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Stratigility\MiddlewareInterface;

final class ListMeetupsController implements MiddlewareInterface
{
    private ListMeetupsRepositoryInterface $repository;

    private TemplateRendererInterface $renderer;

    public function __construct(
        ListMeetupsRepositoryInterface $repository,
        TemplateRendererInterface $renderer
    ) {
        $this->repository = $repository;
        $this->renderer = $renderer;
    }

    public function __invoke(Request $request, Response $response, callable $out = null): ResponseInterface
    {
        $upcomingMeetups = $this->repository->listUpcomingMeetups();
        $pastMeetups = $this->repository->listPastMeetups();

        $response->getBody()->write(
            $this->renderer->render(
                'list-meetups.html.twig',
                [
                    'upcomingMeetups' => $upcomingMeetups->getForView(),
                    'pastMeetups' => $pastMeetups->getForView()
                ]));

        return $response;
    }
}
