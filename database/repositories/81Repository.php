<?php

namespace App\Repositories;

use App\Models\81;
use Illuminate\Database\Eloquent\Collection;

class 81Repository {

    public function findById($id): ?81 {
        return 81::find($id);
    }

    public function getAll(): Collection {
        return 81::all();
    }

    public function create(array $data): 81 {
        return 81::create($data);
    }

    public function update($id, array $data): bool {
        return 81::find($id)->update($data);
    }

    public function delete($id): bool {
        return 81::destroy($id) > 0;
    }
}