<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ambta\DoctrineEncryptBundle\Configuration\Encrypted;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TelegramChatRepository")
 */
class TelegramChat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Encrypted
     */
    private $botId;

    /**
     * @ORM\Column(type="string", length=255)
     * @Encrypted
     */
    private $botToken;

    /**
     * @ORM\Column(type="string", length=255)
     * @Encrypted
     */
    private $chatId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MonitoringTask", mappedBy="yes")
     */
    private $monitoringTasks;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    public function __construct()
    {
        $this->monitoringTasks = new ArrayCollection();
    }

    public function __toString()
    {
         return $this->getTitle();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBotId(): ?string
    {
        return $this->botId;
    }

    public function setBotId(string $botId): self
    {
        $this->botId = $botId;

        return $this;
    }

    public function getBotToken(): ?string
    {
        return $this->botToken;
    }

    public function setBotToken(string $botToken): self
    {
        $this->botToken = $botToken;

        return $this;
    }

    public function getChatId(): ?string
    {
        return $this->chatId;
    }

    public function setChatId(string $chatId): self
    {
        $this->chatId = $chatId;

        return $this;
    }

    /**
     * @return Collection|MonitoringTask[]
     */
    public function getMonitoringTasks(): Collection
    {
        return $this->monitoringTasks;
    }

    public function addMonitoringTask(MonitoringTask $monitoringTask): self
    {
        if (!$this->monitoringTasks->contains($monitoringTask)) {
            $this->monitoringTasks[] = $monitoringTask;
            $monitoringTask->setTelegramChat($this);
        }

        return $this;
    }

    public function removeMonitoringTask(MonitoringTask $monitoringTask): self
    {
        if ($this->monitoringTasks->contains($monitoringTask)) {
            $this->monitoringTasks->removeElement($monitoringTask);
            // set the owning side to null (unless already changed)
            if ($monitoringTask->getTelegramChat() === $this) {
                $monitoringTask->setTelegramChat(null);
            }
        }

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
