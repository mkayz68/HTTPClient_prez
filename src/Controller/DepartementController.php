<?php

namespace App\Controller;

use App\Service\CallApiService;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class DepartementController extends AbstractController
{
    /**
     * @Route("/departement{department}", name="departement")
     * @param string $department
     * @param CallApiService $callApiService
     * @param ChartBuilderInterface $chartBuilder
     * @return Response
     * @throws Exception
     */
    public function index(string $department, CallApiService $callApiService, ChartBuilderInterface $chartBuilder): Response
    {
        // tableaux de données
        $label = [];
        $hospitalisation = [];
        $rea = [];

        for ($i=1; $i < 8; $i++) {
            $date = New DateTime('- '. $i .' day');
            $datas = $callApiService->getAllDataByDate($date->format('Y-m-d'));

            foreach ($datas['allFranceDataByDate'] as $data) {
                if( $data['nom'] === $department) {
                    $label[] = $data['date'];
                    $hospitalisation[] = $data['nouvellesHospitalisations'];
                    $rea[] = $data['nouvellesReanimations'];
                    break;
                }
            }
        }

        // chart JS
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
                            'labels' => array_reverse($label),
                            'datasets' => [
                                [
                                    'label' => 'Nouvelles Hospitalisations',
                                    'borderColor' => 'rgb(255, 99, 132)',
                                    'data' => array_reverse($hospitalisation),
                                ],
                                [
                                    'label' => 'Nouvelles entrées en Réa',
                                    'borderColor' => 'rgb(46, 41, 78)',
                                    'data' => array_reverse($rea),
                                ],
                            ],
                        ]);

        $chart->setOptions([/* ... */]);

        // notre return
        return $this->render('departement/index.html.twig', [
            'data' => $callApiService->getDepartmentData($department),
            // envoyer notre tableau chart à la vue
            'chart' => $chart,
        ]);
    }
}
