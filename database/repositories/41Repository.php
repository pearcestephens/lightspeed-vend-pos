<?php

namespace App\Repositories;

use App\Models\41;
use Illuminate\Database\Eloquent\Collection;

class 41Repository {

    public function findById($id): ?41 {
        return 41::find($id);
    }

    public function getAll(): Collection {
        return 41::all();
    }

    public function create(array $data): 41 {
        return 41::create($data);
    }

    public function update($id, array $data): bool {
        return 41::find($id)->update($data);
    }

    public function delete($id): bool {
        return 41::destroy($id) > 0;
    }
}