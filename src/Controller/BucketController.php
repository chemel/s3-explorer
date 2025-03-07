<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\S3Service;

final class BucketController extends AbstractController{
    #[Route('/buckets', name: 'app_bucket_index')]
    public function index(S3Service $s3Service): Response
    {
        $buckets = $s3Service->getBuckets();

        return $this->render('bucket/index.html.twig', [
            'buckets' => $buckets,
        ]);
    }

    #[Route('/bucket/show', name: 'app_bucket_show')]
    public function show(S3Service $s3Service, Request $request): Response
    {
        $name = $request->query->get('name');

        $objects = $s3Service->getBucketObjects($name);

        return $this->render('bucket/show.html.twig', [
            'objects' => $objects,
        ]);
    }
}
