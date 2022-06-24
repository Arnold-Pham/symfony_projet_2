<?php

namespace App\Twig;


use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;


class FiltreExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('deviseFr', [$this, 'deviseFr']),
            new TwigFilter('role', [$this, 'role']),
            new TwigFilter('civilite', [$this, 'civilite']),
        ];
    }

    public function deviseFr(float $prix): string
    {
        return number_format($prix, 0, ",", " ") . " €";
    }

    public function role(array $roles): string
    {
        if (isset($roles[0])) {
            return strtolower(str_replace("ROLE_", "", $roles[0]));
        }

        return '';
    }

    public function civilite(string $civilite): string
    {
        if ($civilite === 'F') {
            return '<i class="bi bi-gender-female text-danger fs-5"></i>';
        }
        return '<i class="bi bi-gender-male text-primary fs-5"></i>';
    }
}
