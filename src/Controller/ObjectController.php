<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\S3Service;

final class ObjectController extends AbstractController{
    #[Route('/object/download', name: 'app_object_download')]
    public function index(Request $request, S3Service $s3Service): Response
    {
        $bucket = $request->query->get('bucket');
        $key = $request->query->get('key');

        $object = $s3Service->getObject($bucket, $key);
        
        return new Response(
            $object,
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/octet-stream',
                'Content-Disposition' => 'attachment; filename="' . $key . '"'
            ]
        );
    }
}
