<?php

namespace App\Repositories;

use App\Models\2;
use Illuminate\Database\Eloquent\Collection;

class 2Repository {

    public function findById($id): ?2 {
        return 2::find($id);
    }

    public function getAll(): Collection {
        return 2::all();
    }

    public function create(array $data): 2 {
        return 2::create($data);
    }

    public function update($id, array $data): bool {
        return 2::find($id)->update($data);
    }

    public function delete($id): bool {
        return 2::destroy($id) > 0;
    }
}