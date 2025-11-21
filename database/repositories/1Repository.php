<?php

namespace App\Repositories;

use App\Models\1;
use Illuminate\Database\Eloquent\Collection;

class 1Repository {

    public function findById($id): ?1 {
        return 1::find($id);
    }

    public function getAll(): Collection {
        return 1::all();
    }

    public function create(array $data): 1 {
        return 1::create($data);
    }

    public function update($id, array $data): bool {
        return 1::find($id)->update($data);
    }

    public function delete($id): bool {
        return 1::destroy($id) > 0;
    }
}