<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use App\Repository\EpisodeRepository;

class ProgramController extends AbstractController
{
    private ProgramRepository $programRepository;
    private SeasonRepository $seasonRepository;
    private EpisodeRepository $episodeRepository;
    
    public function __construct(
        ProgramRepository $programRepository,
        SeasonRepository $seasonRepository,
        EpisodeRepository $episodeRepository
    ){
        $this->programRepository = $programRepository;
        $this->seasonRepository = $seasonRepository;
        $this->episodeRepository = $episodeRepository;
    }
    
    #[Route('/program/', name: 'program_index')]
    public function index(): Response
    {
        $programs = $this->programRepository->findAll();

        return $this->render('program/index.html.twig', [
            'programs'  => $programs,
         ]);
    }

    #[Route('/program/{id<\d+>}', methods: ['GET'], name: 'program_show')]
    public function show(Program $program):Response
    {
        // $program = $this->programRepository->find($id);
        // same as $program = $programRepository->findOneById($id);
        // same as $program = $programRepository->find($id);
        $seasons = $this->seasonRepository->findBy(['program' => $program]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons,
        ]);
    }

    #[Route('/program/{programId<\d+>}/seasons/{seasonId<\d+>}', methods: ['GET'], name: 'program_season_show')]
    #[Entity('program', options: ['id' => 'programId'])]
    #[Entity('comment', options: ['id' => 'seasonId'])]
    public function showSeason(Program $program, Season $season)
    {
        // $program = $this->programRepository->findOneBy(['id' => $programId]);
        // $season = $this->seasonRepository->findOneBy(['number' => $seasonId]);
        // $episodes = $this->episodeRepository->findBy(['season' => $seasonId]);

        // if (!$episodes) {
        //     throw $this->createNotFoundException(
        //         'No episodes with season_id : '.$seasonId.' found in episode\'s table.'
        //     );
        // }

        return $this->render('program/season_show.html.twig', [
            'program'   => $program,
            'season'    => $season,
            //'episodes'  => $episodes,
        ]);
    }

    #[Route('/program/{programId}/season/{seasonId}/episode/{episodeId}', methods: ['GET'], name: 'program_episode_show')]
    #[Entity('program', options: ['id' => 'programId'])]
    #[Entity('comment', options: ['id' => 'seasonId'])]
    #[Entity('episode', options: ['id' => 'episodeId'])]
    public function showEpisode(Program $program, Season $season, Episode $episode){
        return $this->render('program/episode_show.html.twig', [
            'program'   => $program,
            'season'    => $season,
            'episodes'  => $episodes,
        ]);
    }
}