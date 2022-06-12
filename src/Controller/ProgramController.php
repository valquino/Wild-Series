<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use App\Repository\EpisodeRepository;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

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

    #[Route('/program/{id}/', methods: ['GET'], name: 'program_show')]
    public function show(Program $program, SeasonRepository $seasonRepository): Response
    {
        // $program = $this->programRepository->find($id);
        // same as $program = $programRepository->findOneById($id);
        // same as $program = $programRepository->find($id);
        $seasons = $this->seasonRepository->findBy(['program' => $program]);

        // if (!$program) {
        //     throw $this->createNotFoundException(
        //         'No program with id : '.$id.' found in program\'s table.'
        //     );
        // }
        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons,
        ]);
    }

    #[Route('/program/{program}/seasons/{seasons}/', methods: ['GET'], name: 'program_season_show')]
    public function showSeason(Program $program, Season $season, EpisodeRepository $episodeRepository)
    {
        // $program = $this->programRepository->findOneBy(['id' => $programId]);
        // $season = $this->seasonRepository->findOneBy(['number' => $seasonId]);
        $episodes = $this->episodeRepository->findBy(['season' => $season]);

        // if (!$episodes) {
        //     throw $this->createNotFoundException(
        //         'No episodes with season_id : '.$seasonId.' found in episode\'s table.'
        //     );
        // }

        return $this->render('program/season_show.html.twig', [
            'program'   => $program,
            'season'    => $season,
            'episodes'  => $episodes,
        ]);
    }

    #[Route('/program/{programId}/season/{seasonId}/episode/{episodeId}', methods: ['GET'], name: 'program_episode_show')]
    #[Entity('program', options: ['id' => 'programId'])]
    #[Entity('season', options: ['number' => 'seasonId'])]
    #[Entity('episode', options: ['number' => 'episodeId'])]
    public function showEpisode(Program $programId, Season $seasonId, Episode $episodeId){
        return $this->render('program/episode_show.html.twig', [
            'program'   => $program,
            'season'    => $season,
            'episode'  => $episode,
        ]);
    }
}