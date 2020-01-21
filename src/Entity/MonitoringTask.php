<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MonitoringTaskRepository")
 */
class MonitoringTask
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="monitoringTasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $expectedResponseCode;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $expectedResponseBody;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastCheckAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $checkIntervalMinutes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $requestMethod;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $nextCheckAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isReportSent;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TelegramChat", inversedBy="monitoringTasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $telegramChat;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $onErrorMessage;

    /**
     * @ORM\Column(type="text")
     */
    private $onBackToStableMessage;

    public function __construct()
    {
        $this->isReportSent = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getExpectedResponseCode(): ?int
    {
        return $this->expectedResponseCode;
    }

    public function setExpectedResponseCode(?int $expectedResponseCode): self
    {
        $this->expectedResponseCode = $expectedResponseCode;

        return $this;
    }

    public function getExpectedResponseBody(): ?string
    {
        return $this->expectedResponseBody;
    }

    public function setExpectedResponseBody(?string $expectedResponseBody): self
    {
        $this->expectedResponseBody = $expectedResponseBody;

        return $this;
    }

    public function getLastCheckAt(): ?DateTimeInterface
    {
        return $this->lastCheckAt;
    }

    public function setLastCheckAt(?DateTimeInterface $lastCheckAt): self
    {
        $this->lastCheckAt = $lastCheckAt;

        return $this;
    }

    public function getCheckIntervalMinutes(): ?int
    {
        return $this->checkIntervalMinutes;
    }

    public function setCheckIntervalMinutes(int $checkIntervalMinutes): self
    {
        $this->checkIntervalMinutes = $checkIntervalMinutes;

        return $this;
    }

    public function getRequestMethod(): ?string
    {
        return $this->requestMethod;
    }

    public function setRequestMethod(string $requestMethod): self
    {
        $this->requestMethod = $requestMethod;

        return $this;
    }

    public function getNextCheckAt(): ?DateTimeInterface
    {
        return $this->nextCheckAt;
    }

    public function setNextCheckAt(?DateTimeInterface $nextCheckAt): self
    {
        $this->nextCheckAt = $nextCheckAt;

        return $this;
    }

    public function getIsReportSent(): ?bool
    {
        return $this->isReportSent;
    }

    public function setIsReportSent(bool $isReportSent): self
    {
        $this->isReportSent = $isReportSent;

        return $this;
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function updateNextCheckAt(): self
    {
        $this->setNextCheckAt(new DateTime('+' . $this->getCheckIntervalMinutes() . ' minutes'));

        return $this;
    }

    public function getTelegramChat(): ?TelegramChat
    {
        return $this->telegramChat;
    }

    public function setTelegramChat(?TelegramChat $telegramChat): self
    {
        $this->telegramChat = $telegramChat;

        return $this;
    }

    public function getOnErrorMessage(): ?string
    {
        return $this->onErrorMessage;
    }

    public function setOnErrorMessage(?string $onErrorMessage): self
    {
        $this->onErrorMessage = $onErrorMessage;

        return $this;
    }

    public function getOnBackToStableMessage(): ?string
    {
        return $this->onBackToStableMessage;
    }

    public function setOnBackToStableMessage(string $onBackToStableMessage): self
    {
        $this->onBackToStableMessage = $onBackToStableMessage;

        return $this;
    }
}
