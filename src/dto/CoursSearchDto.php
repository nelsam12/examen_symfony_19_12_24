<?php
namespace App\dto;


class CoursSearchDto
{
    private ?int $professeurId = null;
    private ?int $niveauId = null;
    private ?int $classeId = null;

    public function getProfesseurId(): ?int
    {
        return $this->professeurId;
    }

    public function setProfesseurId(?int $professeurId): self
    {
        $this->professeurId = $professeurId;
        return $this;
    }

    public function getNiveauId(): ?int
    {
        return $this->niveauId;
    }

    public function setNiveauId(?int $niveauId): self
    {
        $this->niveauId = $niveauId;
        return $this;
    }

    public function getClasseId(): ?int
    {
        return $this->classeId;
    }

    public function setClasseId(?int $classeId): self
    {
        $this->classeId = $classeId;
        return $this;
    }
}