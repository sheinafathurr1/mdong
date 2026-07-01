<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\Dosen;

class ApplicationPolicy
{
    // Dosen hanya boleh melihat/memutuskan aplikasi yang melamar ke topiknya sendiri
    public function review(Dosen $dosen, Application $application): bool
    {
        return $dosen->dosen_id === $application->topik->dosen_id;
    }
}
