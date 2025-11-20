<?php

namespace App\Repositories;

use App\Models\21;
use Illuminate\Database\Eloquent\Collection;

class 21Repository {

    public function findById($id): ?21 {
        return 21::find($id);
    }

    public function getAll(): Collection {
        return 21::all();
    }

    public function create(array $data): 21 {
        return 21::create($data);
    }

    public function update($id, array $data): bool {
        return 21::find($id)->update($data);
    }

    public function delete($id): bool {
        return 21::destroy($id) > 0;
    }
}