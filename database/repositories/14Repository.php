<?php

namespace App\Repositories;

use App\Models\14;
use Illuminate\Database\Eloquent\Collection;

class 14Repository {

    public function findById($id): ?14 {
        return 14::find($id);
    }

    public function getAll(): Collection {
        return 14::all();
    }

    public function create(array $data): 14 {
        return 14::create($data);
    }

    public function update($id, array $data): bool {
        return 14::find($id)->update($data);
    }

    public function delete($id): bool {
        return 14::destroy($id) > 0;
    }
}