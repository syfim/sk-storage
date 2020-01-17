<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Account", mappedBy="project", orphanRemoval=true)
     */
    private $accounts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MonitoringTask", mappedBy="project", orphanRemoval=true)
     */
    private $monitoringTasks;

    public function __construct()
    {
        $this->accounts = new ArrayCollection();
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Account[]
     */
    public function getAccounts(): Collection
    {
        return $this->accounts;
    }

    public function addAccount(Account $account): self
    {
        if (!$this->accounts->contains($account)) {
            $this->accounts[] = $account;
            $account->setProject($this);
        }

        return $this;
    }

    public function removeAccount(Account $account): self
    {
        if ($this->accounts->contains($account)) {
            $this->accounts->removeElement($account);
            // set the owning side to null (unless already changed)
            if ($account->getProject() === $this) {
                $account->setProject(null);
            }
        }

        return $this;
    }

    public function getTagList():array
    {
        $tags = [];

        foreach ($this->getAccounts() as $account) {
            if (!empty($account->getTag()) && !in_array($account->getTag(), $tags)) {
                $tags[] = $account->getTag();
            }
        }

        return $tags;
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
            $monitoringTask->setProject($this);
        }

        return $this;
    }

    public function removeMonitoringTask(MonitoringTask $monitoringTask): self
    {
        if ($this->monitoringTasks->contains($monitoringTask)) {
            $this->monitoringTasks->removeElement($monitoringTask);
            // set the owning side to null (unless already changed)
            if ($monitoringTask->getProject() === $this) {
                $monitoringTask->setProject(null);
            }
        }

        return $this;
    }
}
