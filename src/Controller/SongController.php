<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Song;
use App\Form\SongType;
use App\Repository\AlbumRepository;
use App\Repository\SongRepository;
use App\Song\AddSongToAlbumHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class SongController extends AbstractController
{
    #[Route('/songs', name: 'song_list', methods: ['GET'])]
    public function list(SongRepository $songRepository): Response
    {
        return $this->render('song/list.html.twig', [
            'songs' => $songRepository->findAll(),
        ]);
    }

    #[Route('/album/{id}', name: 'song_show_album', methods: ['GET'])]
    public function showAlbum(int $id, AlbumRepository $albumRepository): Response
    {

        $album = $albumRepository->findWithSongs($id);

        if ($album === null) {
            throw $this->createNotFoundException('Album not found');
        }

        return $this->render('song/show_album.html.twig', [
            'album' => $album,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/album/{id}/add-song', name: 'song_add_to_album', methods: ['GET', 'POST'])]
    public function addSongToAlbum(Album $album, Request $request, AddSongToAlbumHandler $addSongToAlbumHandler): Response
    {
        $form = $this->createForm(SongType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $addSongToAlbumHandler($data, $album);
            return $this->redirectToRoute('song_show_album', ['id' => $album->getId()]);
        }

        return $this->render('song/add_song_to_album.html.twig', [
            'album' => $album,
            'add_song_to_album_form' => $form->createView(),
        ]);
    }

    #[Route('/albums', name: 'song_albums', methods: ['GET'])]
    public function listAlbums(AlbumRepository $albumRepository): Response
    {

        $albums = $albumRepository->findAll();

        return $this->render('song/list_albums.html.twig', [
            'albums' => $albums,
        ]);
    }
}
