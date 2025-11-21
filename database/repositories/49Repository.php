<?php

namespace App\Repositories;

use App\Models\49;
use Illuminate\Database\Eloquent\Collection;

class 49Repository {

    public function findById($id): ?49 {
        return 49::find($id);
    }

    public function getAll(): Collection {
        return 49::all();
    }

    public function create(array $data): 49 {
        return 49::create($data);
    }

    public function update($id, array $data): bool {
        return 49::find($id)->update($data);
    }

    public function delete($id): bool {
        return 49::destroy($id) > 0;
    }
}