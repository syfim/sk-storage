<?php

namespace App\Services;

use App\Entity\MonitoringTask;
use App\Message\TelegramNotification;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class MonitoringService
{
    private $httpClient;
    private $em;
    private $messageBus;

    public function __construct(
        HttpClientInterface $httpClient,
        EntityManagerInterface $em,
        MessageBusInterface $messageBus
    )
    {
        $this->httpClient = $httpClient;
        $this->em = $em;
        $this->messageBus = $messageBus;
    }

    /**
     * @param array $monitoringTasks
     * @param bool $withFlush
     * @return bool
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    public function checkMonitoringTasks(array &$monitoringTasks, bool $withFlush = false): bool
    {
        $data = [];

        /** @var MonitoringTask $task */
        foreach ($monitoringTasks as $task) {    // start async requests
            $data[] = [
                'task' => $task,
                'response' =>  $this->httpClient->request(
                    $task->getRequestMethod(),
                    $task->getUrl()
                )
            ];
        }

        foreach ($data as $datum) {    // start check async responses
            if (!$this->checkResponseIsCorrect($datum['response'], $datum['task'])) {
                $this->messageBus->dispatch(new TelegramNotification($datum['task']->getUrl() . ' не доступен!', $datum['task']->getTelegramChat()));
                dump('error');
            }
        }

        foreach ($monitoringTasks as $task) {
            $task->setLastCheckAt(new DateTime());
            $task->updateNextCheckAt();
            $this->em->persist($task);  // tasks can be new
        }

        if ($withFlush) {
            $this->em->flush();
        }

        return true;
    }

    /**
     * @param ResponseInterface $response
     * @param MonitoringTask $task
     * @return bool
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    private function checkResponseIsCorrect(ResponseInterface $response, MonitoringTask &$task): bool
    {
        if (!empty($task->getExpectedResponseCode())) {
            if ($response->getStatusCode() !== $task->getExpectedResponseCode()) {
                return false;
            }
        }

        if (!empty($task->getExpectedResponseBody())) {
            if ($response->getContent(false) != $task->getExpectedResponseCode()) {
                return false;
            }
        }

        return true;
    }
}