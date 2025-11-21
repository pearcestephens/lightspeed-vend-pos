<?php

namespace App\Repositories;

use App\Models\23;
use Illuminate\Database\Eloquent\Collection;

class 23Repository {

    public function findById($id): ?23 {
        return 23::find($id);
    }

    public function getAll(): Collection {
        return 23::all();
    }

    public function create(array $data): 23 {
        return 23::create($data);
    }

    public function update($id, array $data): bool {
        return 23::find($id)->update($data);
    }

    public function delete($id): bool {
        return 23::destroy($id) > 0;
    }
}